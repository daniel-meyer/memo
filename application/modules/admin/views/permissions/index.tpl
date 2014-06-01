  <h2>Role ({$roles|@count})</h2>
  <p>Aby zmienić uprawinienia dla narzędzi, <a href="admin/tool-permissions">kliknij tutaj</a></p>
<div class="clearfix">&nbsp;</div>
  {*
  <p><a class="submit" href="{url a.action=edit}">Dodaj</a></p>
  *}  

	<tr>
		<td colspan="2">
		<table width="100%" cellspacing="2" cellpadding="2" border="0">
            {include file=sort.tpl}
			{foreach from=$roles item=role key=k}
			<tr>
				<td class="lp">{$role->getId()}</td>
				<td>{$role->getName()}&nbsp;</td>
				
                <td class="edit"><a class="submit" href="{url a.action=edit a.id=$role->getId()}">Uprawnienia</a>
				
			</tr>
            
 			{/foreach}

		</table>
		</td>
	</tr>


            


</table>

<div class="clearfix">&nbsp;</div>

    
<div class="grid_12">
    <a class="submit" href="{url a.module=admin name=null reset=true}">Powrót</a>
</div>

