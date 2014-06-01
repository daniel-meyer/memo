<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Filter
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: $
 */
/**
 * @see Zend_Filter_Interface
 */
require_once 'Zend/Filter/Interface.php';
/**
 * @category   Zend
 * @package    Zend_Filter
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Etd_Filter_Slug implements Zend_Filter_Interface
{

    /**
     * Defined by Zend_Filter_Interface
     *
     * Returns $value translitered to ASCII
     *
     * @param  string $value
     * @return string
     */
    public function filter ($value)
    {
        $return = '';
        setlocale(LC_CTYPE, 'pl_PL.utf8');
        $return = iconv("utf-8", "ASCII//TRANSLIT", $value);
        $return = strtolower(str_replace(' ', '-', $return));
        $return = preg_replace( '/[^a-z0-9\-]/', '', $return);
        $return = preg_replace( '/[\-]{2,}/', '-', $return);
        $return = trim($return, '-');
        
        return $return;
    }
}
