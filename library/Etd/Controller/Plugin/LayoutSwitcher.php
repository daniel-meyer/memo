<?php

class Etd_Controller_Plugin_LayoutSwitcher extends Zend_Layout_Controller_Plugin_Layout
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $layoutPath = APPLICATION_PATH . '/layouts/';
        $module = $request->getModuleName();
        //die($layoutPath . $module.'.tpl');
        if (file_exists($layoutPath . $module.'.tpl')) {
            $this->getLayout()->setLayout($module);
        }
    }
}