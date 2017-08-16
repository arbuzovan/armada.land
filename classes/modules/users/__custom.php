<?php

	abstract class __custom_users extends def_module {

		public function clearPhone($phone = false) {
			if (!$phone) {
				return '';
			}
			$result = str_replace(' ', '', $phone);
			$result = str_replace('-', '', $result);
			$result = str_replace('(', '', $result);
			$result = str_replace(')', '', $result);
			$result = str_replace('+', '', $result);
			if ($result[0] = '8') {
				$result[0] = '7';
			}
			return '+'.$result;
		}

		public function validate_login($login, $userId = false, $public = false) {
			$valid = false;
			$login = trim($login);

			$minLength = 1;
			if (!preg_match("/^\S+$/", $login) && $login) {
				$valid = 'Логин не должен содержать пробелы';
			}
			if ($public) {
				$minLength = 3;
				if (mb_strlen($login, 'utf-8') > 40) {
					$valid = 'Слишком большой логин. Логин должен состоять не более, чем из 40 символов';
				}
			}
			if (mb_strlen($login, 'utf-8') < $minLength) {
				$valid = 'Слишком короткий логин. Логин должен состоять не менее, чем из 3х символов';
			}
			if (!$this->checkIsUniqueLogin($login, $userId)) {
				$valid = 'Пользователь с таким логином уже существует';
			}
			return $valid;
		}

		public function validate_password($password, $passwordConfirmation = null, $login = false, $public = false) {
			$valid = false;
			$password = trim($password);

			$minLength = 1;
			if (!preg_match("/^\S+$/", $password) && $password) {
				$valid = 'Пароль не должен содержать пробелы';
			}
			if ($login && ($password == trim($login))) {
				$valid = 'Пароль не должен совпадать с логином';
			}
			if ($public) {
				$minLength = 3;
				if (!is_null($passwordConfirmation)) {
					if ($password != $passwordConfirmation) {
						$valid = 'Введеные пароли не совпадают';
					}
				}
			}
			if (mb_strlen($password, 'utf-8') < $minLength) {
				$valid = 'Слишком короткий пароль. Пароль должен состоять не менее, чем из 3х символов';
			}
			return $valid;
		}

		public function validate_email($email, $userId = false, $requireActivation = true) {
			$valid = false;
			$email = strtolower(trim($email));

			if($email) {
				if (!umiMail::checkEmail($email)) {
					$valid = 'Неверный формат e-mail';
				}
				if (!$this->checkIsUniqueEmail($email, $userId)) {
					$valid = 'Пользователь с таким e-mail уже существует';
				}
			} else {
				if ($requireActivation) {
					$valid = 'Не указан адрес e-mail';
				}
				return $valid;
			}
		}


		/* --------------------------------------------------------------------*/
		/* -------- Изменение пароля / E-mail ---------*/
		/* --------------------------------------------------------------------*/

		public function saving() {
			$method = getRequest('method');
			$current_password = getRequest('current_password');

			$permissions = permissionsCollection::getInstance();
			$objects = umiObjectsCollection::getInstance();

			$user_id = $permissions->getUserId();
			$user = $objects->getObject($user_id);

			if($user instanceof umiObject == false) {
				return Array('success' => false, 'message' => 'Ошибка получения данных пользователя');
			}

			if (md5($current_password) != $user->getValue("password")) {
				return Array('success' => false, 'message' => 'Неверный текущий пароль пользователя');
			}

			$success = true;
			
			switch($method) {
				case 'edit_password':
					$password = getRequest('password');
					$password_confirm = getRequest('password_confirm');

					$validate_password = $this->validate_password($password, $password_confirm, $login, true);
					if($validate_password){
						$answerMessage = $validate_password;
						$success = false;
					} else {
						$user->setValue("password", md5($password));
						$user->commit();
						$permissions = permissionsCollection::getInstance();
						$permissions->loginAsUser($user);
						$session = session::getInstance();

						if ($permissions->isAdmin($user->id)) {
							$session->set('csrf_token', md5(rand() . microtime()));
							if ($permissions->isSv($user->id)) {
								$session->set('user_is_sv', true);
							}
						}

						$session->setValid();
						session::commit();
						system_runSession();

						$answerMessage = 'Пароль успешно изменен';
					}
					break;

				case 'edit_email':
					$email = getRequest('email');
					$email_confirm = getRequest('email_confirm');

					$validate_email = $this->validate_email($email, false, false);
					$validate_email_confirm = $this->validate_email($email, false, false);

					if(!umiMail::checkEmail($email) || !umiMail::checkEmail($email_confirm)) {
						$answerMessage = 'Неверный формат e-mail';
						$success = false;
					}
					if($email != $email_confirm && $success){
						$answerMessage = 'E-mail адреса не совпадают';
						$success = false;
					}
					if ($success) {
						$user->setValue("e-mail", $email);
						$user->commit();
						$answerMessage = 'E-mail успешно изменен. Для обновления информации перезагрузите страницу';
					}
					break;
			}

			return Array('success' => $success, 'message' => $answerMessage);

		}


		/* --------------------------------------------------------------------*/
		/* -------- Авторизация / Регистрация / Восстановление пароля ---------*/
		/* --------------------------------------------------------------------*/

		public function enter() {
			$login = getRequest('login');
			$rawPassword = getRequest('password');
			$from_page = getRequest('from_page');

			$cmsController = cmsController::getInstance();
			$auth = UmiCms\Service::Auth();
			$userId = $auth->checkLogin($login, $rawPassword);
			$user = umiObjectsCollection::getInstance()->getObject($userId);

			if ($user instanceof iUmiObject) {
				if (\UmiCms\Service::Session()->get('fake-user') == 1) {
					return ($this->restoreUser(true)) ? $this->auth() : $res;
				}

				$hashedPassword = $user->getValue('password');
				$hashAlgorithm =  UmiCms\Service::PasswordHashAlgorithm();

				if ($hashAlgorithm->isHashedWithMd5($hashedPassword, $rawPassword)) {
					$hashedPassword = $hashAlgorithm->hash($rawPassword, $hashAlgorithm::SHA256);
					$user->setValue('password', $hashedPassword);
					$user->commit();
				}

				$auth->loginUsingId($user->getId());

				$oEventPoint = new umiEventPoint("users_login_successfull");
				$oEventPoint->setParam("user_id", $user->id);
				users::setEventPoint($oEventPoint);

				if ($cmsController->getCurrentMode() == "admin") {
					ulangStream::getLangPrefix();
					system_get_skinName();
				} else {
					if (!$from_page) {
						$from_page = getServer('HTTP_REFERER');
					}
				return Array('success' => true, 'redirect' => true, 'redirect_url' => '/users/common/');
				}
			} else {
				$oEventPoint = new umiEventPoint("users_login_failed");
				$oEventPoint->setParam("login", $login);
				$oEventPoint->setParam("password", $rawPassword);
				self::setEventPoint($oEventPoint);
				return Array('success' => false, 'message' => 'Неверный логин или пароль');
			}

			return "";
		}

		public function registration() {
			$login = 				trim(htmlspecialchars(getRequest('login')));
			$password = 			trim(htmlspecialchars(getRequest('password')));
			$password_confirm = 	trim(htmlspecialchars(getRequest('password_confirm')));
			$email = 				trim(htmlspecialchars(getRequest('email')));
			$template = 			trim(htmlspecialchars(getRequest('template')));
			$full_name = 			trim(htmlspecialchars(getRequest('full_name')));
			$phone =				trim(htmlspecialchars(getRequest('phone')));
			$area_number =			trim(htmlspecialchars(getRequest('area_number')));

			$refererUrl = getServer('HTTP_REFERER');
			$regedit = regedit::getInstance();
			$without_act = (bool) $regedit->getVal("//modules/users/without_act");
			$error = false;
			
			$validate_login = $this->validate_login($login, false, true);
			if($validate_login && !$error){
				$errorMessage = $validate_login;
				$error = true;
			}

			$validate_password = $this->validate_password($password, $password_confirm, $login, true);
			if($validate_password && !$error){
				$errorMessage = $validate_password;
				$error = true;
			}
			
			$validate_email = $this->validate_email($email, false, !$without_act);
			if($validate_password && !$error){
				$errorMessage = $validate_password;
				$error = true;
			}

			if(empty($full_name) && !$error){
				$errorMessage = 'Поле &laquo;ФИО&raquo; не заполнено';
				$error = true;
			}
			if(empty($phone) && !$error){
				$errorMessage = 'Поле &laquo;Телефон&raquo; не заполнено';
				$error = true;
			}
			if(empty($area_number) && !$error){
				$errorMessage = 'Поле &laquo;Номер участка&raquo; не заполнено';
				$error = true;
			}
			
			$arrName = explode(' ', $full_name);
			$lname = $arrName[0];
			$fname = $arrName[1];
			$father_name = $arrName[2];

			if ($error) {
				return Array('success' => false, 'message' => $errorMessage);
			}

			$objectTypes = umiObjectTypesCollection::getInstance();

			$objectTypeId = $objectTypes->getTypeIdByHierarchyTypeName("users", "user");
			if ($customObjectTypeId = getRequest('type-id')) {
				$childClasses = $objectTypes->getChildTypeIds($objectTypeId);
				if (in_array($customObjectTypeId, $childClasses)) {
					$objectTypeId = $customObjectTypeId;
				}
			}

			$objectType = $objectTypes->getType($objectTypeId);

			$objectId = umiObjectsCollection::getInstance()->addObject($login, $objectTypeId);
			$activationCode = md5($login . time());

			$object = umiObjectsCollection::getInstance()->getObject($objectId);

			$object->setValue("login", $login);
			$object->setValue("password", md5($password));
			$object->setValue("e-mail", $email);
			$object->setValue("fname", $fname);
			$object->setValue("lname", $lname);
			$object->setValue("father_name", $father_name);
			$object->setValue("phone", $phone);
			$object->setValue("area_number", $area_number);
			
			$object->setValue("is_activated", $without_act);
			$object->setValue("activate_code", $activationCode);
			$object->setValue("referer", urldecode(getSession("http_referer")));
			$object->setValue("target", urldecode(getSession("http_target")));
			$object->setValue("register_date", umiDate::getCurrentTimeStamp());
			$object->setOwnerId($objectId);

			if ($without_act) {
				$_SESSION['cms_login'] = $login;
				$_SESSION['cms_pass'] = md5($password);
				$_SESSION['user_id'] = $objectId;
				session_commit();
			}

			$group_id = regedit::getInstance()->getVal("//modules/users/def_group");
			$object->setValue("groups", Array($group_id));

			cmsController::getInstance()->getModule('data');
			$data_module = cmsController::getInstance()->getModule('data');
			$data_module->saveEditedObjectWithIgnorePermissions($objectId, true, true);

			$object->commit();

			if ($eshop_module = cmsController::getInstance()->getModule('eshop')) {
				$eshop_module->discountCardSave($objectId);
			}

			list($template_mail, $template_mail_subject, $template_mail_noactivation, $template_mail_subject_noactivation
			) = def_module::loadTemplatesForMail("users/register/".$template,"mail_registrated", "mail_registrated_subject", "mail_registrated_noactivation", "mail_registrated_subject_noactivation");

			if ($without_act && $template_mail_noactivation && $template_mail_subject_noactivation) {
				$template_mail = $template_mail_noactivation;
				$template_mail_subject = $template_mail_subject_noactivation;
			}

			$mailData = array(
				'user_id' => $objectId,
				'domain' => $domain = cmsController::getInstance()->getCurrentDomain()->getCurrentHostName(),
				'activate_link' => getSelectedServerProtocol() . "://" . $domain . $this->pre_lang . "/users/activate/" . $activationCode . "/",
				'login' => $login,
				'password' => $password,
				'lname' => $object->getValue("lname"),
				'fname' => $object->getValue("fname"),
				'father_name' => $object->getValue("father_name"),
			);

			$mailContent = def_module::parseTemplateForMail($template_mail, $mailData, false, $objectId);
			$mailSubject = def_module::parseTemplateForMail($template_mail_subject, $mailData, false, $objectId);

			$fio = $object->getValue("lname") . " " . $object->getValue("fname") . " " . $object->getValue("father_name");

			$email_from = regedit::getInstance()->getVal("//settings/email_from");
			$fio_from = regedit::getInstance()->getVal("//settings/fio_from");

			$registrationMail = new umiMail();
			$registrationMail->addRecipient($email, $fio);
			$registrationMail->setFrom($email_from, $fio_from);
			$registrationMail->setSubject($mailSubject);
			$registrationMail->setContent($mailContent);
			$registrationMail->commit();
			$registrationMail->send();

			$oEventPoint = new umiEventPoint("users_registrate");
			$oEventPoint->setMode("after");
			$oEventPoint->setParam("user_id", $objectId);
			$oEventPoint->setParam("login", $login);
			$this->setEventPoint($oEventPoint);

			return Array('success' => true, 'message' => 'Регистрация прошла успешно. На указанный e-mail отправлено письмо с инструкциями по активации аккаунта.');
		}

		public function restorep($template = 'default') {

			$forget_login = (string) getRequest('forget_login');
			$hasLogin = strlen($forget_login) != 0;

			$user_id = false;

			list($template_mail) = def_module::loadTemplatesForMail("users/forget/".$template, "mail_verification");

			if ($hasLogin) {
				$sel = new selector('objects');
				$sel->types('object-type')->name('users', 'user');
				if($hasLogin) {
					$sel->where('login')->equals($forget_login);
					$sel->where('e-mail')->equals($forget_login);
					$sel->option('or-mode')->fields('login','e-mail'); 
				}
				$sel->limit(0, 1);

				$user_id = ($sel->first) ? $sel->first->id : false;
			}
			else $user_id = false;

			if ($user_id) {
				$activate_code = md5(def_module::getRandomPassword());

				$object = umiObjectsCollection::getInstance()->getObject($user_id);

				$regedit = regedit::getInstance();
				$without_act = (bool) $regedit->getVal("//modules/users/without_act");
				if ($without_act || intval($object->getValue('is_activated'))) {
					$object->setValue("activate_code", $activate_code);
					$object->commit();

					$email = $object->getValue("e-mail");
					$fio = $object->getValue("lname") . " " . $object->getValue("fname") . " " . $object->getValue("father_name");

					$email_from = regedit::getInstance()->getVal("//settings/email_from");
					$fio_from = regedit::getInstance()->getVal("//settings/fio_from");

					$mail_arr = Array();
					$mail_arr['domain'] = $domain = $_SERVER['HTTP_HOST'];
					$mail_arr['restore_link'] = getSelectedServerProtocol() . "://" . $domain . $this->pre_lang . "/?activate_code=" . $activate_code;
					$mail_arr['login'] = $object->getValue('login');
					$mail_arr['email'] = $object->getValue('e-mail');

					$mail_content = def_module::parseTemplateForMail($template_mail, $mail_arr, false, $user_id);

					$someMail = new umiMail();
					$someMail->addRecipient($email, $fio);
					$someMail->setFrom($email_from, $fio_from);
					$someMail->setSubject('Восстановление пароля');
					$someMail->setContent($mail_content);
					$someMail->commit();
					$someMail->send();

					return Array('success' => true, 'message' => 'На e-mail адрес, указанный Вами при регистрации, был выслан пароль');

				} else {

					return Array('success' => false, 'message' => 'Пользователь с переданным логином на данный момент не активирован. Возможно, Вы не провели активацию пользователя после регистрации или модератор не подтвердил Ваш аккаунт');
				}

			} else {

				return Array('success' => false, 'message' => 'Пользователя с таким логином или e-mail не существует');

			}
		}

		/* --------------------------------------------------------------------*/
		/* ------------------ Страницы квитанций и показаний ------------------*/
		/* --------------------------------------------------------------------*/

		public function getDateRu($time) {
			$month = date('n', $time);
			$year = date('Y', $time);
			if (!checkdate($month, 1, $year)) {
				throw new publicException("Проверьте порядок ввода даты");
			}
			$months_ru = array(1 => 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
			$date_ru = $months_ru[$month] . ' ' . $year;
			return $date_ru;  
		}

		public function getReceipts($user_id = false, $template = "default", $limit = 5, $offset = 0) {

			if (!$user_id) {
				return 'user id is not set';
			}

			list($template_block, $template_block_empty, $template_item, $template_item_row) = def_module::loadTemplates("users/profile/".$template, "receipts_block", "receipts_block_empty", "receipts_item", "receipts_item_row");

			$sel = new selector('objects');            
			$sel->types('object-type')->id(125);
			$sel->where('sobstvennik')->equals($user_id);
			$sel->order('id')->desc();
			$sel->limit($offset, $limit);

			if ($sel->length > 0) {

				$field_key = Array(
					'upravlenie' 			=> 'Управление', 
					'soderzhanie' 			=> 'Содержание', 
					'ohrana' 				=> 'Охрана', 
					'vyvoz' 				=> 'Вывоз ТБО', 
					'elenergiya_den' 		=> 'Эл.энергия (день)', 
					'elenergiya_noch' 		=> 'Эл.энергия (ночь)', 
					'elenergiya_mop_den' 	=> 'Эл.энергия МОП (день)', 
					'elenergiya_mop_noch' 	=> 'Эл.энергия МОП (ночь)', 
					'uslugi_po_zayavkam' 	=> 'Услуги по заявкам', 
					'peni' 					=> 'Пени', 
					'uslbanka' 				=> 'Усл.банка'
				);

				
				$items_arr = Array();
				$item_arr = Array();

				foreach ($sel->result as $receipt) {

					$rows_arr = Array();
					$number = 1;
					$itogoStoimost = 0;
					$itogoLgota = 0;
					$itogoPereraschet = 0;
					$itogoSumma = 0;

					foreach ($field_key as $key => $title) {

						$tarif = $receipt->getValue($key.'_tarif');
						$normativ = $receipt->getValue($key.'_normativ');
						$lgota = 0 - $receipt->getValue($key.'_lgota');
						$pereraschet = 0 - $receipt->getValue($key.'_pereraschet');
						$stoimost = $normativ == 0 ? $tarif : $tarif * $normativ;
						$summa = $stoimost + $lgota + $pereraschet;

						$itogoStoimost += $stoimost;
						$itogoLgota += $lgota;
						$itogoPereraschet += $pereraschet;
						$itogoSumma += $summa;
						
						$row_arr = Array();
						$row_arr['attribute:number'] = $number;
						$row_arr['attribute:title'] = $title;
						$row_arr['attribute:tarif'] = number_format($tarif, 2, ',', ' ');
						$row_arr['attribute:normativ'] = number_format($normativ, 2, ',', ' ');
						$row_arr['attribute:stoimost'] = number_format($stoimost, 2, ',', ' ');
						$row_arr['attribute:lgota'] = number_format($lgota, 2, ',', ' ');
						$row_arr['attribute:pereraschet'] = number_format($pereraschet, 2, ',', ' ');
						$row_arr['attribute:summa'] = number_format($summa, 2, ',', ' ');

						$number++;
						$rows_arr[] = def_module::parseTemplate($template_item_row, $row_arr);
					}
					
					$item_arr = Array();
					$item_arr['subnodes:rows'] = $rows_arr;
					$item_arr['attribute:itogoStoimost'] = number_format($itogoStoimost, 2, ',', ' ');
					$item_arr['attribute:itogoLgota'] = number_format($itogoLgota, 2, ',', ' ');
					$item_arr['attribute:itogoPereraschet'] = number_format($itogoPereraschet, 2, ',', ' ');
					$item_arr['attribute:itogoSumma'] = number_format($itogoSumma, 2, ',', ' ');
					$item_arr['attribute:date'] = self::getDateRu(strtotime($receipt->getValue('date')));
					
					$items_arr[] = def_module::parseTemplate($template_item, $item_arr);
				}

				$block_arr = Array();
				$block_arr['subnodes:items'] = $items_arr;

				return def_module::parseTemplate($template_block, $block_arr);

			} else {

				$block_arr = Array();
				return def_module::parseTemplate($template_block_empty, $block_arr);

			}
		}

		public function getMeters($user_id = false, $template = "default", $limit = 15, $offset = 0) {

			if (!$user_id) {
				return 'user id is not set';
			}

			list($template_block, $template_block_empty, $template_item) = def_module::loadTemplates("users/profile/".$template, "meters_block", "meters_block_empty", "meters_item");

			$sel = new selector('objects');            
			$sel->types('object-type')->id(127);
			$sel->where('sobstvennik')->equals($user_id);
			$sel->order('id')->desc();
			$sel->limit($offset, $limit);

			$items_arr = Array();
			$number = 1;

			if ($sel->length > 0) {
				foreach ($sel->result as $meters) {

					$groupFields = $meters->getPropGroupByName('indications');
					$metersDate = self::getDateRu(strtotime($meters->getValue('date')));

					foreach ($groupFields as $field_id) {

						$field = umiFieldsCollection::getInstance()->getField($field_id);
						$fieldName = $field->getName();

						$item_arr = Array();
						$item_arr['attribute:number'] = $number;
						$item_arr['attribute:date'] = $metersDate;
						$item_arr['attribute:id'] = $meters->id;
						$item_arr['attribute:title'] = $field->getTitle();
						$item_arr['attribute:field_name'] = $fieldName;
						$item_arr['attribute:value'] = number_format($meters->getValue($fieldName), 2, ',', ' ');
						$number++;
						$items_arr[] = def_module::parseTemplate($template_item, $item_arr);
					}

				}

				$block_arr = Array();
				$block_arr['attribute:date'] = $metersDate;
				$block_arr['items'] = $items_arr;

				return def_module::parseTemplate($template_block, $block_arr);

			} else {

				$block_arr = Array();
				return def_module::parseTemplate($template_block_empty, $block_arr);

			}
		}

		public function getMetersPreview($item_id = false, $field_name = false, $template = 'default') {
			if (!$item_id || !$field_name) {
				return '';
			}

			$sel = new selector('objects');            
			$sel->types('object-type')->id(127);
			$sel->where('sobstvennik')->equals($user_id = $this->user_id);
			$sel->where('id')->less($item_id);
			$sel->order('id')->desc();
			$sel->limit(0, 1);

			list($template_block, $template_block_empty) = def_module::loadTemplates("users/profile/".$template, "meters_preview_item", "meters_preview_item_empty");

			$block_arr = Array();
			
			if ($sel->length > 0) {
				$block_arr['attribute:date'] = self::getDateRu(strtotime($sel->result[0]->date));
				$block_arr['attribute:value'] = number_format($sel->result[0]->getValue($field_name), 2, ',', ' ');
				return def_module::parseTemplate($template_block, $block_arr);
			} else {
				return def_module::parseTemplate($template_block_empty, $block_arr);
			}
		}

		public function common() {

			$user_id = $this->user_id;

			list($page_template) = def_module::loadTemplates("users/profile/common", "page_template");

			$page_arr = Array();
			$page_arr['attribute:user_id'] = $user_id;
			return def_module::parseTemplate($page_template, $page_arr);
		}

		public function accruals() {

			$user_id = $this->user_id;

			list($page_template) = def_module::loadTemplates("users/profile/accruals", "page_template");

			$page_arr = Array();
			$page_arr['attribute:user_id'] = $user_id;
			return def_module::parseTemplate($page_template, $page_arr);
		}

		public function meters() {

			$user_id = $this->user_id;

			list($page_template) = def_module::loadTemplates("users/profile/meters", "page_template");

			$page_arr = Array();
			$page_arr['attribute:user_id'] = $user_id;
			return def_module::parseTemplate($page_template, $page_arr);
		}
                
		public function tarifs() {

			$tarifs_guide_id = 131;

			list($page_template) = def_module::loadTemplates("users/profile/tarifs", "page_template");

			$page_arr = Array();
			$page_arr['attribute:tarifs_guide_id'] = $tarifs_guide_id;
			return def_module::parseTemplate($page_template, $page_arr);
		}
                
                /* Выводим таблицу для редактирования тарифов */
                public function getTarifs($tarifGuideId = false, $template = 'tarifs'){
                    if(!$tarifGuideId){
                        return false;
                    }
                    $objectsCollection = umiObjectsCollection::getInstance();
                    $tarifs = $objectsCollection->getGuidedItems($tarifGuideId);
                    
                    list($tarifs_grid, $tarifs_grid_line) = def_module::loadTemplates("users/profile/".$template, "tarifs_grid", "tarifs_grid_line");
                    
                    $tarifs_obects = array();
                    
                    foreach($tarifs as $id => $tarifObject){
                        $tarifObject = $objectsCollection->getObject($id);
                        $tarifs_obects[$tarifObject->view_order] = $tarifObject;
                    }
                    
                    ksort($tarifs_obects);
                    
                    $item_arr = [];
                    $tarifs_arr = [];
                    foreach($tarifs_obects as $key => $tarifObject){
                        $tarif = [];
                        $tarif['attribute:id'] = $tarifObject->id;
                        $tarif['attribute:number'] = $key;
                        $tarif['attribute:name'] = $tarifObject->name;
                        $tarif['attribute:tarif'] = number_format($tarifObject->tarif, 2, ',', ' ');
                        $tarifs_arr[] = def_module::parseTemplate($tarifs_grid_line, $tarif);
                        
                    }
                    $item_arr['subnodes:lines'] = $tarifs_arr;
                    
                    return def_module::parseTemplate($tarifs_grid, $item_arr);
                }
                
		/* --------------------------------------------------------------------*/
		/* -------------------------- Страницы оплаты -------------------------*/
		/* --------------------------------------------------------------------*/

		public function getHistoryPayments($user_id = false, $template = "default", $limit = 50, $offset = 0) {

			if (!$user_id) {
				return 'user id is not set';
			}

			list($template_block, $template_block_empty, $template_item) = def_module::loadTemplates("users/profile/" . $template, "payments_block", "payments_block_empty", "payments_item");

			$sel = new selector('objects');            
			$sel->types('object-type')->id(126);
			$sel->where('sobstvennik')->equals($user_id);
			$sel->order('id')->desc();
			$sel->limit($offset, $limit);

			$block_arr = Array();
			$items_arr = Array();

			if ($sel->length > 0) {

				foreach ($sel as $payment) {

					$item_arr = Array();
					$item_arr['attribute:number'] = $payment->name;
					$item_arr['attribute:id'] = $payment->id;
					$item_arr['attribute:date'] = date('d.m.Y H:i', strtotime($payment->getValue('date')));
					$item_arr['attribute:saldo_na_nachalo'] = number_format($payment->getValue('saldo_na_nachalo'), 2, ',', ' ');
					$item_arr['attribute:summa_platezha'] = number_format($payment->getValue('summa_platezha'), 2, ',', ' ');
					$item_arr['attribute:saldo_na_konec'] = number_format($payment->getValue('saldo_na_konec'), 2, ',', ' ');
					$items_arr[] = def_module::parseTemplate($template_item, $item_arr);
				
				}

				$block_arr['items'] = $items_arr;
				return def_module::parseTemplate($template_block, $block_arr);

			} else {

				return def_module::parseTemplate($template_block_empty, $block_arr);

			}
		}

		public function getUserBalance($user_id = false, $template = "default", $onlyValue = false) {

			if (!$user_id) {
				return 'user id is not set';
			}

			list($balance_minus, $balance_plus) = def_module::loadTemplates("users/profile/" . $template, "balance_minus", "balance_plus");

			$sel = new selector('objects');            
			$sel->types('object-type')->id(125);
			$sel->where('sobstvennik')->equals($user_id);

			$totalSumma = 0;
			$field_key = Array('upravlenie', 'soderzhanie', 'ohrana', 'vyvoz', 'elenergiya_den', 'elenergiya_noch', 'elenergiya_mop_den', 'elenergiya_mop_noch', 'uslugi_po_zayavkam', 'peni', 'uslbanka');

			if ($sel->length > 0) {
				
				foreach ($sel->result as $receipt) {

					$itogoSumma = 0;

					foreach ($field_key as $key) {

						$tarif = $receipt->getValue($key.'_tarif');
						$normativ = $receipt->getValue($key.'_normativ');
						$lgota = 0 - $receipt->getValue($key.'_lgota');
						$pereraschet = 0 - $receipt->getValue($key.'_pereraschet');
						$stoimost = $normativ == 0 ? $tarif : $tarif * $normativ;
						$summa = $stoimost + $lgota + $pereraschet;
						$itogoSumma += $summa;

					}

					$totalSumma += round($itogoSumma, 2);
				}
			}

			$payments = new selector('objects');            
			$payments->types('object-type')->id(126);
			$payments->where('sobstvennik')->equals($user_id);

			foreach ($payments as $payment) {
				$totalSumma -= $payment->getValue('summa_platezha');
			}

			if ($onlyValue) {
				if ($totalSumma < 0) {
					return $totalSumma * -1;
				} else {
					return $totalSumma;
				}
			}

			$block = array();

			if ($totalSumma < 0) {

				$block['attribute:total'] = number_format(($totalSumma*-1), 2, ',', ' ');
				return def_module::parseTemplate($balance_plus, $block);

			} else {

				$block['attribute:total'] = number_format($totalSumma, 2, ',', ' ');
				return def_module::parseTemplate($balance_minus, $block);

			}
		}

		public function payments() {

			$user_id = $this->user_id;

			$action = getRequest('param0');
			$orderId = getRequest('orderId');
			$amount = getRequest('amount');

			if ($action == 'success' && $orderId != '' && $amount != '') {

				$history = new selector('objects');            
				$history->types('object-type')->id(126);
				$history->where('sobstvennik')->equals($user_id);
				$history->where('name')->equals($orderId);

				if ($history->length == 0) {

					$objects = umiObjectsCollection::getInstance();
					$paymentId = $objects->addObject($orderId, 126);
					$payment = $objects->getObject($paymentId);

					if($payment instanceof umiObject) {
						$totalBegin = self::getUserBalance($user_id, 'default', true);
						$payment->setValue('saldo_na_nachalo', $totalBegin);
						$payment->setValue('summa_platezha', $amount);
						$payment->setValue('saldo_na_konec', $totalBegin - $amount);
						$payment->setValue('date', time());
						$payment->setValue('sobstvennik', $user_id);
						$payment->commit();

					}

				}

				$ini = cmsController::getInstance()->getModule("content");
				$ini->redirect('/users/payments/');

			}

			if ($action == 'fail') {
				list($page_template) = def_module::loadTemplates("users/profile/payments", "payments_fail");

				$page_arr = Array();
				$page_arr['attribute:user_id'] = $user_id;
				
				if (isset($amount) && $amount > 0) {
					$page_arr['attribute:amount'] = $amount;
				}
				
				return def_module::parseTemplate($page_template, $page_arr);
			}

			list($page_template) = def_module::loadTemplates("users/profile/payments", "page_template");

			$page_arr = Array();
			$page_arr['attribute:user_id'] = $user_id;

			return def_module::parseTemplate($page_template, $page_arr);
		}

		public function gotopay() {

			$customer_id = permissionsCollection::getInstance()->getUserId();
			$customer = umiObjectsCollection::getInstance()->getObject($customer_id);

			$merchant_key 		= '111111'; //work - b3391886d24b9f416e5a8aaa710d4bd036a618664eba27aeefa693f1c2b6f6ed | demo - 111111
			$market_place_id 	= '69724427';
			$oos_payment_page 	= 'https://oosdemo.pscb.ru/pay/';
			$amount 			= getRequest('amount');
			$orderId 			= date('mdi-').rand(0,9).rand(0,9).rand(0,9).rand(0,9);

			$message = array(
				'amount' => $amount,
				'details' => 'Пополнение счета #' . $customer->getValue('payment_number'),
				'customerRating' => '5',
				'successUrl' => 'http://'.$_SERVER['HTTP_HOST'].'/users/payments/success/?amount='.$amount,
				'customerAccount' => $customer_id,
				'orderId' => $orderId,
				'paymentMethod' => '',
				'customerPhone' => self::clearPhone($customer->getValue('phone')),
				'customerEmail' => $customer->getValue('e-mail')
			);

			$messageText = json_encode($message);

			$formParams = array(
			    "marketPlace" => $market_place_id,
			    "message" => base64_encode($messageText),
			    "signature" => hash('sha256', $messageText . $merchant_key)
			);

			print '
				<div class="request-answer">
					<div class="payment-description">После нажатия на кнопку &laquo;Оплатить&raquo;, Вы будете перенаправлены на страницу банка-эмитента.<br /><strong>Сумма к оплате: '.$amount.' рублей</strong></div>
					<form method="post" action="'.$oos_payment_page.'" id="gotopay-form">
					    <input type="hidden" name="marketPlace" value="'.$formParams['marketPlace'].'">
					    <input type="hidden" name="message" value="'.$formParams['message'].'">
					    <input type="hidden" name="signature" value="'.$formParams['signature'].'">
					    <input type=submit value="Оплатить">
					</form>
				</div>
			';

			return "";
		}

                // Показ меню для сотрудников
                public function getStaffMenu($template = 'accountMenuStaff'){
                    // Получаем id текущего пользователя, если Вы передадите id Гостя, то ничего не увидите, т.к. Гость не имеет группы.
                    $user_id = $this->user_id;
                    
                    // Получаем объект пользователя
                    $user_object = umiObjectsCollection::getInstance()->getObject($user_id);
                    // Получаем группы, в которую входит пользователь
                    $groups = $user_object->getValue("groups");
                    
                    // Временно выставлено непосредственно на ID пользователя. Надо переделать на группу
                    if($user_id == '1110'){
                        
                        list($template_menu) = def_module::loadTemplates("users/".$template, "moderator");
                        
                        return $template_menu;
                    }

                    return;
                }
                
	};
	
?>