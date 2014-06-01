<?php 

class Etd_Date extends Zend_Date
{

    public static function explodeDiff($dateFrom, $dateTo=null){

        if($dateFrom == '0000-00-00')return array();
        
        if($dateFrom instanceof DateTime){
            $data = $dateFrom->format('U');
        }else{
            $data = strtotime($dateFrom);
        }
        
        if($dateTo instanceof DateTime){
            $data1 = $dateTo->format('U');
        }else{
            $data1 = ($dateTo) ? strtotime($dateTo) : time();
        }


		$lat =  date('Y',$data1) - date('Y',$data) - ( (float)date('m.d',$data1) < (float)date('m.d',$data) );
		
		$miesiecy = ((float)date('m.d',$data1) < (float)date('m.d',$data)) ? 12 : 0;
		
		$miesiecy += floor((float)date('m.d',$data1) - (float)date('m.d',$data));
		
		$dni = date('j',$data1) < date('j',$data) ? date('t',mktime(0,0,0,(date('n',$data1)-1),date('j',$data1),date('Y',$data1)) ) : 0;
		
		$dni += floor((float)date('j',$data1) - date('j',$data));
		
		return array(
			$lat,
			$miesiecy,
			$dni
		);
	}
    
    public static function plDate($string, $dopleniacz = false) {
        $lang = array(
    		'Monday'    => 'Poniedziałek', 
    		'Tuesday'   => 'Wtorek', 
    		'Wednesday' => 'Środa', 
    		'Thursday'  => 'Czwartek', 
    		'Friday'    => 'Piątek', 
    		'Saturday'  => 'Sobota', 
    		'Sunday'    => 'Niedziela', 
    		'Mon'       => 'Pon', 
    		'Tue'       => 'Wto', 
    		'Wed'       => 'Sro', 
    		'Thu'       => 'Czw', 
    		'Fri'       => 'Pt', 
    		'Sat'       => 'Sob', 
    		'Sun'       => 'Nie', 
    		'January'   => 'Styczeń', 
    		'February'  => 'Luty',
    		'March'     => 'Marzec', 
    		'April'     => 'Kwiecień', 
    		'May'       => 'Maj', 
    		'June'      => 'Czerwiec', 
    		'July'      => 'Lipiec', 
    		'August'    => 'Sierpień', 
    		'September' => 'Wrzesień', 
    		'October'   => 'Październik', 
    		'November'  => 'Listopad', 
    		'December'  => 'Grudzień', 
    		'Jan'       => 'Sty', 
    		'Feb'       => 'Lut', 
    		'Mar'       => 'Mar', 
    		'Apr'       => 'Kwi', 
    		'May'       => 'Maj', 
    		'Jun'       => 'Cze', 
    		'Jul'       => 'Lip', 
    		'Aug'       => 'Sie', 
    		'Sep'       => 'Wrz', 
    		'Oct'       => 'Paź', 
    		'Nov'       => 'Lis',
    		'Dec'       => 'Gru',
    	);
        
        if($dopleniacz){ 
            $lang2 = array(
            'January'   => 'stycznia', 
    		'February'  => 'lutego',
    		'March'     => 'marca', 
    		'April'     => 'kwietnia', 
    		'May'       => 'maja', 
    		'June'      => 'czerwca', 
    		'July'      => 'lipca', 
    		'August'    => 'sierpnia', 
    		'September' => 'września', 
    		'October'   => 'października', 
    		'November'  => 'listopada', 
    		'December'  => 'grudnia', 
            );
            
            $lang = array_merge($lang, $lang2);
        }
    	
    	foreach($lang as $from => $to) 
    	{
    		$string = str_replace($from, $to, $string);
    	}
    	
    	return $string;
    }  
}