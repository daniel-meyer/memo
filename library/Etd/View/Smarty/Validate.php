<?php
/**
 * WALIDACJA SMARTY

 * Przykład: {validate check="isEmpty:#pass*OR*equal:#pass1:#pass2" message="Nieprawidłowe hasło"}
 **/
class Etd_View_Smarty_Validate 
{
     protected $tmpfile;
     protected $validationErrors; 
     protected static $_instance = null;
     protected $enableValidate = false;
     protected $method = 'post';
     protected $functionPrefix = 'valid_';

     protected function __construct() 
     {
          $front = Zend_Controller_Front::getInstance();
          $view = $front->getParam('bootstrap')->getResource('view');
          $request = $front->getRequest();
          
          $this->tmpfile = $view->getCachePath() . '/validate'
                    .'_'.$request->getModuleName()
                    .'_'.$request->getControllerName()
                    .'_'.$request->getActionName();
          
          $this->enableValidate();
          
     }
     

     
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    public function setMethod($method)
    {
        if(!in_array($method, array('get', 'post'))){
            $this->method = $method;
        }
        
    }
    
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
    
     public function getValidPath() 
     {
          return $this->tmpfile;
     }

     public function createValidatorFile() 
     {
        if(!is_file($this->tmpfile)){
            touch($this->tmpfile);    
        }
     }

     public function enableValidate($flag=true) 
     {
          $this->enableValidate = $flag;
          
          if($flag){
            $this->createValidatorFile();
          }
     }
     
     public function isEnabledValidate() 
     {
          return $this->enableValidate;
     }
     
     public function loadValidator($name) 
     {
          require_once (APPLICATION_PATH . "/validators/" . $name . ".php");
     }
     
     public function runValidator($validator, $params) 
     {
          $this->loadValidator($validator);
          $validatorFunction = $this->functionPrefix . $validator;
          return $validatorFunction($this->_prepareParams($params));
     }
     
     private function _prepareParams($paramNames)
     {
        $rq = Zend_Controller_Front::getInstance()->getRequest();
        $out = array();
        foreach($paramNames as $name){
            if(substr($name,0,1) == '#'){
                $paramName = substr($name,1);
                $out[] = ($this->method == 'post') ? $rq->getPost($paramName) : $rq->getParam($paramName);
            }else{
                $out[] = $name;
            }
            
        }
        
        return (count($out) == 1) ? $out[0] : $out;
     }
     
     public function getValidationData()
     {
        $content = file_get_contents($this->tmpfile);
        return empty($content) ? array() : unserialize($content);
     }
     
     public function setValidationData($validationArray)
     {
        $fileHandle = fopen($this->tmpfile, "w");
        fwrite($fileHandle, serialize($validationArray));
        fclose($fileHandle);
     }
     
     private function _validParts($check)
     {
        //=>
        if(strstr($check, '=>')){
            return $this->_implicationSequence($check);
        }
        
        //OR
        if(strstr($check, '*OR*')){
            return $this->_orSequence($check);
        }
        
        //AND
        return $this->_andSequence($check);
        
     }
     
     private function _implicationSequence($check)
     {
        $parts = explode('=>', $check);
        $count = count($parts);
        foreach($parts as $k=>$part){
            $params = explode(':', $part);
            $validator = array_shift($params);
            
            $result = $this->runValidator($validator, $params);
            
            //last
            if($count == $k+1){
                return $result;
            //pre    
            }else {
                if(false == $result){
                    return true;
                }
            }
        }
        return true;
     } 
     
     private function _andSequence($check)
     {
        $parts = explode('*AND*', $check);
        
        foreach($parts as $part){
            $params = explode(':', $part);
            $validator = array_shift($params);
            
            if(false == $this->runValidator($validator, $params)){
                return false;
            }
        }
        return true;
     } 

     private function _orSequence($check)
     {
        $parts = explode('*OR*', $check);
        
        foreach($parts as $part){
            $params = explode(':', $part);
            $validator = array_shift($params);
            
            if(true == $this->runValidator($validator, $params)){
                return true;
            }
        }
        
        return false;
     } 
        
     
     public function isValid() 
     {
          $flagError = 0;
          
          $validationArray = $this->getValidationData();
          //var_dump($validationArray);die();
          if (!empty($validationArray)) {
               foreach ($validationArray as $check=>$arr) {
                    if (false == $this->_validParts($check)) {
                         if(true == $arr['important']){
                            $flagError++;
                         }
                         $this->validationErrors[$check] = true;
                    }
               }
          }
          
          return (0 == $flagError);
     }
}

