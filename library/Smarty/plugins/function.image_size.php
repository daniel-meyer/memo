<?php

function smarty_function_image_size($params, &$smarty)
{
    if (empty($params['file'])) {
        $smarty->_trigger_fatal_error("[plugin] parameter 'file' cannot be empty");
        return;
    }
    if (!isset($params['mode'])) {
        $params['mode'] = 'xy';
    }
    
    if(substr($params['file'], 0, 1) != '/'){
        $params['file'] = '/' . $params['file'];
    }
    
    
    $file = realpath( APPLICATION_PATH . '/..') . $params['file'];
    if(!file_exists($file)){
        return '';
    }
    
    $size = getimagesize($file); 
    
    if($params['mode'] == 'width'){
        return $size[0];
    }
    
    if($params['mode'] == 'height'){
        return $size[1];
    }

    return 'width="' . $size[0] .'" height="' . $size[1] .'"';
    
}