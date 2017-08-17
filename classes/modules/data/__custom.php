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
            list($page_template) = def_module::loadTemplates("data/set_metters", "page_template");
            $page_arr = array();
            return def_module::parseTemplate($page_template, $page_arr);
        }
        
	};
?>