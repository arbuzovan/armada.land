<?php
	class custom extends def_module {
		public function cms_callMethod($method_name, $args) {
			return call_user_func_array(Array($this, $method_name), $args);
		}
		
		public function __call($method, $args) {
			throw new publicException("Method " . get_class($this) . "::" . $method . " doesn't exist");
		}

		public function getProfileActiveClass($page) {
			if (substr_count($_SERVER['REQUEST_URI'], '/users/'.$page) > 0) {
				return ' class="active"';
			} else {
				return '';
			}
		}
		
		// get guide list
		public function getGuideList($id, $template = 'guidelist', $sortById = false, $arrayOnly = false, $page_id = false){
			if (!$id) return null;
		
			$objectsCollection = umiObjectsCollection::getInstance();
			$items = $objectsCollection->getGuidedItems($id);
			if(!sizeof($items)) return null;

			if($arrayOnly) return $items;
				
			if ($sortById) {
				ksort($items);
			}
						
			list($guide_block, $guide_item) = def_module::loadTemplates("content/guide/{$template}.tpl", "guide_block", "guide_item");
			
			$result = '';
			$number = 1;
			$block_array = array();
			
			if ($page_id) {
				$page = umiHierarchy::getInstance()->getPathById($page_id);

			}

			foreach($items as $key => $value){
				$line_array = array();
				$line_array['id'] = $key;
				$line_array['number'] = $number;
				$line_array['text'] = $items[$key];
				$line_array['page_link'] = $page;
				$number++;
				$result .= def_module::parseTemplate($guide_item,$line_array);
			}
			$block_array['lines'] = $result;
			unset($items);
			$result = def_module::parseTemplate($guide_block, $block_array);
			return $result;
		}

		// detect mobile device
	    public function mobileDetect() {
		 	require_once('mobile_detect.php');
		 	$detect = new Mobile_Detect;
			if ( $detect->isMobile() ) {
				return true;
			} else {
				return false;
			}
	   	}

		// declension of numerals
		public function priceFormat($price) {
			return number_format($price, 0, '', ' ');
		}
		
		// declension of numerals
		public function declOfNum($number) {
			$cases = array (2, 0, 1, 1, 1, 2);
			$titles = array('сотка', 'сотки', 'соток');
			return $titles[ ($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)] ];
		}
		
		// get from global Array object id
		public function getObjectId() {
			return (string) getRequest('oid');
		}
		
		// date in Russain
		public function getDateRu($time) {
			$day = date('d', $time);
			$month = date('n', $time);
			$year = date('Y', $time);
			if (!checkdate($month, 1, $year)) {
				throw new publicException("Проверьте порядок ввода даты");
			}
			$months_ru = array(1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
			$date_ru = $day . ' ' . $months_ru[$month] . ' ' . $year;
			return $date_ru;  
		}
		
		//get catalog listing
		public function getCatalogList($parent_id = 0, $template = "default", $per_page = 0) {
		
			list($template_items, $template_empty, $template_item) = def_module::loadTemplates("content/catalog/" . $template, "items", "block_empty", "item");
		 	
		 	$curr_page = (int) getRequest('p');
			
			$sel = new umiSelection;
			$sel->addObjectType(119);
			$sel->addHierarchyFilter($parent_id, 10);
			
			$result = umiSelectionsParser::runSelection($sel);

			if(($sz = sizeof($result)) > 0) {
			
				$umiHierarchy = umiHierarchy::getInstance();
				$item_arr = array();
				$items_arr = array();	

				foreach ($result as $item_id){
					$item = $umiHierarchy->getElement($item_id);
					$link = $umiHierarchy->getPathById($item_id);
					if ($item instanceof iUmiHierarchyElement){
					
						//if (!$item->getIsVisible()) continue;
						
						$currentItem = $item->getObject();
						$currentItemId = $currentItem->id;
      					
						$item_arr['@id'] = $item_id;
						$item_arr['@name'] = $item->getName();
						$item_arr['@link'] = $link;
						$items_arr[] = def_module::parseTemplate($template_item, $item_arr);
					}
				}
				$items_arr = array('subnodes:items' => $items_arr);
				
				$block_arr = array();
				$block_arr['subnodes:items'] = $items_arr;
				$block_arr['category_id'] = $parent_id;
				
				return def_module::parseTemplate($template_items, $items_arr, $block_arr);
			
			} else {
				$items_arr = array();
				$block_arr  = array();
				return def_module::parseTemplate($template_block_empty, $items_arr, $block_arr);
			}
		}

		//get property "Set Of Images"
		public function PropertySetOfImages($page_id, $field_name, $template = "default", $reverse = false){
			if (!$page_id)
				return 'Page id is not set';
			if (!$field_name)
				return 'Field name is not set';
			list($template_items, $template_block_empty, $template_item) = def_module::loadTemplates("data/" . $template, "set_of_images", "set_of_images_empty", "image_item");
		 
			$umiHierarchy = umiHierarchy::getInstance();			
			$object = $umiHierarchy->getElement($page_id);
			
			if ($object instanceof iUmiHierarchyElement) {
				$images_arr = $object->getValue($field_name);
			}
			if ($reverse) {
				$images_arr = array_reverse($images_arr, true);
			}
			
			if (sizeof($images_arr) > 0) {
				$number = 0;
				$offsetNumber = 1;
				foreach ($images_arr as $filepath) {
					$item_arr['@src'] = substr($filepath->getFilePath(), 1);
					$item_arr['@filepath'] = $filepath->getFilePath();
					$item_arr['@alt'] = $filepath->getAlt();
					$item_arr['@num'] = $number;
					$item_arr['@page_id'] = $page_id;
					$item_arr['@offset_num'] = $offsetNumber;
					$number++;
					$offsetNumber++;
					$items_arr[] = def_module::parseTemplate($template_item, $item_arr);
				}
				$items_arr = array('subnodes:items' => $items_arr);
				return def_module::parseTemplate($template_items, $items_arr);
			} else {
				$items_arr = array();
				return def_module::parseTemplate($template_block_empty, $items_arr);
			}
		}
		
		//get all place items
		public function getPlaceItems($parent_id, $baloon_image = "", $template = "default"){
			if (!$parent_id)
				return 'Parent page id is not set';
			list($template_items, $template_item) = def_module::loadTemplates("content/places/" . $template, "items", "item");
		 
			$umiHierarchy = umiHierarchy::getInstance();
			$childs_arr = $umiHierarchy->getChildIds($parent_id, false);
			
			$result = '';
			$cases = array (2, 0, 1, 1, 1, 2);
			$titles = array('сотка', 'сотки', 'соток');
			
			foreach ($childs_arr as $item_id){
				$item = $umiHierarchy->getElement($item_id);
				if ($item instanceof iUmiHierarchyElement){
					
					$coords = '';	
					for ($i = 1; $i < 8; $i++) {
						$item_lat = trim($item->getValue($i.'_lat'));
						$item_lng = trim($item->getValue($i.'_lng'));
						if ($item_lat != '' || $item_lng != '') {
							$coords .= '['.$item_lat.','.$item_lng.'],';
						}
					}
					
					$objectsCollection = umiObjectsCollection::getInstance();
    				$valueObject = $objectsCollection->getObject($item->getValue('state'));
					
					$area_title = $titles[ ($item->getName() % 100 > 4 && $item->getName() % 100 < 20) ? 2 : $cases[min($item->getName() % 10, 5)] ];
					if ($valueObject) {
						$state = $valueObject->getName();
						$fillColor = $valueObject->getValue('polygon_color');
					}
					
					$name = $item->getName();
					$price = $item->getValue('price');
					$area = $item->getValue('area');
					
					if ($item->getValue('open_order')) {
						$htmlOver = '<div class=\'balloonContent\'><div class=\'description\'><div class=\'area-name\'>Участок №'.$name.'</div><div class=\'area-value\'>'.$area.' '.$area_title.'</div><div class=\'price\'><span>Стоимость уточняйте<br/>в отделе продаж по тел.<br /><strong>(812) 615-11-25</strong></span></div><div class=\'btn-button\'><span class=\'button button-green button-def\'>'.$state.'</span><div></div></div>';
						$htmlFull = '<div class=\'balloonContent\'><div class=\'image\'><img src=\''.$baloon_image.'\' alt=\'Участок №'.$name.'\' /></div><div class=\'description\'><div class=\'area-name\'>Участок №'.$name.'</div><div class=\'area-value\'>'.$area.' '.$area_title.'</div><div class=\'price\'><span>Стоимость уточняйте<br/>в отделе продаж по тел.<br /><strong>(812) 615-11-25</strong></span></div><div class=\'btn-button\'><a href=\'#modal-orderplace\' class=\'button button-green\' data-toggle=\'modal\' data-area-id=\''.$name.'\'>Забронировать</a><div></div></div>';
					} else {
						$htmlOver = '<div class=\'balloonContent\'><div class=\'description\'><div class=\'area-name\'>Участок №'.$name.'</div><div class=\'area-value\'>'.$area.' '.$area_title.'</div><div class=\'btn-button\'><span class=\'button button-buy\' style=\'background: '.$fillColor.'\'>'.$state.'</span><div></div></div>';
						$htmlFull = '<div class=\'balloonContent\'><div class=\'image\'><img src=\''.$baloon_image.'\' alt=\'Участок №'.$name.'\' /></div><div class=\'description\'><div class=\'area-name\'>Участок №'.$name.'</div><div class=\'area-value\'>'.$area.' '.$area_title.'</div><div class=\'btn-button\'><span class=\'button button-buy\' style=\'background: '.$fillColor.'\'>'.$state.'</span><div></div></div>';
					}
					
					$result .= '
								Map.areas["area'.$name.'"] = new Map.Area({
									id: '.$name.',
									name: "Участок №'.$name.'",
									coords:['.$coords.'],
									html: "<div class=\'map-area-number\'>'.$name.'</div>",
									htmlOver: "'.$htmlOver.'",
									htmlFull: "'.$htmlFull.'",
									fillColor: "'.$fillColor.'",
									strokeColor: "#fff",
									opacity: 0.6,
									opacityOver: 0.9,
									htmlZoom: 16
								});';
				}
			}
			return $result;
		}

		// get custom page
		public function getPages($template = "default", $parent_id = false, $level = 1, $offset = 0, $limit = false, $type_id = false, $exclude = false, $order_name = false, $asc = true) {

			list($template_items, $template_item, $template_empty) = def_module::loadTemplates("custom/" . $template, "block", "page", "empty");

			if (!$offset) {
				$currentPage = (int) getRequest('p');
				$offset = $currentPage * $limit;	
			}

			$pages = new selector('pages');

			if ($type_id) {
				$pages->types('object-type')->id($type_id);
			}

			if ($exclude) {
				$pages->where('id')->notequals($exclude);
			}

			if ($parent_id) {
				$pages->where('hierarchy')->page($parent_id)->childs($level);
			} else {
				$pages->where('hierarchy')->page(0)->childs($level);
			}

			$selCond = trim(getRequest('selCond'));
			if ($selCond != '') {
				list($fieldName, $fieldValue) = explode('=', $selCond);
				$pages->where($fieldName)->equals($fieldValue);
			}

			$pages->where('is_active')->equals(array(1));

			if ($limit) {
				$pages->limit($offset, $limit);
			}

			if (!$order_name) {
				$order_name = 'ord';
			}

			if ($asc) {
				$pages->order($order_name)->asc();
			} else {
				$pages->order($order_name)->desc();
			}

			$total = $pages->length;

			$items = Array();

			$extProps = trim(getRequest('extProps'));
			if ($extProps != '') {
				$extProps = explode(',', $extProps);
			}
			
			if (sizeof($pages) > 0) {
				$umiHierarchy = umiHierarchy::getInstance();
				foreach ($pages as $page) {
									
					$item = Array();
					$item['attribute:id'] = $page->id;
					$item['node:name'] = $page->getName();
					$item['attribute:link'] = $umiHierarchy->getPathById($page->id);
					$item['attribute:type_id'] = $page->getObjectTypeId();

					if (is_array($extProps)) {
						for ($i = 0; $i < sizeof($extProps); $i++) { 
							$item['attribute:'.$extProps[$i]] = $page->getValue($extProps[$i]);
						}
					}

					$items[] = def_module::parseTemplate($template_item, $item);
				}

				$block = Array();
				$block['subnodes:pages'] = $items;
				$block['subnode:total'] = $total;
				$block['subnode:per_page'] = $limit;
				return def_module::parseTemplate($template_items, $block);
			} else {
				$block = Array();
				return def_module::parseTemplate($template_empty, $block);
			}

		}

	};
?>