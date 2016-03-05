<?php

class ErrorController extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
        
        $this->_helper->getHelper('Layout')->disableLayout();

        $this->view->title = 'An error occurred';
    }
    
    public function postDispatch()
    {
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->getHelper('ViewRenderer')->setNoRender(true);
            echo $this->view->message;
            
            if ($this->view->exception) {
                echo ': ' . $this->view->exception->getMessage();
            }
            exit();
        }
    }
    
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->crit($this->view->message, $errors->exception);
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            //$session = Zend_Registry::get('session');
            //if(!empty($session->debug)){
            $this->view->exception = $errors->exception;
            
            // fix stack trace in case it doesn't contain the exception origin as the first entry
            $fixedTrace = $errors->exception->getTrace();
            $e = $errors->exception;

            if (isset($fixedTrace[0]['file']) &&
                    !($fixedTrace[0]['file'] == $e->getFile() && $fixedTrace[0]['line'] == $e->getLine())
            ) {
                $fixedTrace = array_merge(array(array('file' => $e->getFile(), 'line' => $e->getLine())), $fixedTrace);
            }
            $this->view->fixedTrace = $this->generateTrace($fixedTrace);
            
            $this->view->zend_version = Zend_Version::VERSION;
            $this->view->phpversion = phpversion();
            $this->view->uname = php_uname();
            $this->view->exception = $e;
            $this->view->request = $errors->request;
        }
    }

    public function privilegesAction()
    {
        
        $this->view->message = 'Access to this location is not allowed';
        $this->render('error');
    }

    public function pageNotFoundAction()
    {
        // 404 error -- controller or action not found
        $this->getResponse()->setHttpResponseCode(404);
        $this->view->message = 'Page not found';
        $this->render('error');
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasPluginResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');

        return $log;
    }

    private function generateTrace($fixedTrace)
    {
        
        ob_start();
        
        echo '<ol>';
        $i = 0;
        $highlights = array();
        foreach ($fixedTrace as $trace):
            $i++;
            if (isset($trace['file']) && !isset($highlights[$trace['file']])) {
                $highlights[$trace['file']] =
                        highlight_string(str_replace('	', '  ', file_get_contents($trace['file'])), true);
                $highlights[$trace['file']] =
                        str_replace(array("\r\n", "\n", "\r"), array('', '', ''), $highlights[$trace['file']]);
                $highlights[$trace['file']] =
                        str_replace(array('<code><span style="color: #000000">', '</span></code>', '&nbsp;'),
                                array('', '', '&#160;'), $highlights[$trace['file']]);
                $highlights[$trace['file']] = explode('<br />', $highlights[$trace['file']]);
            }
            ?>
            <li id="frame<?php echo $i; ?>"<?php if ($i != 2): ?> class="hidecode"<?php endif; ?>>at <?php if ($i >
                        1
                ): ?>
                    <strong><?php if (isset($trace['class'])): ?><?php echo $trace['class'], htmlspecialchars($trace['type']); ?><?php endif; ?><?php echo $trace['function']; ?><?php if (isset($trace['args'])): ?>(<?php echo $this->buildParamList($trace['args']); ?>)<?php endif; ?></strong><?php else: ?>
                    <em>exception origin</em><?php endif; ?><br/>in <?php if (isset($trace['file'])): echo str_replace(
                        array(
                                '_' . APPLICATION_PATH,
                        ),
                        array(
                                '<abbr title="' . APPLICATION_PATH . '">core.app_dir</abbr>'
                        ),
                        '' . $trace['file']); ?>
                    <a href="#frame<?php echo $i; ?>" class="toggle" title="Toggle source code snippet"
                            onclick="this.parentNode.className = this.parentNode.className == 'hidecode' ? '' : 'hidecode'; return false;">line <?php echo $trace['line']; ?></a>
                    <ol start="<?php echo $start = $trace['line'] < 4 ? 1 : $trace['line'] - 3; ?>"
                    style="padding-left:<?php echo strlen($start + 6) * 0.6 + 2; ?>em"><?php
                    $lines = array_slice($highlights[$trace['file']], $start - 1, 7, true);
                    foreach ($lines as $key => &$line) {
                        if ($key + 1 == $trace['line']): ?>
                            <li class="highlight">
                                <div style="float:left; width:1em; height:1em; margin-left:-1.35em; background-color:#FFF;">
                                    <img src="public/default/images/error/exception.png" align="exception"/>
                                </div><?php else: ?><li><?php endif; ?><code><?php
                        if ($line == '') {
                            $line = '&#160;';
                        }
                        if (strpos($line, '</span>') === 0) {
                            $line = substr($line, 7);
                        }
                        if (strpos($line, '</span>') < strpos($line, '<span') || strpos($line, '<span') === false) {
                            for ($j = $key; $j >= 0; $j--) {
                                if (($pos = strrpos($highlights[$trace['file']][$j], '<span')) !== false &&
                                        strrpos($highlights[$trace['file']][$j], '</span>') < $pos
                                ) {
                                    $line = substr($highlights[$trace['file']][$j], $pos, 29) . $line;
                                    break;
                                }
                            }
                        }
                        if ((strrpos($line, '</span>') < strrpos($line, '<span') ||
                                        strpos($line, '</span>') === false) && strpos($line, '<span') !== false
                        ) {
                            $line .= '</span>';
                        }
                        // Whoever figures out what the point of this is gets a free Agavi t-shirt shipped right to his doorstep.
                        // It shall be left here, commented out, to serve as a reminder for any programmer to comment their code properly.
                        // http://trac.agavi.org/ticket/1009 is the associated ticket, patiently waiting for an explanation.
                        // if(strpos($line, ' ', 20) == 29) {
                        // 	$line = substr_replace($line, '&#160;', 29, 1);
                        // }
                        echo $line;
                        ?></code></li>
                    <?php } ?></ol><?php else: // no info about origin file ?><em>unknown</em><?php endif; ?></li>
        <?php endforeach; ?>
        </ol>
        <?php
        
        $out = ob_get_contents();
        ob_end_clean();
        
        return $out;
    }
    
    private function buildParamList($params)
    {
        $retval = array();
        foreach ($params as $key => $param) {
            if (is_string($key)) {
                $key = htmlspecialchars(var_export($key, true) . ' => ');
            } else {
                $key = '';
            }
            switch (gettype($param)) {
                case 'array':
                    $retval[] = $key . 'array(' . $this->buildParamList($param) . ')';
                    break;
                case 'object':
                    $retval[] = $key . '[object <em>' . get_class($param) . '</em>]';
                    break;
                case 'resource':
                    $retval[] = $key . '[resource <em>' . htmlspecialchars(get_resource_type($param)) . '</em>]';
                    break;
                case 'string':
                    $retval[] = $key .
                            htmlspecialchars(var_export(strlen($param) > 51 ? substr_replace($param, ' … ', 25, -25) :
                                    $param, true));
                    break;
                default:
                    $retval[] = $key . htmlspecialchars(var_export($param, true));
            }
        }

        return implode(', ', $retval);
    }
}        