{literal}
    <script type="text/javascript">
        var answers = {};
        $( document ).ready( function () {
            $( '#memo-next' ).click( function () {
                $( '.memo-item.show .answer' ).addClass( 'show' );
                $( this ).hide();
                return false;
            } );
            $( '.memo-answer' ).click( function () {
                var activeMemo = $( '.memo-item.show' );
                answers[activeMemo.data('id')] = $( this ).is('.memo-ok') ? 1 : 0;

                //show next
                activeMemo.removeClass( 'show' );
                var next = activeMemo.next( '.memo-item' );
                if ( next.length ) {
                    next.addClass( 'show' );
                    $( '#memo-next' ).show();
                } else {
                    $( '#memo-save' ).show();
                }

                return false;
            } );

            $( '#memo-save' ).click( function () {
                var $this = $(this);
                if ($.isEmpty(answers)) {
                    alert('There is no data to save');
                } else {
                    $.post($(this ).data('url'), {answers: answers}, function() {
                        alert('Saved!') ;
                        $this.hide();
                    });
                }
                return false;
            } );

        } );
    </script>
{/literal}
<div class="memos-items jumbotron">
    {foreach from=$memos item=item name=memos}
        <div class="memo-item {if $smarty.foreach.memos.first}show{/if}" id="memo-item-{$smarty.foreach.memos.iteration}" data-id="{$item->getId()}">
            <p class="question">{$item->getQuestion()}</p>
            <hr/>
            <div class="answer">
                <p>{$item->getAnswer()}</p>
                <button class="btn btn-lg btn-success memo-answer memo-ok">OK</button>
                <button class="btn btn-lg btn-danger memo-answer memo-wrong">WRONG</button>
            </div>

        </div>
    {/foreach}
    <button id="memo-next" class="btn btn-lg">NEXT</button>
    <button id="memo-save" class="btn btn-lg hide" data-url="memo/save-stats">SAVE</button>
</div>