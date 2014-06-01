<?php
/**
 * Google Analytics Javascript View Helper
 *
 * @copyright Copyright (c) 2008-2009 Pro Soft Resources USA Inc. (http://www.prosoftpeople.com)
 * @author    Rolando Espinoza La fuente (darkrho@gmail.com)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   $Id$
 */ 

class Etd_View_Helper_GoogleAnalytics extends Zend_View_Helper_Abstract
{
    /**
     * @var string Google Analytics Javascript
     */
    protected $_script = null;

    /**
     * @var string Google Analytics Code
     */
    protected $_gaCode = null;

    /**
     * Constructor: 
     *  - checks GA code is set in config registry
     *  - setup GA javascript
     * 
     */
    public function __construct()
    {
        if (Zend_Registry::isRegistered('settings')) {
            $config = Zend_Registry::get('settings');
            if (!empty($config->googleAnalyticsKey)) {
                $this->_gaCode = $config->googleAnalyticsKey;
            }
        }

        $this->_script = <<< END
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker(":code");
pageTracker._trackPageview();
} catch(err) {}
</script>
END;

    }

    /**
     * Returns javascript GA script if GA code is set
     * 
     * @return string
     */
    public function googleAnalytics()
    {
        if (null != $this->_gaCode) {
            return str_replace(':code', $this->_gaCode, $this->_script);
        } else {
            return '';
        }
    }
}