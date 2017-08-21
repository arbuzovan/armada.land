<?php
	abstract class __custom_data {
        /**
        * @desc Format the number in desired way
        * @param Number  $_Number    Number to format
        * @param Integer $_Decimals	 Number of decimal signs
        * @param Char    $_DecPoint  Delimiter of the decimals
        * @param Char    $_Separator Separator between thousand groups
        * @return String Formatted number	
        */
        function numberformat($_Number, $_Decimals = 2, $_DecPoint = '.', $_Separator = ' ') {
            return number_format($_Number, $_Decimals, $_DecPoint, $_Separator);
        }
        
        /**
         * Функция опрелеяет протокол, по которому пришел запрос и исходя их этого сохраняет или возвращает какие-то данные по тарифу
         */
        function crudTarif(){
            $answer = array();  // Ответ клиенту
            
            $allowVariants = array();    // Возможные варианты протоколов
            $allowVariants[] = 'GET';
            $allowVariants[] = 'POST';
            
            $requestProtocol = $_SERVER['REQUEST_METHOD'];
            $tarifId = getRequest('id');   // ID тарифа
            
            
            if(!is_numeric($tarifId)){
                $answer['status'] = 'error';
                $answer['message'] = 'Полученный идентификатор тарифа не является числом';
                echo json_encode($answer);
                exit;
            }
            
            // Получаем объект пользователя
            $tarif_object = umiObjectsCollection::getInstance()->getObject($tarifId);
            $tarif_value = $tarif_object->tarif;
            
            
            switch ($requestProtocol){
                // Получение данных по тарифу
                case 'GET': 
                    $answer['status'] = 'ok';
                    $answer['action'] = $requestProtocol;
                    $answer['id'] = $tarifId;   // ID тарифа
                    $answer['value'] = $tarif_value;

                    echo json_encode($answer);
                    exit;
                    break;
                case 'POST':
                    $newValue = getRequest('newValue');     // новое значение тарифа
                    $newValue = str_replace(',', '.', $newValue);
                    
                    if(!is_numeric($newValue)){
                        $answer['status'] = 'error';
                        $answer['message'] = 'Полученное значение тарифа не является числом';
                        echo json_encode($answer);
                        exit;
                    }
                    
                    if($tarif_value == $newValue){
                        $answer['status'] = 'ok';
                        $answer['action'] = 'UPDATE_DATA';
                        $answer['value'] = $tarif_object->tarif;
                        echo json_encode($answer);
                        exit;
                    }else{
                        $tarif_object->tarif = (float)$newValue;
                        
                        $answer['status'] = 'ok';
                        $answer['action'] = 'UPDATE_DATA';
                        $answer['id'] = $tarifId;   // ID тарифа
                        $answer['value'] = $tarif_object->tarif;
                        echo json_encode($answer);
                        exit;
                    }
                    break;
                default:
                        $answer['status'] = 'error';
                        $answer['message'] = 'Использован недопустимый протокол';
                        echo json_encode($answer);
                        exit;
                    break;
            }

            return;
        }
        
        /**
         * Функция для ввода показний счетчиков по участкам
         */
        public function set_meters(){
            list($page_template) = def_module::loadTemplates("data/set_meters", "page_template");
            $page_arr = array();
            return def_module::parseTemplate($page_template, $page_arr);
        }
        
        /**
         * Функция показывает и сохраняет введенные значения показний счетчиков
         * @param type $method
         * @return type
         */
        public function crudMeters($template = 'meters',$method = false, $limit = 25){
            if(!$method){
                $method = $_SERVER['REQUEST_METHOD'];
            }
            
            $guideId = '127';   // ID справочника, который содержит данные по счетчикам
            
            $sel = new selector('objects');
            $sel->types('object-type')->id($guideId);
            $sel->order('date')->asc();
            $sel->limit(0, $limit);
            
            $area_numbers_array = $this->getAreaNumbers(false);
            
            switch($method){
                case 'GET':
                    list($meters_grid, $meters_grid_line) = def_module::loadTemplates("data/".$template, "meters_grid", "meters_grid_line");
                    
                    $item_arr = [];
                    $meters_arr = Array();

                    if ($sel->length > 0) {
                        foreach ($sel->result as $index => $meters) {
                            $tmpArray = explode(',',$meters->name);
                            $area_number = $meters->area_number;
                            if($meters->getValue('date')){
                                $prev_meter = $this->getPrevMeters($area_number, $meters->getValue('date')->getDateTimeStamp());   
                            }
                            
                            if(!$prev_meter){
                                $delta_meter = 0;
                            }else{
                                $delta_meter = $meters->elektroenergiya_den - $prev_meter;
                            }
                            
                            $monthArray = ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];   // Массив месяцов
                            if($meters->getValue('date')){
                                $monthIndex = date('m',$meters->getValue('date')->getDateTimeStamp());
                            }

                                    
                            $meter = Array();
                            $meter['attribute:id'] = $meters->id;
                            $meter['attribute:number'] = $index+1;
                            $meter['attribute:name'] = $meters->name;
                            $meter['attribute:area_number'] = $area_number;
                            $meter['attribute:period'] = $monthArray[(int)$monthIndex -1];
                            $meter['attribute:elektroenergiya_den'] = $meters->elektroenergiya_den;
                            $meter['attribute:delta_meter'] = $delta_meter;
                            $meter['attribute:prev_meter'] = $prev_meter;
                            $meter['attribute:tarif'] = $this->getTarif('elenergiya_den', false);
                            $meter['attribute:summByPeriod'] = 'сумма за указанный период';
                            $meters_arr[] = def_module::parseTemplate($meters_grid_line, $meter);
                        }
                    }
                    $item_arr['subnodes:lines'] = $meters_arr;
                    return def_module::parseTemplate($meters_grid, $item_arr);
                    
                    break;
                case 'POST':
                    $guideId = 127; // Справочник с тарифами
                    
                    $area_number = getRequest('area_number');
                    $currentMeter = getRequest('currentMeter');
                    
                    if(!$currentMeter || $currentMeter == 0){
                        exit;
                    }
                    
                    if(!$area_number || $area_number == 0){
                        exit;
                    }
                    
                    $sel = new selector('objects');            
                    $sel->types('object-type')->name('users', 'user');
                    $sel->where('area_number')->equals($area_number);
                    $sel->limit(0,1);
                    
                    foreach ($sel as $user){
                        $sobstvennik = $user->id;
                    }
                    
                    $name = 'dummy';
                    
                    $newRecObjectId = umiObjectsCollection::getInstance()->addObject($name, $guideId);
                    $newRecObject = umiObjectsCollection::getInstance()->getObject($newRecObjectId);
                    
                    $iTime = new umiDate( time() );
                    
                    $newRecObject->area_number = $area_number;
                    $newRecObject->elektroenergiya_den = $currentMeter;
                    $newRecObject->date = new umiDate();
                    $newRecObject->sobstvennik = $sobstvennik;
                    
                    $newRecObject->commit();
                    
                    
                    
                    
                    
                    
                    $answer = array('status'=>'ok');
                    echo json_encode($answer);
                    exit;
                    break;
            }
            
            return $method;
        }
        
        public function getPrevMetersAjax(){
            $guideId = '127';   // ID справочника, который содержит данные по счетчикам
            
            $date = time();
            $area_number = getRequest('area_number');
            $currentMeter = getRequest('currentMeter');
            
            if(!$area_number){
                exit;
            }
            
            $sel = new selector('objects');
            $sel->types('object-type')->id($guideId);
            $sel->where('area_number')->equals($area_number);
            $sel->where('date')->less($date);
            $sel->order('date')->desc();
            $sel->limit(0, 1);
            
            foreach ($sel as $meters) {
                $answer = array();
                $answer['prevValue'] = $meters->elektroenergiya_den;
                $answer['currValue'] = $currentMeter;
                $answer['deltaValue'] = (float)$currentMeter - (float)$meters->elektroenergiya_den;
                echo json_encode($answer);
                exit;
            }
            exit;
        }
        
        /**
         * 
         * @param type $tarifName
         */
        public function getTarif($tarifName = false, $json = false){
            $objectsCollection = umiObjectsCollection::getInstance();
            $tarifGuideId = '131';   // ID справочника, который содержит данные по счетчикам
            //
            if(!$tarifName){
                $tarifName = getRequest('tarifName');
            }
            
            if(!$tarifName){
                return;
            }
            
            if(!$json){
                $json = getRequest('json');
            }
            
            $tarifs = $objectsCollection->getGuidedItems($tarifGuideId);
            foreach($tarifs as $id => $tarifObject){
                $tarifObject = $objectsCollection->getObject($id);
                if($tarifObject->hidden){
                    continue;
                }
                if($tarifObject->kod == $tarifName){
                    if($json == false){
                        return $tarifObject->tarif;
                    }else{
                        echo $tarifObject->tarif;
                        exit;
                    }
                }
            }
        }
        
        public function getPrevMeters($area_number, $date = false){
            $guideId = '127';   // ID справочника, который содержит данные по счетчикам
            
            if(!$date){
                $date = time();
            }
            
            $sel = new selector('objects');
            $sel->types('object-type')->id($guideId);
            $sel->where('area_number')->equals($area_number);
            $sel->where('date')->less($date);
            $sel->order('date')->desc();
            $sel->limit(0, 1);
            
            foreach ($sel as $meters) {
                return $meters->elektroenergiya_den;
            }
        }
        
        /**
         * Функция формирует массив номеров участков
         * @param type $getJson если false, то вернется просто массив
         */
        public function getAreaNumbers($getJson = true) {
            $area_numbers_array = array();
            $users = new selector('objects');
            $users->types('object-type')->name('users', 'user');
            
            foreach ($users as $user){
                $area_numbers_array[(int)$user->area_number] = array($user->area_number,$user->lname, $user->fname, $user->father_name);
            }
            
            ksort($area_numbers_array,SORT_NUMERIC);
            
            if($getJson){
                echo json_encode($area_numbers_array);
                exit;
            }else{
                return $area_numbers_array;
            }
        }
        
	};
?>