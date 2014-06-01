<?
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.translate.php
 * Type:     block
 * Name:     translate
 * Purpose:  wrapper to PHP function translatetext()
 * -------------------------------------------------------------
 */
function smarty_block_transtext($params, $content, &$smarty) {
  if ($content != '') {
    echo transtext($content, $params['context'], $params['param1'], $params['param2'], $params['param3']);
  }
}
?>
