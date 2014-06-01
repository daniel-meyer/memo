<?php

class CacheController extends Etd_Controller_Action
{

    public function init()
    {
        parent::init();
        
        $this->_helper->getHelper('ViewRenderer')->setNoRender(true);
        
    }
    
    public function clearAction()
    {       
       if(Zend_Registry::isRegistered('cache')){
           $zendCache = Zend_Registry::get('cache');
           $zendCache->clean(Zend_Cache::CLEANING_MODE_ALL);
           echo 'Zend_Cache::CLEANING_MODE_ALL<br />';
       }       
    }
    
    public function clearAllAction()
    {       
       $this->clearCacheFolder();
    }
    
    
    public function clearCacheFolder($subdir='')
    {
        // tych folderów nie czyść
        if(in_array($subdir, array('session/'))){
            return;
        }
        $directory = APPLICATION_PATH."/../cache/" . $subdir;
        $iterator = new DirectoryIterator($directory);
        foreach ($iterator as $fileinfo) {
            if (!$fileinfo->isDot()) {
                if($fileinfo->isDir()){
                    $this->clearCacheFolder($subdir . $fileinfo->getFilename() . '/');
                }else{
                    unlink($directory . $fileinfo->getFilename());
                    echo 'usuwanie pliku: '.$directory . $fileinfo->getFilename().'<br />';
                }
            }
        } 
    }


  
}
