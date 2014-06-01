

<div id="file-browser"></div>
<div>&nbsp;</div>
<a href="{$lang}/admin" class="btn" >Powrót</a>

{literal}
<script>
  $().ready(function(){
    $('#file-browser').elfinder({
      url : 'public/scripts/elfinder/connectors/php/connector.php',
      lang : 'pl'
    });
  });
</script>
{/literal}