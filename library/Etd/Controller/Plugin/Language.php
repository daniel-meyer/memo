<?php
class Etd_Controller_Plugin_Language extends Zend_Controller_Plugin_Abstract{
    
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $sUri = $request->getRequestUri();
        $aParsedUri = parse_url($sUri);
        $sLanguageDefault = Zend_Registry::get("config")->etd->language->default;

        if ($aParsedUri['path'] != '' && preg_match('#^\\/([a-z]{2}).*#ui', $aParsedUri['path'], $aResult)) {
            $sLanguage = $aResult[1];
        } else {
            $sLanguage = $sLanguageDefault;
        }

        $oTranslate = Zend_Registry::get('Zend_Translate');
        $oLocale = Zend_Registry::get('Zend_Locale');

        // Change language if available
        if ($oTranslate->isAvailable($sLanguage)) {
            $oLocale->setLocale($sLanguage);
            $oTranslate->setLocale($oLocale);
        } else {
            // Otherwise get default language
            $mLocale = $oTranslate->getLocale();
            if ($mLocale instanceof Zend_Locale) {
                $sLanguage = $mLocale->getLanguage();
            } else {
                $sLanguage = $mLocale;
            }
        }
        
       
        if($sLanguage != $sLanguageDefault){
            $oFrontController = Zend_Controller_Front::getInstance();
            $oRouter = $oFrontController->getRouter()->setGlobalParam('language', $sLanguage);
        }
          
    /*
        
        
        
        $translate = new Zend_Translate('csv', APPLICATION_PATH . '/configs/lang/'. $sLanguage . '.csv' , $sLanguage);
        Zend_Registry::set('Zend_Translate', $translate);
        */

    }
}