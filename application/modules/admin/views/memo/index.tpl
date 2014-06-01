<h2>Słówka({$paginator->getPages()->totalItemCount})</h2>
<p>Zarządzaj listą słówek</p>

  
<a class="btn btn-primary" href="{url a.action=add}">Dodaj</a>
<a class="btn btn-success" href="{url a.action=import}">Import</a>
<a class="btn btn-success" href="{url a.action='import-srt'}">Import srt</a>
<a class="btn btn-info" href="{url a.action='export-to-supermemo'}">Export to Supermemo</a>
<a class="btn btn-info" href="{url a.action='export-questions'}">Export questions</a>
<a class="btn" href="{$lang}/admin">Powrót</a>
<div>&nbsp;</div>


<table class="table table-striped">

	{include file=sort.tpl}{* wymaga zmiennej array $cols *}
    
    <tbody>
	{foreach from=$paginator item=item}
	<tr>
		<td class="lp">{$item->getId()}</td>
		<td>{$item->getQuestion()|textcut:255}</td>
        <td>{$item->getAnswer()|textcut:255}</td>
		

        {*}<td>{$item->getPublishDate()|format:'Y-m-d'}</td>
        {*}

		<td class="center">
            {if $item->getActive()==2}
                <i class="admin-sprite" style="background-position: {if $item->getActive()}-100px{else}0{/if} -120px;" title="Wyeksportowane do supermemo" class="tip"></i>
            {else}
                <a href="{url a.action='ajax-active' a.id=$item->getId() a.status=$item->getActive()}" title="Status" class="tip ajaxStatus" >
                    <i class="admin-sprite" style="background-position: {if $item->getActive()}-20px{else}0{/if} -120px;"></i>
                </a>
            {/if}    
        </td>

		<td class="edit">
            <a href="{url a.action='edit' a.id=$item->getId()}" class="btn btn-mini btn-primary">Edytuj</a>
			<a href="{url a.action='delete' a.id=$item->getId()}" onClick="return(window.confirm('Czy na pewno chcesz skasować daną pozycję?'));" class="btn btn-mini btn-danger">Usuń</a>
		</td>						
	</tr>
	{/foreach}
    </tbody>
</table>    


{include file=pager.tpl}{* wymaga zmiennej Zend_Paginator $paginator *}  
    

