<h2>Użytkownicy ({$paginator->getPages()->totalItemCount})</h2>
<p>Zarządzaj kontami użytkowników</p>

  
<a class="btn btn-primary" href="{url a.action=add}">Dodaj</a>
<a class="btn" href="{$lang}/admin">Powrót</a>
<div>&nbsp;</div>

<table class="table table-striped">

	{include file=sort.tpl}{* wymaga zmiennej array $cols *}
    
    <tbody>
	{foreach from=$paginator item=item}
	<tr>
		<td class="lp">{$item->getId()}</td>
		<td>{$item->getEmail()}</td>
        <td>{$item->getFirstname()}</td>
		<td>{$item->getLastname()}</td>
		<td>{$item->getRegisterDate()->format('Y-m-d')}</td>
          {*
                <td>
                    {if $item->getRegisterStatus()}
                        <img alt="Konto zostało założone" title="Konto zostało założone" src="public/admin/images/status_online.png" />
                    {else}
                        <img alt="Oczekuje na akceptacje" title="Oczekuje na akceptacje" src="public/admin/images/status_offline.png" />
                    {/if}
                </td>
                *}
		<td class="edit">
            <a href="{url a.action='edit' a.id=$item->getId()}" class="btn btn-mini btn-primary">Edytuj</a>
			<a href="{url a.action='delete' a.id=$item->getId()}" onClick="return(window.confirm('Czy na pewno chcesz skasować daną pozycję?'));" class="btn btn-mini btn-danger">Usuń</a>
		</td>						
	</tr>
	{/foreach}
    </tbody>
</table>    


{include file=pager.tpl}{* wymaga zmiennej Zend_Paginator $paginator *}  
    

