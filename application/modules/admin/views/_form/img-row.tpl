<div id="img_{$name}" {if !$value}style="display:none"{/if}>
    <img src="{$value}" alt="foto" class="block" />
     <label class="checkbox" ><input id="del_{$name}" type="checkbox" value="" />usuń plik</label>
</div>

<input type="text" id="{$name}" value="{$value}" name="{$name}" /> 
<input type="button" name="button_{$name}" value="Wybierz plik" class="btn upload elfinder" />
