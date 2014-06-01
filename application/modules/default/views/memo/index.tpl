{literal}
<script type="text/javascript">
$(document).ready(function() {
    $('#memo-next').click(function(){
		var activeMemo = $('.memo-item.show');
		if (activeMemo.find('.answer.show').length) {
			//show next
			activeMemo.removeClass('show');
			activeMemo.next('.memo-item').addClass('show');
		} else {
			//show answer
			activeMemo.find('.answer').addClass('show');
		}
		return false;
	});
});
</script>
<style>
	.memos-items {padding: 15px 22px 12px;}
	.memo-item { display:none; }
	.memo-item.show { display:block; }
	.memo-item .question { font-weight: bold; }
	.memo-item .answer { display:none; padding-bottom: 15px }
	.memo-item .answer.show { display:block;}
</style>
{/literal}
<div class="memos-items">
	{foreach from=$memos item=item name=memos}
	<div class="memo-item {if $smarty.foreach.memos.first}show{/if}" id="memo-item-{$smarty.foreach.memos.iteration}">
		<p class="question">{$item->getQuestion()}</p>
		<hr />
		<p class="answer">{$item->getAnswer()}</p>
	</div>
	{/foreach}
	<button id="memo-next" class="btn btn-large">NEXT</button>
</div>