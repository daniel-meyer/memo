<?php

class Etd_Smarty extends Smarty
{
	/**
	* Obiekt widoku
	*
	* @var Zend_View_Abstract
	*/
	protected $_zendView = null;
 
	/**
	* Konstruktor
	*
	*/
	public function __construct()
	{
		parent::__construct();
 
		$this->compiler_class = 'Smarty_ZendCompiler';

	}
 
	/**
	* Ustawienie widoku
	*
	* @param Zend_View_Abstract $view obiekt widoku
	*/
	public function setZendView(Zend_View_Abstract $view)
	{
		$this->_zendView = $view;
        
	}
 
	/**
	* Pobranie widoku
	*
	* @param Zend_View_Abstract obiekt widoku
	*/
	public function getZendView()
	{
		return $this->_zendView;
	}
    
    public function callViewHelper($name,$args)
    {
        $helper = $this->_zendView->getHelper($name);
        //var_dump($args);   die();   
        return call_user_func_array(array($helper,$name),$args);
    }
    
    /**
     * Przeciążenie starej metody
     * Dla poprawnego cachowania plików includowanych w templatach np. {include file='plik.tpl'}
     * Zamienia krótki adres na pełną ścieżkę
     * 
     * @param string $path The directory to set as the path.
     * @return void
     */
    function _get_compile_path($resource_name)
    {                           
        if(!is_readable($resource_name)){
            $resource_tmp = $this->template_dir . '/' . $resource_name;
            if(is_readable($resource_tmp)){
                $resource_name = $resource_tmp;
            }
        }
                                         
        return $this->_get_auto_filename($this->compile_dir, $resource_name,
                                         $this->_compile_id) . '.php';
    }  
}