<span id="img_{$name}" {if !$value}style="display:none"{/if}>
    <span id="place_{$name}" ></span>
    <input id="del_{$name}" type="checkbox" class="checkbox" value="" />
    <label for="del_{$name}">usuń plik</label>
    <input name="{$name}_duration" id="{$name}_duration" value="{$duration}" type="hidden" />
    <br />
</span>

<input type="text" id="{$name}" value="{$value}" class="text short" name="{$name}" /> 
<input type="button" name="button_{$name}" value="Wybierz plik" class="submit upload ckfinderMovie" />
{if $value}
{literal}
<script type='text/javascript'>
  jwplayer('place_{/literal}{$name}{literal}').setup({
    'flashplayer': 'public/scripts/jwplayer/player-licensed.swf',
    'file': '{/literal}{$value}{literal}',
    'controlbar': 'bottom',
    'width': '470',
    'height': '320'
  });
</script>
{/literal}
{/if}