<?php
	/**
	 * Класс методов для клиентского и административного режимов
	 */
	class UsersCommon {
		/**
		 * @var users $module
		 */
		public $module;

		/**
		 * Выводит форму авторизации
		 * @param string $template имя шаблона для tpl шаблонизатора
		 * @return mixed
		 */
		public function login($template = "default") {
			if (!$template) {
				$template = "default";
			}

			$from_page = getRequest('from_page');

			if (!$from_page) {
				$from_page = getServer('REQUEST_URI');
			}

			if (defined("CURRENT_VERSION_LINE") && CURRENT_VERSION_LINE == 'demo') {
				list($template_login) = users::loadTemplates("users/" . $template, "login_demo");
			} else {
				list($template_login) = users::loadTemplates("users/" . $template, "login");
			}

			$block_arr = Array();
			$block_arr['from_page'] = users::protectStringVariable($from_page);

			return users::parseTemplate($template_login, $block_arr);
		}

		/**
		 * Выводит форму авторизации для пользователя либо информацию об авторизованном пользователе
		 * @param string $template имя шаблона для tpl шаблонизатора
		 * @return mixed|void
		 */
		public function auth($template = "default") {
			if (!$template) {
				$template = "default";
			}

			if ($this->module->is_auth()) {
				if (cmsController::getInstance()->getCurrentMode() == "admin") {
					$this->module->redirect($this->module->pre_lang . "/admin/");
				} else {
					list($template_logged) = users::loadTemplates("users/".$template, "logged");

					$block_arr = Array();
					$block_arr['xlink:href'] = "uobject://" . $this->module->user_id;
					$block_arr['user_id'] = $this->module->user_id;
					$block_arr['user_name'] = $this->module->user_fullname;
					$block_arr['user_login'] = $this->module->user_login;

					return users::parseTemplate($template_logged, $block_arr, false, $this->module->user_id);
				}
			}

			return $this->login($template);
		}

		/**
		 * Авторизует пользователя
		 * @return mixed|string
		 * @throws publicAdminException если авторизация не удалась через административную панель
		 */
		public function login_do() {
			$res = "";
			$login = getRequest('login');
			$password = getRequest('password');
			$from_page = getRequest('from_page');

			if (strlen($login) == 0) {
				return $this->auth();
			}

			$permissions = permissionsCollection::getInstance();
			$cmsController = cmsController::getInstance();

			$user = $permissions->checkLogin($login, $password);

			if ($user instanceof iUmiObject) {
				/* @var iUmiObject|iUmiEntinty $user */

				if (getSession('fake-user') == 1) {
					return ($this->module->restoreUser(true)) ? $this->auth() : $res;
				}

				$permissions->loginAsUser($user);

				$session = session::getInstance();

				if ($permissions->isAdmin($user->getId())) {
					$session->set('csrf_token', md5(rand() . microtime()));
					if ($permissions->isSv($user->getId())) {
						$session->set('user_is_sv', true);
					}
				}

				$session->setValid();
				session::commit();
				system_runSession();

				$oEventPoint = new umiEventPoint("users_login_successfull");
				$oEventPoint->setParam("user_id", $user->id);
				users::setEventPoint($oEventPoint);
				$module = $this->module;

				if ($cmsController->getCurrentMode() == "admin") {
					ulangStream::getLangPrefix();
					system_get_skinName();
					/* @var UsersAdmin|users $module */
					$module->chooseRedirect($from_page);

				} else {
					/* @var UsersMacros|users $module */
					if (!$from_page) {
						$from_page = getServer('HTTP_REFERER');
					}

					$module->redirect($from_page ? $from_page : ($module->pre_lang . '/users/auth/'));
				}

			} else {
				$oEventPoint = new umiEventPoint("users_login_failed");
				$oEventPoint->setParam("login", $login);
				$oEventPoint->setParam("password", $password);
				users::setEventPoint($oEventPoint);

				if ($cmsController->getCurrentMode() == "admin") {
					throw new publicAdminException(getLabel('label-text-error'));
				}

				/**
				 * @var users|UsersMacros $this
				 */
				return $this->auth();
			}

			return $res;
		}

		/**
		 * Регистрирует пользователя с помощью Loginza
		 * @return mixed
		 * @throws coreException
		 * @throws selectorException
		 */
		public function loginza() {
			/* @var users|UsersMacros $this */
			if (empty($_POST['token']) ) {
				return $this->auth();
			}

			$loginzaAPI = new loginzaAPI();
			$profile = $loginzaAPI->getAuthInfo($_POST['token']);

			if (empty($profile)) {
				return $this->auth();
			}

			$profile = new loginzaUserProfile($profile);
			$objectTypes = umiObjectTypesCollection::getInstance();
			$objectTypeId	= $objectTypes->getTypeIdByHierarchyTypeName("users",	"user");

			$nickname = $profile->genNickname();
			$provider = $profile->genProvider();
			$provider_url = parse_url($provider);
			$provider_name = str_ireplace('www.', '', $provider_url['host']);
			$login = $nickname . "@" . $provider_name;
			$password = $profile->genRandomPassword();
			$email = $profile->genUserEmail();
			$lname = $profile->getLname();
			$fname = $profile->getFname();

			if (!$fname) {
				$fname = $nickname;
			}

			$sel = new selector('objects');
			$sel->types('object-type')->name('users', 'user');
			$sel->where('login')->equals($login);
			$sel->where('loginza')->equals($provider_name);
			$user =  $sel->first;
			$from_page = getRequest("from_page");

			if ($user instanceof iUmiObject) {
				permissionsCollection::getInstance()->loginAsUser($user);
				session_commit();
				$this->redirect($from_page ? $from_page : ($this->pre_lang . '/users/auth/'));
			}

			if (!preg_match("/.+@.+\..+/", $email)) {
				while(true) {
					$email = $nickname.rand(1,100)."@".getServer('HTTP_HOST');
					if ($this->checkIsUniqueEmail($email)) {
						break;
					}
				}
			}

			$object_id = umiObjectsCollection::getInstance()->addObject($login, $objectTypeId);
			$object = umiObjectsCollection::getInstance()->getObject($object_id);

			$object->setValue("login", $login);
			$object->setValue("password", md5($password));
			$object->setValue("e-mail", $email);
			$object->setValue("fname", ($fname));
			$object->setValue("lname", $lname);
			$object->setValue("loginza", $provider_name);
			$object->setValue("register_date", time());
			$object->setValue("is_activated", '1');
			$object->setValue("activate_code", md5(uniqid(rand(), true)));

			$_SESSION['cms_login'] = $login;
			$_SESSION['cms_pass'] = md5($password);
			$_SESSION['user_id'] = $object_id;
			session_commit();

			$group_id = regedit::getInstance()->getVal("//modules/users/def_group");
			$object->setValue("groups", Array($group_id));

			/**
			 * @var data|DataForms $data_module
			 */
			$data_module = cmsController::getInstance()->getModule('data');
			$data_module->saveEditedObject($object_id, true);

			$object->commit();

			$this->redirect($from_page ? $from_page : ($this->pre_lang . '/users/auth/'));
		}
	}
?>