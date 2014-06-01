<?php
class Etd_Controller_Plugin_Stats extends Zend_Controller_Plugin_Abstract
{
    

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $session = Zend_Registry::get('session');

        if(!empty($session->EtdStat))return;
        
        $date = new DateTime;
        $session->EtdStat = $date->format('U');

        Service::factory('Stat')->addHint();
        
    }
}