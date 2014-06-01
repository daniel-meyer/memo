<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty plugin
 *
 * Type:     modifier<br>
 * Name:     nl2br<br>
 * Date:     Feb 26, 2003
 * Purpose:  convert \r\n, \r or \n to <<br>>
 * Input:<br>
 *         - contents = contents to replace
 *         - preceed_test = if true, includes preceeding break tags
 *           in replacement
 * Example:  {$text|nl2br}
 * @link http://smarty.php.net/manual/en/language.modifier.nl2br.php
 *          nl2br (Smarty online manual)
 * @version  1.0
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_function_thumb($params, &$smarty)
{
    if (empty($params['file'])) {
        $smarty->_trigger_fatal_error("[plugin] parameter 'file' cannot be empty");
        return;
    }
    if (!isset($params['width'])) {
        $smarty->_trigger_fatal_error("[plugin] parameter 'width' cannot be empty");
        return;
    }
    if (!isset($params['height'])) {
        $smarty->_trigger_fatal_error("[plugin] parameter 'height' cannot be empty");
        return;
    }
    
    $w = intval($params['width']);
    $h = intval($params['height']);
    
    $mode = isset($params['mode']) ? $params['mode'] : 'ratio';
    
    
    $dir = realpath(APPLICATION_PATH . "/../public/img_cache");
    $path = "public/img_cache";
    
    if(substr($params['file'], 0, 1) != '/'){
        $params['file'] = '/' . $params['file'];
    }
    
    if(substr($params['file'], 0, 8) != '/public/'){
        $params['file'] = '/public' . $params['file'];
    }
    
    $oldFile = realpath( APPLICATION_PATH.'/..').$params['file'];
    if(!file_exists($oldFile)){
        return '';
    }
    $mTime = '';//
    $mTime = filemtime($oldFile);

    $hash = md5($params['file'].$mTime).'_'.str_replace(' ', '', basename($params['file']));
    
    $subDir = '/'.$w.'x'.$h.'/'.$mode;
    $newFile = $dir. $subDir. '/' . $hash; 
    
    if(!file_exists($oldFile) && file_exists($newFile)){
        unlink($newFile);
        return '';
    }
    if(file_exists($newFile)){
        return $path . $subDir. '/' . $hash;
    }    
    //die($oldFile .' == '. $newFile);
    if(file_exists($oldFile)){
        //tutaj bedzie konwersja
        
        $oImg = new Etd_Image;
        $oImg->setFile($oldFile);
        $oImg->setName($hash);
        $oImg->checkDirExists($dir . '/' . $w .'x' . $h);
        $oImg->checkDirExists($dir . $subDir);
        
        if($oImg->check() && $oImg->open()){
            switch ($mode){ 
                
            	case 'withBorder':
                    if($params['color']){
                        $oImg->color = explode(',', $params['color']);
                    } 
                    
                    $oImg->resizeWithBorder($w, $h);
            	break;
            
            	case 'crop': 
                    $oImg->resizeAndCut($w, $h);
            	break;
                
            	case 'grayThumb': 
                    $oImg->grayThumb($w, $h);
            	break;
                
            
            	case 'toWidth': 
                    $oImg->resizeToWidth($w);
            	break;
                
            	case 'toHeight': 
                    $oImg->resizeToHeight($h);
            	break;
                
            	case 'blurMirror': 
                    $oImg->resizeBlurMirror($w, $h);
            	break;
                
                
            	case 'watermark': 
                    $oImg->resizeToWidthHeight($w, $h);
                    $oImg->watermark(APPLICATION_PATH . '/../public/default/images/watermark.png');
                break;
            
            	default : 
                    $oImg->resizeToWidthHeight($w, $h);
            }
            
            
            $oImg->save($dir . $subDir . '/');

        }
    } 
    
    if(file_exists($newFile)){
        return $path . $subDir . '/' . $hash;
    }else{
        return '';
    }
    
}

/* vim: set expandtab: */

?>
