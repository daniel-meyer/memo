<?php

class Etd_View_Helper_TbFileSelect extends Zend_View_Helper_Abstract
{
    /**
     * Generate filelist html for select
     *
     * @param  string $dir
     * @param  string $selectedFile 
     * @return string|void
     */
    public function tbFileSelect($dir, $selectedFile=null)
    {
        $myDir = APPLICATION_PATH . '/../' . $dir;
        $files = array();
        //return $myDir;
        $di = new DirectoryIterator($myDir);

        foreach($di as $fileInfo) {
            if(!$fileInfo->isDot()) {
                $files[$dir . $fileInfo->getFilename()] =  $fileInfo->getFilename();
            }
        }

        return $this->view->formSelect('tb_files', $dir . $selectedFile, array('id'=>'tb_files'), $files);
        
    }
}
