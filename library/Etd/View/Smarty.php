<?php
require_once 'Zend/View/Interface.php';
require_once 'Smarty/Smarty.class.php';

class Etd_View_Smarty extends Zend_View_Abstract 
{
   /**
    * Smarty object
    * @var Smarty
    */
   protected $_smarty;

   protected function _run()
    {
      include func_get_arg(0);
    }
   
   /**
    * Constructor
    *
    * @param string $tmplPath
    * @param array $extraParams
    * @return void
    */
   public function __construct($tmplPath = null, $extraParams = array())
   {
      $this->_smarty = new Etd_Smarty;

      if (null !== $tmplPath) {
         $this->setScriptPath($tmplPath);
      }

      foreach ($extraParams as $key => $value) {
         $this->_smarty->$key = $value;
      }
      
      $this->_smarty->setZendView($this);
   }

   /**
    * Return the template engine object
    *
    * @return Smarty
    */
   public function getEngine()
   {
      return $this->_smarty;
   }

   /**
    * Set the path to the templates
    *
    * @param string $path The directory to set as the path.
    * @return void
    */
   public function setScriptPath($path)
   {
      if (is_readable($path)) {
         $this->_smarty->template_dir = $path;
         return;
      }
      throw new Exception('Invalid path provided :' . $path);
   }

   /**
    * Set the path to the copile directory
    *
    * @param string $path The directory to set as the path.
    * @return void
    */
   public function setCompilePath($path)
   {
      if (is_readable($path)) {
         $this->_smarty->compile_dir   = $path;
         return;
      }
      throw new Exception('Invalid path provided :' . $path);
   }

   /**
    * Set the path to the smarty cache directory
    *
    * @param string $path The directory to set as the path.
    * @return void
    */
   public function setCachePath($path)
   {
      if (is_readable($path)) {
         $this->_smarty->cache_dir   = $path;
         return;
      }
      throw new Exception('Invalid path provided :' . $path);
   }

   /**
    * Get the path to the smarty cache directory
    *
    * @param 
    * @return string $path The directory to set as the path.
    */
   public function getCachePath()
   {
        return $this->_smarty->cache_dir ;    

   }
   
   /**
    * Set the path to the smarty configs directory
    *
    * @param string $path The directory to set as the path.
    * @return void
    */
   public function setConfigPath($path)
   {
      if (is_readable($path)) {
         $this->_smarty->config_dir   = $path;
         return;
      }
      throw new Exception('Invalid path provided :' . $path);
   }

   /**
    * Retrieve the current template directory
    *
    * @return string
    */
   public function getScriptPaths()
   {
      return array($this->_smarty->template_dir);
   }

   /**
    * Alias for setScriptPath
    *
    * @param string $path
    * @param string $prefix Unused
    * @return void
    */
   public function setBasePath($path, $prefix = 'Zend_View')
   {
      return $this->setScriptPath($path);
   }

   /**
    * Alias for setScriptPath
    *
    * @param string $path
    * @param string $prefix Unused
    * @return void
    */
   public function addBasePath($path, $prefix = 'Zend_View')
   {
      return $this->setScriptPath($path);
   }
   
   /**
    * Alias for getVars
    *
    * @return array
    */
   public function getVars()
   {
      return $this->_smarty->_tpl_vars;
   }

   /**
    * Assign a variable to the template
    *
    * @param string $key The variable name.
    * @param mixed $val The variable value.
    * @return void
    */
   public function __set($key, $val)
   {
      $this->_smarty->assign($key, $val);
   }

   /**
    * Retrieve an assigned variable
    *
    * @param string $key The variable name.
    * @return mixed The variable value.
    */
   public function __get($key)
   {
      return $this->_smarty->get_template_vars($key);
   }

   /**
    * Allows testing with empty() and isset() to work
    *
    * @param string $key
    * @return boolean
    */
   public function __isset($key)
   {
      return (null !== $this->_smarty->get_template_vars($key));
   }

   /**
    * Allows unset() on object properties to work
    *
    * @param string $key
    * @return void
    */
   public function __unset($key)
   {
      $this->_smarty->clear_assign($key);
   }

   /**
    * Assign variables to the template
    *
    * Allows setting a specific key to the specified value, OR passing an array
    * of key => value pairs to set en masse.
    *
    * @see __set()
    * @param string|array $spec The assignment strategy to use (key or array of key
    * => value pairs)
    * @param mixed $value (Optional) If assigning a named variable, use this
    * as the value.
    * @return void
    */
   public function assign($spec, $value = null)
   {
      if (is_array($spec)) {
         $this->_smarty->assign($spec);
         return;
      }

      $this->_smarty->assign($spec, $value);
   }

   /**
    * Clear all assigned variables
    *
    * Clears all variables assigned to Zend_View either via {@link assign()} or
    * property overloading ({@link __get()}/{@link __set()}).
    *
    * @return void
    */
   public function clearVars()
   {
      $this->_smarty->clear_all_assign();
   }

   /**
    * Processes a template and returns the output.
    *
    * @param string $name The template to process.
    * @return string The output.
    */
   public function render($name)
   {
      return $this->_smarty->fetch($name);
   }
   
   
    
}
