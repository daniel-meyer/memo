<?php
require_once 'Smarty/Smarty_Compiler.class.php';

class Smarty_ZendCompiler extends Smarty_Compiler
{
  private $_zendView;
 
  public function __construct()
  {
    parent::__construct();
    //$this->_zendView = new Zend_View();
    $this->_zendView = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');
  }

  
   public function _compile_compiler_tag($tagCommand, $tagArgs, &$output) { 
    //We first try to use Smarty's own functionality to parse the tag 
    $found = parent::_compile_compiler_tag($tagCommand,$tagArgs,$output); 
    if(!$found) { 
        try { 
            //Check if helper exists and create output 
            $helper = $this->_zendView->getHelper( $tagCommand ); 
            $helperArgs = array(); 
            if($tagArgs !== null) { 
                //Start parsing our custom syntax 
                $tagArgs = preg_replace('#\s+#', ' ', $tagArgs);
                $params = explode(' ',$tagArgs); 
                foreach($params as $p) { 
                    //Split each key=value pair to vars 
                    list( $key, $value ) = explode( '=', $p, 2); 
                    $key = trim($key); 
                    $value = trim($value); 
                    //If there's a dot in the key, it means we 
                    //need to use associative arrays 
                    if( strpos( $key, '.' ) != 0 ) { 
                        list( $key, $section ) = explode( '.', $key ); 
                    } 
                    //Use Smarty's own functions to parse the value 
                    //so that if there's a variable, it gets changed to 
                    //properly point at a template variable etc. 
                    $value = $this->_parse_var_props( $value ); 
                    //Put the value into the arg array 
                    if( $section == '' ) { 
                        if( array_key_exists( $key, $helperArgs ) ) { 
                            if( is_array( $helperArgs[$key])) { 
                                $helperArgs[ $key ][] = $value; 
                            } else { 
                                $helperArgs[ $key ] = array( $helperArgs[ $key ], $value ); 
                            } 
                        } else { 
                            if( $key == 'arr' ) { 
                                $helperArgs[$key] = array( $value ); 
                            } else { 
                                $helperArgs[$key] = $value; 
                            } 
                        } 
                    } else { 
                        if( !is_array( $helperArgs[ $key ] ) ) { 
                            $helperArgs[ $key ] = array(); 
                        } 
                        $helperArgs[ $key ][ $section ] = $value; 
                        $section = ''; 
                    } 
                } 
            } 
            //Save the code to put to the template in the output 
            $output = "<?php echo \$this->callViewHelper('$tagCommand',array(".$this->_createParameterCode($helperArgs).")); ?>"; 
            $found = true; 
            
        } catch(Zend_Loader_PluginLoader_Exception $e) { 
            //Exception means the helper was not found 
            $found = false; 
        } 
    } return $found; 
 } 
 
 /** 
  * This function creates the code for the helper params
  * @param array $params 
  * @return string $code 
  * @access private 
  */ 
  
  private function _createParameterCode( $params ) { 
    $code = ''; 
    $i = 1; 
    $pCount = count($params); 
    foreach($params as $p) { 
        if(is_array($p)) { 
            $code .= 'array('; 
            foreach ($p as $cle=>$elem) { 
                if( strlen( trim($elem) ) ) { 
                    $elem = trim( $elem ); 
                } else { 
                    $elem = ''; 
                } 
                $code .= "'".$cle.'\' => '. $elem .','; 
            } $code .= ')'; 
        } else { 
            $code .= $p; 
        } 
        if($i != $pCount) { 
            $code .= ','; 
        } $i++; 
    } return $code; 
  }
}