<?php
/**
 * Image
 *
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3.0 of the License, or (at your option) any later version.
 *
 * Zabrania się usuwania informacji o autorze
 *
 * @version    1.1
 * @category   Image
 * @package    Image
 * @author     Krzysztof Kardasz <krzysztof.kardasz@gmail.com>
 * @link       http://code.google.com/p/image-class
 * @svn        http://image-class.googlecode.com/svn/trunk/
 * @copyright  Copyright (c) Krzysztof Kardasz
 * @license    http://www.gnu.org/licenses/lgpl-3.0.txt  GNU Lesser General Public
 */

/**
 * @category   Image
 * @package    Image
 * @author     Krzysztof Kardasz
 * @copyright  Copyright (c) Krzysztof Kardasz
 */

/**
 * @modified_by Daniel Meyer 
 * @package     class.Image.php
 * @author      Daniel Meyer
 * @copyright   Copyright (c) Etendard Sp. z o.o.
 * @link        http://www.etendard.pl/ 
 */ 
 
class Etd_Image extends Etd_Upload
{
    public $color=array(255,255,255); //RGB tlo obrazka
    
    private
    $resource = false,
    /**
     * Szerokosć zdjęcia
     *
     * @access private
     * @var integer
     */
    $width    = null,
    /**
     * Wysokość zdjęcia
     *
     * @access private
     * @var integer
     */
    $height   = null,
    /**
     * Typ pliku
     *
     * @access private
     * @var string
     */
    $type     = null,
    /**
     * Rozszeżenie zdjęcia (gif/jpg/png)
     *
     * @access private
     * @var string
     */
    $exts     = null;



    /**
     * Komunikaty błędów
     */
    const
        NoExists          = 'Image file no exists',
        ErrorOpen         = 'Image file no opened',
        ErrorComposeOpen  = 'Image to compose is no opened',
        ErrorFormat       = 'Wrong file format',
        ErrorCrop         = 'Error croping image',
        ErrorResize       = 'Error resizing image',
        ErrorResizeCanvas = 'Error croping image',
        ErrorCompose      = 'Error compose image',
        LimitType         = 'Image type is disabled'
        ;


    /**
     * Iniciation
     * Inicjacja
     *
     * @access public
     * @param string $ImageFile path to image file
     * @return void
     */
    public function __construct()
    {
      parent::__construct();
    }
    
    
    public function getW()
    {
      return $this->width;
    }
    public function getH()
    {
      return $this->height;
    }
    

    /**
     * Próba pobrania informacji o obrazku
     *
     * @access public
     * @return Image
     */
    public function check()
    {
       
        if(!file_exists($this->file['tmp_name'])) {
            $this->message[] = self::NoExists;
            return false;
        }

        $Image = @getimagesize($this->file['tmp_name']);
        if(!$Image || empty($Image[2]) || $Image[2]>3) {
            $this->message[] = self::ErrorFormat;
            return false;
        }
 
        $this->width  = $Image[0];
        $this->height = $Image[1];
        $this->type   = $Image[2];
      return  true;
    } 
     
        
    /**
     * Try to open the image
     * Próba otwarcia pliku
     *
     * @access public
     * @return Image
     */
    public function open()
    {
        if(!$this->check()) return false;

        switch($this->type) {
            case IMAGETYPE_JPEG: $this->resource = imageCreateFromJpeg($this->file['tmp_name']); $this->exts = 'jpg'; break;
            case IMAGETYPE_PNG:  $this->resource = imageCreateFromPng($this->file['tmp_name']);  $this->exts = 'png'; break;
            case IMAGETYPE_GIF:  $this->resource = imageCreateFromGif($this->file['tmp_name']);  $this->exts = 'gif'; break;

            default: $this->message[] = self::ErrorFormat;  return false;
        }
        
        return true;
    }


    /**
     * Frees any memory associated with image image
     * Zwalnia pamięć przydzieloną dla zdjęcia
     *
     * @access public
     * @return boolean
     */
    public function close()
    {
        if(!$this->resource) {
            $this->message[] = self::ErrorOpen;
            return false;
        }

        return imagedestroy($this->resource);
    }
    
    
   /**
     * Save image to file
     * Zapisanie zmian (lub zapisanie do innego pliku)
     *
     * @access public
     * @param string|null $Name
     * @param integer $Quality
     * @return Image
     */   
    public function save($dir = null, $Quality = 100)
    {
        if(!$this->resource) {
            $this->message[] = self::ErrorOpen;
            return false;
        }
        
        if(!empty($this->message)){
          return false;
        }
        $this->dir = $dir;
        
        if(!$this->checkDir()) {
            return false;
        }
        
        $this->_checkFileExists();
             

        switch($this->type)
        {
          case IMAGETYPE_JPEG:
            $Quality = round((int)$Quality);
            $Quality = ($Quality > 100) ? 100 : (($Quality < 0) ? 0 : $Quality);
            if(!imagejpeg($this->resource, $this->dir . $this->file['name'] , $Quality)) {
                $this->message[] = self::ErrorSave;
                return false;
            }
          break;

          case IMAGETYPE_PNG:
            if(!imagepng($this->resource, $this->dir . $this->file['name'])) {
                $this->message[] = self::ErrorSave;
                return false;
            }
          break;

          case IMAGETYPE_GIF:
            if(!imagegif($this->resource, $this->dir . $this->file['name'])) {
                $this->message[] = self::ErrorSave;
                return false;
            }
          break;
        }

        
        return true;
    }    
    
    /**
     * Resize image
     * Zmiana rozmiaru zdjęcia
     *
     * @access public
     * @param integer $Width
     * @param integer $Height
     * @return Image
     */
    public function resize($Width, $Height)
    { 
        if(!$this->resource) {
            $this->message[] = self::ErrorOpen;
            return false;
        }

        $Image = imagecreatetruecolor($Width, $Height);

        if(!imagecopyresampled($Image, $this->resource, 0, 0, 0, 0, $Width, $Height, $this->width, $this->height)) {
            $this->message[] = self::ErrorResize;
            return false;
        }

        $this->resource  = $Image;
        $this->width     = $Width;
        $this->height    = $Height;

        return true;
    }
    
    
    /**
     * Crop image
     * Wycięcia zdjęcia
     *
     * @access public
     * @param integer $X1
     * @param integer $Y1
     * @param integer $X2
     * @param integer $Y2
     * @return Image
     */
     
    public function crop($X1, $Y1, $X2, $Y2)
    {
        if(!$this->resource) {
            $this->message[] = self::ErrorOpen;
            return false;
        }

        $Width  = $X2 - $X1;
        $Height = $Y2 - $Y1;

        $Image = imagecreatetruecolor($Width, $Height);

        if(!imagecopy($Image, $this->resource, 0, 0, $X1, $Y1, $Width, $Height)) {
            $this->message[] = self::ErrorCrop;
            return false;
        }

        $this->resource  = $Image;
        $this->width  = $Width;
        $this->height = $Height;

        return $this;
    }


    /**
     * Resize image aspect ratio
     * Zmiana rozmiaru jeśli za duży
     *
     * @access public
     * @param integer $Width
     * @param integer $Height
     *
     * @return Image
     */
    public function resizeToWidthHeight($Width, $Height)
    {
        if(!$this->resource) {
            $this->message[] = self::ErrorOpen;
            return false;
        }

        if ($Width < $this->width || $Height < $this->height) {
           
           if($this->width >= $this->height){
                return $this->ResizeToWidth($Width);
           }else{
                return $this->ResizeToHeight($Height);
           }
            
        }
    }

    /**
     * Resize image by width aspect ratio
     * Zmiana rozmiaru względem szerokość (uwzględniając proporcje)
     *
     * @access public
     * @param integer $Width
     * @return Image
     */
    public function resizeToWidth($Width)
    {
        if(!$this->resource) {
            $this->message[] = self::ErrorOpen;
            return false;
        }

        $Height = ($Width * $this->height) / $this->width;

        return $this->resize($Width, $Height);

    }

    /**
     * Resize image by height aspect ratio
     * Zmiana rozmiaru względem wysokości (uwzględniając proporcje)
     *
     * @access public
     * @param integer $Height
     * @return Image
     */
    public function resizeToHeight($Height)
    {
        if(!$this->resource) {
            $this->message[] = self::ErrorOpen;
            return false;
        }

        $Width = ($this->width * $Height) / $this->height;

        return $this->resize($Width, $Height);
    }
    
    public function resizeBlurMirror($w, $h)
    {
        //$this->resource = imagerotate($this->resource, 180, 0);
        //$this->resource =ImageFlip($this->resource,IMAGE_FLIP_HORIZONTAL);
        $this->flipHorizontal();
        /*
        $matrix = array( array(5, 5, 5), array(0, 0, 0), array(5, 5, 5));
        for($i = 1; $i<=30; $i++) {
            imageconvolution($this->resource, $matrix, 30, 0);
        }*/
                
        $this->resizeAndCut(645, 235);
        
        $this->cropLeft($w, $h);
        
        //$gaussian = array( array(5, 5, 5), array(0, 0, 0), array(5, 5, 5));
        $gaussian = array(array(1.0, 2.0, 1.0), array(2.0, 4.0, 2.0), array(1.0, 2.0, 1.0));
                
        for($i = 1; $i<=5; $i++) {
            imageconvolution($this->resource, $gaussian, 16, 0);
        }        


        return $this;
    }
    
    public function flipHorizontal() {
        $size_x = $this->width;
        $size_y = $this->height;
        $temp = imagecreatetruecolor($size_x, $size_y);
        imagecopyresampled($temp, $this->resource, 0, 0, ($size_x-1), 0, $size_x, $size_y, 0-$size_x, $size_y);
        
        $this->resource = $temp;
    }
 
    /**
     * Zmiana rozmiaru względem wysokości i szerokoci
     * odcina nadmiar z wymiarów 
     * Uzywana głównie do miniaturek         
     *
     * @access public
     * @param integer $w
     * @param integer $h     
     * @return Image
     */
    public function resizeAndCut($w,$h)
    {
      if(!$this->resource) {
            $this->message[] = self::ErrorOpen;
            return false;
      }
      $ratio = ($this->width / $this->height);
      $newRatio= $w/$h;  //ratio nowego obrazka
      
      if ($ratio < $newRatio) {
      //przycinamy gora i dol
        $newImgW = $this->width;
        $newImgH = floor($this->width/ $newRatio);
        $x = 0;
        $y = floor(($this->height - $newImgH)/2);
      } else { 
      //przycinamy lewa prawa
        $newImgW = floor($this->height* $newRatio);
        $newImgH = $this->height;
        $x = floor(($this->width - $newImgW)/2);
        $y = 0;  
      }  
             
      //PRZYCINANIE
      $Image = imagecreatetruecolor($newImgW, $newImgH);
      ImageCopy($Image, $this->resource, 0,0,$x,$y,$newImgW,$newImgH);
        
            
      //zmiana rozmiaru
      $newImageHandle = imagecreatetruecolor($w, $h);
        
      imagecopyresampled($newImageHandle, $Image, 0, 0, 0, 0, $w, $h, $newImgW, $newImgH);
    
      $this->resource  = $newImageHandle;
      $this->width  = $w;
      $this->height = $h;
    
      return $this;
    }
    
    public function grayThumb($w, $h)
    {      
        $this->resizeAndCut($w, $h);
        
        $this->cropLeft($w, $h);
        
        imagefilter($this->resource, IMG_FILTER_GRAYSCALE);
      
        return $this;
    }
    
    
    public function cropLeft($w,$h)
    {
      if(!$this->resource) {
            $this->message[] = self::ErrorOpen;
            return false;
      }
      $ratio = ($this->width / $this->height);
      $newRatio= $w/$h;  //ratio nowego obrazka
      
      if ($ratio < $newRatio) {
      //przycinamy gora i dol
        $newImgW = $this->width;
        $newImgH = floor($this->width/ $newRatio);
        $x = 0;
        $y = floor(($this->height - $newImgH)/2);
      } else { 
      //przycinamy lewa prawa
        $newImgW = floor($this->height* $newRatio);
        $newImgH = $this->height;
        $x = floor(($this->width - $newImgW)/2);
        $y = 0;  
      }  
             
      //PRZYCINANIE
      $Image = imagecreatetruecolor($newImgW, $newImgH);
      imagecopy($Image, $this->resource, 0,0,0,0,$newImgW,$newImgH);
        
            
      //zmiana rozmiaru
      $newImageHandle = imagecreatetruecolor($w, $h);
        
      imagecopyresampled($newImageHandle, $Image, 0, 0, 0, 0, $w, $h, $newImgW, $newImgH);
    
      $this->resource  = $newImageHandle;
      $this->width  = $w;
      $this->height = $h;
    
      return $this;
    }
       
     /**
     * Zmiana rozmiaru względem wysokości i szerokoci
     * dodaje paski aby dopełnić wymiar
     * Uzywana głównie do miniaturek         
     *
     * @access public
     * @param integer $w
     * @param integer $h     
     * @return Image
     */
    public function resizeWithBorder($w,$h)
    {
      if(!$this->resource) {
            $this->message[] = self::ErrorOpen;
            return false;
      }
      $ratio = ($this->width / $this->height);
      $newRatio= $w/$h;  //ratio nowego obrazka
      
      $xx=0;
      $yy=0;
      $x=0;
      $y=0;

      if($this->width<$w || $this->height<$h)
        {           //jezeli obrazek zrodlowy jest mniejszy  
        
        if($this->width<$w && $this->height<$h)
        {
          $x=floor(($w-$this->width)/2);
          $y=floor(($h-$this->height)/2);
        }  
        //
        if($this->width<$w && $this->height>=$h)
        { 
          $x = floor(($w - $this->width)/2);
          $yy=-floor(($h-$this->height)/2);
        }
        //
        if($this->width>=$w && $this->height<$h)
        { // echo 'ok';
          $y = floor(($h - $this->height)/2);        
          $xx = -floor(($w - $this->width)/2);
        }
                       
        $imgHandle2 = imagecreatetruecolor($w,$h);
        $imageColor=ImageColorAllocate($imgHandle2, $this->color[0], $this->color[1], $this->color[2]);
        ImageFill($imgHandle2, $x,$y, $imageColor);
        //PRZYCINANIE
        ImageCopy($imgHandle2, $this->resource,$x,$y ,$xx,$yy,$this->width,$this->height);
    
          
      }
      else
      {
        if ($ratio < $newRatio) 
        { //przycinamy gora i dol
          $nh =$h;
          $nw=floor($h* $ratio);
        } else 
        { //przycinamy lewa prawa
          $nw=$w;
          $nh=floor($w/ $ratio);
        }  
        //zmiana rozmiaru
        $newImageHandle = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($newImageHandle, $this->resource, 0, 0, 0, 0, $nw, $nh, $this->width, $this->height);

        //
        if($nw<$w && $nh<$h)
        {
          $x=floor(($w-$nw)/2);
          $y=floor(($h-$nh)/2);
        }  
        //
        if($nw<$w && $nh>=$h)
        { 
          $x = floor(($w - $nw)/2);
          $yy=-floor(($h-$nh)/2);
        }
        //
        if($nw>=$w && $nh<$h)
        {  //
          $y = floor(($h - $nh)/2);
          $xx = -floor(($w - $nw)/2);
        }
            
        $imgHandle2 = imagecreatetruecolor($w,$h);
        $imageColor=ImageColorAllocate($imgHandle2, $this->color[0], $this->color[1], $this->color[2]);
        ImageFill($imgHandle2, $x,$y, $imageColor);
    
        //PRZYCINANIE
        ImageCopy($imgHandle2, $newImageHandle,$x,$y ,$xx,$yy,$nw,$nh);
              
      }
      
      $this->resource  = $imgHandle2;
      $this->width  = $w;
      $this->height = $h;
    
      return $this;
    }
}

?>