<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


    /**
     * Robi listę ul z adresami kolejnych stron
     *
     * @param intiger $number
     * @param intiger $current
     * @param string $path
     * @param string $currentClass
     * @param string $pagerClass
     */
function smarty_function_html_pager($params, &$smarty)
{
    
    $count = null;
    $current = 1;
    $path = null;
    $size = 3;
    $imgDir = 'public/images/';
	$imgExt = 'gif';
	$labels = array(
	   'pages'=>'Strony:',
       'page'=>'Strona',
       'first'=>'Pierwsza',
       'prev'=>'Poprzednia',
       'next'=>'Następna',
       'last'=>'Ostatnia',
       'farprev'=>'Skok do tyłu',
       'farnext'=>'Skok do przodu',
	   'of'=>'z'
	);
       
    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'count':
                $$_key = ($_val>0) ? (int)$_val : 1;
                break;
            
            case 'current':
                $$_key = ($_val>0) ? (int)$_val : 1;
                break;
                
            case 'path':
                $$_key = (string)$_val;
                break;

            case 'size':
                $$_key = ($_val>0) ? (int)$_val : 1;
                break;
                
            case 'imgDir':
                $$_key = (string)$_val;
                break;
                                
            case 'imgExt':
                $$_key = (string)$_val;
                break;
                                       
            case 'labels':
            	$tmp = array();
            	foreach($labels as $k=>$v)
            		$tmp[$k] = isset($_val[$k]) ? (string)$_val[$k] : '';
                $$_key = $tmp;
                break;
                             
            default:
                break;
        }
    }

            
     $tabPager = array();
		
		 //***** pierwsza i poprzednia
     if ( $current > 1 ){
          $tabPager[] = array('first' => 1);
          $tabPager[] = array('prev' => $current-1);
     }    
    
		//******pager numeryczny - i podstron jest wiecej od 2*$size
		if ($count > (2*$size+1)){

       	$num_limit = $size*2 ;
       	
       	//****trzy kropki do tyłu
    		if ($current >= (4*$size)){
      			$lmt = (($count-$current)<$size) ? $size-($count-$current): 0;
      			
      		  $tabPager[] = array('jump_prev' => $current - (2*$size) - $lmt - 1);
        }
       	//wybrana strona na początku
       	if ($current <= $size){
  			$num_limit++; 
       		for ($i=1; $i<=$num_limit; $i++){
  				  if ($i > $count) break;
         		$tabPager[] = ($i == $current) ? array('curpage' => $i) : array('page' => $i);
        	}     
       	} 
             
  		  //wybrana strona w środku
        if ($current > $size && $current <= ($count -$size) ){
    			for ($i=($current-$size); ($i<($current+$size+1) && $i <= $count); $i++){
         		$tabPager[] = ($i == $current) ? array('curpage' => $i) : array('page' => $i);
        	}     
       	}
       	
  		  //wybrana strona pod koniec pages
  		  if ( $current > ($count -$size) && $current <= $count ){
  		    for ($i=($count-$num_limit); $i<=($count); $i++){
        		if ($i < 1) continue;
         		$tabPager[] = ($i == $current) ? array('curpage' => $i) : array('page' => $i);
        	}     
       	}
       	
       	//trzy kropki do przodu
       	if( ($count-$current)>=(4*$size) ){	
  				 $lmt = ($current<=$size) ? $size-$current+1 : 0 ;
  			   $tabPager[] = array('jump_next' => $current+(2*$size)+1+$lmt);
        }
  		    		    
  		  $tabPager[] = array('from' => $count);  	    
  		
          
		//******pager numeryczny - i podstron jest mniej lub rowno 2*$size		  
		}else{
  		for ($i=1; $i<=$count; $i++){
         $tabPager[] = ($i == $current) ? array('curpage' => $i) : array('page' => $i);
      }
         
      $tabPager[] = array('from' => $count);     	
		}

    //*****ostatnia i nastepna  
    if ( $current != $count ){
        $tabPager[] = array('next' => $current+1);
     	  $tabPager[] = array('last' => $count);
    } 

    
    //****generowanie pagera        
    $show_pager = $labels['pages'];
    
    foreach($tabPager as $p){

      switch( key($p) ){
        case 'first':     $show_pager .= ' <a href="'.$path.current($p).'" title="'.$labels['first'].'"><img src="'.$imgDir.'first.'.$imgExt.'" border="0" alt="'.$labels['first'].'" /></a>';
            break;
        case 'last':      $show_pager .= ' <a href="'.$path.current($p).'" title="'.$labels['last'].'"><img src="'.$imgDir.'last.'.$imgExt.'" border="0" alt="'.$labels['last'].'"/></a>';
            break;
        case 'prev':      $show_pager .= ' <a href="'.$path.current($p).'" title="'.$labels['prev'].'"><img src="'.$imgDir.'prev.'.$imgExt.'" border="0" alt="'.$labels['prev'].'" /> </a>';
            break;
        case 'next':      $show_pager .= ' <a href="'.$path.current($p).'" title="'.$labels['next'].'"><img src="'.$imgDir.'next.'.$imgExt.'" border="0" alt="'.$labels['next'].'"/></a>';
            break;
        case 'jump_prev': $show_pager .= ' <a href="'.$path.current($p).'" title="'.$labels['farprev'].'">...</a> ';
            break;
        case 'jump_next': $show_pager .= ' <a href="'.$path.current($p).'" title="'.$labels['farnext'].'">...</a> ';
            break;
        case 'curpage':   $show_pager .= ' <div class="aktiv">[ '.current($p).' ] </div>';
            break;
        case 'page':      $show_pager .= ' <a href="'.$path.current($p).'" title="'.$labels['page'].' '.current($p).'">'.current($p).'</a>';
            break;
        case 'from':      $show_pager .= ' '.$labels['of'].' <b>'.current($p).'</b> ';
            break;
      }      
    }              
    return $show_pager;    

}

?>
