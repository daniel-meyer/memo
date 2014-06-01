<?php

class Model_Service_Stat
{
    public function addHint()
    {        
        $visitDate = new DateTime;
        $stat = Orm::factory('Stat')->findOneBy(array('visit_date'=>$visitDate->format('Y-m-d')));

        if($stat){
            $stat->setAmount($stat->getAmount()+1);
        }else{
            $stat = Orm::factory('Stat')->create();
            $stat->setVisitDate($visitDate->format('Y-m-d'));
            $stat->setAmount(1);
        }
        
        $stat->save();
        
        return;
    }
    
    public static function getDataFromLastTime()
    {
        $visit_date = new DateTime('-1 month');

        $stats = Orm::factory('Stat')->fetchAll(array('visit_date>=?'=>$visit_date->format('Y-m-d')));
        $out = array();
        
        foreach($stats as $stat){
            $out[] = array(
                $stat->getVisitDate()->format('U'),
                $stat->getAmount()
            );
        }
        return $out;    
    }    
}        