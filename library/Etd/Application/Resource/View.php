<?php
/**
 * Etendard Sp. z o.o.
 *
 *
 * @category   Etd
 * @package    Etd_Application
 * @subpackage Resource
 */

/**
 * @see Zend_Application_Resource_ResourceAbstract
 */
require_once 'Zend/Application/Resource/ResourceAbstract.php';


/**
 * Resource for settings view options
 *
 * @uses       Zend_Application_Resource_ResourceAbstract
 * @category   Etd
 * @package    Etd_Application
 * @subpackage Resource
 */
class Etd_Application_Resource_View extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * @var Zend_View_Interface
     */
    protected $_view;

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Zend_View
     */
    public function init()
    {
        $options = $this->getOptions();
        
        $view = $this->getView();
        
       	$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setViewScriptPathSpec($options['smarty']['specPath']);
		$viewRenderer->setViewSuffix($options['smarty']['suffix']);
		$viewRenderer->setView($view);
        
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        
        Zend_Registry::set('view', $view);
        
        return $view;
    }

    /**
     * Retrieve view object
     *
     * @return Zend_View
     */
    public function getView()
    {
        if (null === $this->_view) {
            $options = $this->getOptions();
            $this->_view =  new Etd_View_Smarty();
            
           	$this->_view->setScriptPath($options['smarty']['scriptPath']);	
        	$this->_view->setCompilePath($options['smarty']['compilePath']);
            $this->_view->setCachePath($options['smarty']['cachePath']);
            
            $this->_view->addHelperPath('Etd/View/Helper', 'Etd_View_Helper_');
            
            if (isset($options['doctype'])) {
                $this->_view->doctype()->setDoctype(strtoupper($options['doctype']));
                if (isset($options['charset']) && $this->_view->doctype()->isHtml5()) {
                    $this->_view->headMeta()->setCharset($options['charset']);
                }
            }
            if (isset($options['headMeta']) && is_array($options['headMeta'])) {
                foreach($options['headMeta'] as $name=>$value){
                    $this->_view->headMeta()->appendName($name, $value);
                }  
            }
            if (isset($options['contentType'])) {
                $this->_view->headMeta()->appendHttpEquiv('Content-Type', $options['contentType']);
            }
            if (isset($options['assign']) && is_array($options['assign'])) {
                $this->_view->assign($options['assign']);
            }
            
        }
        return $this->_view;
    }
    
}
