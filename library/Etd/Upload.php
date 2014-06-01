<?php
/**
 * Upload
 *
 *
 * @version    1.3
 * @date       9.06.2008 
 * @category   Upload files
 * @package    class.Upload.php
 * @author     Daniel Meyer <daniel.meyer@etendard.pl>
 * @link       http://www.etendard.pl/
 * @copyright  Copyright (c) Etendard Sp. z o.o.
 */


class Etd_Upload
{
	protected
        $message = array(),
        $file    = array(),
        $dir     = '',
        $tempExt = '.temp',
        $oldFile = '',
        $id      = 0,   
        $fileExts = array(),
        $overRide = false;
    

    /**
     * Komunikaty błędów
     */
    const
        NoExists          = 'Image file no exists',
        ErrorOpen         = 'Image file no opened',
        ErrorComposeOpen  = 'Image to compose is no opened',
        ErrorFormat       = 'Wrong file format uploaded file',
        ErrorCrop         = 'Error croping image',
        ErrorResize       = 'Error resizing image',
        ErrorResizeCanvas = 'Error croping image',
        ErrorCompose      = 'Error compose image',
        ErrorGrayScale    = 'Error filter grayscale',
        ErrorBrightness   = 'Error filter brightness',
        ErrorNegative     = 'Error filter negative',
        ErrorContrast     = 'Error filter contrast',
        ErrorColorize     = 'Error filter colorize',
        ErrorSave         = 'Error saving image',
        ErrorCopy         = 'Kopiowanie pliku nie powiodło się',
        LimitType         = 'Musisz utworzyć katalog: ',
        Katalog           = 'Katalog: ',
        ErrorAttr         = ' nie posiada atrybutów do zapisu'
        ;
   public function __construct()
    {
//echo 'ok';
      //global $file_ext;
      $this->fileExts = array('jpeg','jpg','gif','png','zip','rar','txt', 'doc','pdf','xls','7z', 'asf', 'avi', 'bmp', 'csv', 'fla', 'flv', 'gz', 'gzip', 'mid', 'mov', 'mp3', 'mp4', 'mpc', 'mpeg', 'mpg', 'ods', 'odt', 'ppt', 'pxd', 'qt', 'ram', 'rm', 'rmi', 'rmvb', 'rtf', 'sdc', 'sitd', 'swf', 'sxc', 'sxw', 'tar', 'tgz', 'tif', 'tiff', 'vsd', 'wav', 'wma', 'wmv', 'xml') ;
    }
    /**
     * Pobiera błędy w formie stringa
     *      
     *       
     * @access public
     * @return string
     */
   public function getMessage()
    {
      $info = '';
      foreach ($this->message as $err){
         $info .= "<br />$err";
      }
      if(!empty($info)) 'Błąd!'.$info;
      return $info; 
    }

    /**
     * Sprawdza czy katalog istnieje
     *      
     * Jeżeli katalog nie istnieje, próbuje go utworzyć
     *       
     * @access public
     * @return boolean
     */
	public function checkDir()
	{
        return self::checkDirExists($this->dir);     
    }   
     
     
 	public static function checkDirExists($dir)
    {
        if(!is_dir($dir)){
             if(mkdir($dir, 0777)){
                chmod($dir, 0777);
             }
        }
        if(!is_writable($dir)){ 
            chmod($dir, 0777);
        }
        if(!is_writable($dir)){
            throw new Exception('Nie można zapisać do katalogu: '.$dir);
        }
        return true;
    }

    
      /**
     * Zwraca nazwę pliku  
     * 
     * Jesli '$withDir = true' zwraca nazwę za scieżka dostępu           
     *       
     * @access public
     * @parm boolean $withDir  
     * @return new filename
     */
	public function getName($withDir = false)
    {    
 		return  ($withDir ? $this->dir.$this->file['name'] : $this->file['name']);
 	}   
    
    public function setName($name)
    {    
 		return  $this->file['name'] = $name;
 	}
     
     public function setOverRide($override)
    {    
 		$this->overRide = $override;
 	}  
          
    public function addSurfix($surfix)
    {    
 		$parts = explode('.', $this->file['name']);
        $ext = array_pop($parts);
        
        $this->file['name'] = join('.', $parts).'_'.$surfix. '.' .$ext;
 	}  
    
    public function cutExt($filename)
    {    
 		$parts = explode('.' ,$filename);
        $ext = array_pop($parts);
        
        return join('.', $parts);
 	} 
    
    
    
    public function setId($id)
    {    
        $this->id = $id;
 	}    
   
    /**
     * Załadowanie pliku z zmiennej $_FILES
     *
     * @access public
     * @parm string $name Index from $_FILES array
     * @return boolean
     */
    public function prepare($name)
    {    
        if(!empty($_FILES[$name]) && !empty($_FILES[$name]['tmp_name']) && !empty($_FILES[$name]['name'])) { 
        
            $this->file = array(
                'fullname' => $_FILES[$name]['name'],
                'type'     => $_FILES[$name]['type'],
                'size'     => $_FILES[$name]['size'],
                'tmp_name' => $_FILES[$name]['tmp_name'],
                'error'    => $_FILES[$name]['error'],
                'ext'      => strtolower( substr(strrchr($_FILES[$name]['name'], '.'), 1) )
            );
            if ($this->file['ext'] == 'jpeg'){
                $this->file['ext'] = 'jpg';
            }
            $name = substr($_FILES[$name]['name'], 0, -4);
            $this->file['onlyname'] = $name;
            $this->file['name'] = $this->prepareFilename($name). '.' . $this->file['ext'];               
            return true;
      }   
      
        return false; 	  
 	}
    
     public function setFile($filename)
     {
        if(!file_exists($filename)){
            return false;
        }
        
        $this->file = array(
            'fullname' => basename($filename),
            'type'     => '',
            'size'     => 0,
            'tmp_name' => $filename,
            'onlyname' => $this->cutExt(basename($filename)),
            'error'    => '',
            'ext'      => strtolower( substr(strrchr($filename, '.'), 1) )
        );
        
        
        if ($this->file['ext'] == 'jpeg'){
            $this->file['ext'] = 'jpg';
        }
        
        $this->file['name'] = $this->prepareFilename($this->cutExt($this->file['fullname'])). '.' . $this->file['ext'];      
        
        return true;       
     }
     
     private function prepareFilename($name)
     {
        $filter = new Etd_Filter_Slug;
        return $filter->filter($name);
     }   	
    
   
    /**
     * Zapisuje plik we wskazanym katalogu  
     *       
     * @access public
     * @parm string $dir      
     * @return boolean
     */
	public function copy($dir)
    {    
        $this->dir = $dir;

        if( $this->checkDir() && !empty($this->file) && $this->checkExt()){
            
            $this->_checkFileExists();

            if(copy($this->file['tmp_name'], $this->dir . $this->file['name'] )){
                return true;	      
            }else{	
                $this->message[] = self::ErrorCopy;
    		}			 
        }
        return false;   	  
 	}
    
    protected function _checkFileExists()
    {
        if($this->overRide){
            return;
        }
        if(file_exists($this->dir . $this->file['name'])){
                $this->file['name'] = $this->_fileNumerator();
        }
    }
     
    protected function _fileNumerator($i=1)
    {
        $name = $this->file['onlyname']. '('.$i.')';
        if(file_exists($this->dir . $name . '.' . $this->file['ext'])){
            return $this->_fileNumerator($i+1);
        }
        return $name . '.' .$this->file['ext'];
    }   	

  	  
      /**
     * ustaw filtr rozszerzeń plików    
     *
     * @parm array $arr               
     * @return boolean
     */
	public function setFileExt($arr)
  { 
    if(is_string($arr)) $this->fileExts = array($arr);
    elseif(is_array($arr)) $this->fileExts = $arr;
    else return false;
    return true;  
  } 

  
    /**
     * Szuka nazwy obrazka po id    
     *          
     * @return boolean
     */
	public function checkExt()
  { 
       if (in_array($this->file['ext'], $this->fileExts)){
          return true;
       }else{
          $this->message[] = self::ErrorFormat;
          return false;
       }
  
  } 
  	public function setDir($dir)
  { 
       $this->dir = $dir;  
      return $this->checkDir();
  
  } 	      
}
