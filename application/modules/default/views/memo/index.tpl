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
                    $( '#memo-save' ).removeClass('hide');
                }

                return false;
            } );

            $( '#memo-save' ).click( function () {
                var $this = $(this);
                if ($.isEmptyObject(answers)) {
                    $('#memo-alert').removeClass('hide');
                } else {
                    $.post($(this ).data('url'), {answers: answers}, function() {
                        $('#memo-alert').addClass('hide');
                        $('#memo-next-lesson').removeClass('hide');
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

            <div class="progress">
                <div style="width: {$smarty.foreach.memos.iteration/$smarty.foreach.memos.total*100}%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"><span class="sr-only">{$smarty.foreach.memos.iteration} / {$smarty.foreach.memos.total}</span></div>
            </div>
            <p class="question">{$item->getQuestion()}</p>
            <hr/>
            <div class="answer">
                <p>{$item->getAnswer()}</p>
                <button class="btn btn-lg btn-success memo-answer memo-ok">OK</button>
                <button class="btn btn-lg btn-danger memo-answer memo-wrong">WRONG</button>
            </div>

        </div>
    {/foreach}
    <button id="memo-next" class="btn btn-lg btn-primary">NEXT</button>
    <button id="memo-save" class="btn btn-lg btn-primary hide" data-url="memo/save-stats">SAVE</button>

    <div id="memo-alert" role="alert" class="alert alert-warning"><strong>Warning!</strong> There is no data to save</div>

    <div id="memo-next-lesson" class="hide">
        <div class="alert alert-success" role="alert"><strong>Saved!</strong> You successfully end this lesson.</div>
        <a href="{url}" class="btn btn-lg btn-primary">NEXT LESSON</a>
    </div>
</div>