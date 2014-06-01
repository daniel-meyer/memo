<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


function smarty_modifier_admin_file_icon($file)
{
    $types = array(
        '3gp',
        'ai',
        'bmp',
        'cdr',
        'doc',
        'eps',
        'exe',
        'flv',
        'gif',
        'jpg',
        'jpeg',
        'mov',
        'mp3',
        'pdf',
        'png',
        'pps',
        'ps',
        'rar',
        'swf',
        'tif',
        'txt',
        'xls',
        'zip'
    );
    
    $ext = strtolower(end(explode('.', $file)));
    
    if(in_array($ext, $types)){
        return $ext;
    }else{
        return '';
    }
     
}
