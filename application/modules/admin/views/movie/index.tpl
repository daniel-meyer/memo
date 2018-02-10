<h2>Słówka({$paginator->getPages()->totalItemCount})</h2>
<p>Zarządzaj listą filmów</p>

  
<a class="btn btn-primary" href="{url a.action=add}">Dodaj</a>

<a class="btn" href="{$lang}/admin">Powrót</a>
<div>&nbsp;</div>

<form class="well form-inline" method="get" action="">
    <label>Fraza</label>
    <input type="text" value="{$request->getParam('word')}" name="word">
    <button class="btn" type="submit">Szukaj</button>
</form>

<table class="table table-striped">

	{include file=sort.tpl}{* wymaga zmiennej array $cols *}
    
    <tbody>
	{foreach from=$paginator item=item}
	<tr>
		<td class="lp">{$item->getId()}</td>
		<td>{$item->getTitle()|textcut:255}</td>
        <td>{$item->getDate()}</td>


		<td class="edit">
            <a href="{url a.action='edit' a.id=$item->getId()}" class="btn btn-mini btn-primary">Edytuj</a>
			<a href="{url a.action='delete' a.id=$item->getId()}" onClick="return(window.confirm('Czy na pewno chcesz skasować daną pozycję?'));" class="btn btn-mini btn-danger">Usuń</a>
		</td>						
	</tr>
	{/foreach}
    </tbody>
</table>    


{include file=pager.tpl}{* wymaga zmiennej Zend_Paginator $paginator *}  
    

