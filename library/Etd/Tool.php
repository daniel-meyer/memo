<?php

class Etd_Tool
{
    /**
	 * nounNumer() Zwraca poprawną odmianę rzeczownika dla podanej liczby
	 *
	 * @param int $liczba
	 * @param string $jeden
	 * @param string $dwa
	 * @param string $siedem
	 * @return string
	 */
	public static function nounNumer($liczba,$jeden,$dwa,$siedem)
    {
		$liczba = trim($liczba);
		$sl = (int)substr( '0'.$liczba, -2 );

		if($sl == 1 && $liczba!='0')return $jeden;
		if($sl > 1 && $sl < 5 ) return $dwa;
		if($sl > 21){
			$sll = (int)substr( $liczba, -1 );
			if($sll > 0 && $sll < 5 ) return $dwa;
		}
		return $siedem;
	}
    
    public static function getSexArray()
    {
        return array('f'=>'kobieta', 'm'=>'mężczyzna');
    }
    
    public static function formatFromUri($string, $action=false)
    {
        $formatted =implode('', array_map('ucwords', explode('-', $string)));
        if($action){
            $formatted .= 'Action';
        }
        return strtolower(substr($formatted, 0, 1)) . substr($formatted, 1);    
        
        
    }
    
    public static function getRandomString($length=32)
    {
        return substr(md5(uniqid(mt_rand(), true)), 0, $length);
    }    
    
    public static function parseYoutubeVideoId($url)
    {
        if (preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            return $match[1];
        }
        return null;
    }


}