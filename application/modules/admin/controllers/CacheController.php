<?php

class Admin_CacheController extends Etd_Controller_Action
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
           echo 'clean Zend_Cache::CLEANING_MODE_ALL<br />';
       }
        
       $this->clearCacheFolder(APPLICATION_PATH."/../cache/");
       $this->clearCacheFolder(APPLICATION_PATH."/../public/img_cache/");
       
       if($this->_session->debug){
            return;
       }
       $this->addMessage('Wyczyszczono pamięć cache serwisu');
       $this->_redirect('admin');
       
    }
    
    
    public function clearCacheFolder($dir, $subdir='')
    {
        // tych folderów nie czyść
        if(in_array($subdir, array('session/'))){
            return;
        }
        $directory = $dir . $subdir;
        $iterator = new DirectoryIterator($directory);
        foreach ($iterator as $fileinfo) {
            if (!$fileinfo->isDot()) {
                if($fileinfo->isDir()){
                    $this->clearCacheFolder($dir,$subdir . $fileinfo->getFilename() . '/');
                }else{
                    unlink($directory . $fileinfo->getFilename());
                    echo 'usuwanie pliku: '.$directory . $fileinfo->getFilename().'<br />';
                }
            }
        } 
    }


  
}
