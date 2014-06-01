<?php 

class Etd_Captcha extends Zend_Captcha_Image
{
    protected $dir;
    protected $fontFile;
    
    public function __construct($timeout=300)
    {
       $this->dir = APPLICATION_PATH.'/../public/upload/captcha/';
       $this->fontFile = APPLICATION_PATH.'/../public/scripts/fonts/Arial.ttf';
       //check dir
       $upload = new Etd_Upload;
       $upload->setDir($this->dir);
       if(false == $upload->checkDir()){
            throw new Exception($upload->getMessage());
       }
       
       //check font
       if(false == file_exists($this->fontFile)){
            throw new Exception('Nie znaleziono fonta: '.$this->fontFile);
       }
       
       
       
       $this->deleteOldCaptcha($timeout);
       
       parent::__construct(array(
                    'captcha' => 'Image',
                    'wordLen' => 4,
                    'timeout' => $timeout,
                    'imgDir' => $this->dir,
                    'ImgUrl' =>  '/public/upload/captcha/',
                    'width' => 180,
                    'height' => 80,
                    'font' => $this->fontFile,
                    'fontSize' => 37
                    )
        );
        
        echo $this->getWord();
        
        Zend_Registry::set('Etd_Captcha', $this);
   
    }
    
    
    
    protected  function deleteOldCaptcha($timeout=300)
    {
        $dir=$this->dir;
        
        if ($pliki = opendir($dir)) 
        {
            $teraz = time();
            while($file = readdir($pliki ))
            {
                $time = filemtime($dir.'/'.$file);
                if($teraz-$time>$timeout)
                {
                    @unlink($dir.'/'.$file);
                }
            }
        }
    }

      
}