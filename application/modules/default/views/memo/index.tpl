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
<div class="memos-items">
    {foreach from=$memos item=item name=memos}
        <div class="memo-item {if $smarty.foreach.memos.first}show{/if}" id="memo-item-{$smarty.foreach.memos.iteration}" data-id="{$item->getId()}">

            <div class="progress">
                <div style="width: {$smarty.foreach.memos.iteration/$smarty.foreach.memos.total*100}%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success"><span class="sr-only">{$smarty.foreach.memos.iteration} from {$smarty.foreach.memos.total}</span></div>
            </div>
            <p class="question">{$item->getQuestion()}</p>
            <hr/>
            <div class="answer">
                <p>{$item->getAnswer()}</p>
                <button class="btn btn-lg btn-success memo-answer memo-ok">Pass</button>
                <button class="btn btn-lg btn-danger memo-answer memo-wrong">Fail</button>
            </div>

        </div>
    {/foreach}

    <div id="memo-alert" role="alert" class="alert alert-warning hide"><strong>Warning!</strong> There is no data to save</div>

    <button id="memo-next" class="btn btn-lg btn-primary">Show answer</button>

    <div id="memo-save" class="hide">
        <div role="alert" class="alert alert-info"><strong>Lesson completed!</strong> Please click save button to store lesson results.</div>
        <button class="btn btn-lg btn-primary" data-url="memo/save-stats">Save</button>
    </div>

    <div id="memo-next-lesson" class="hide">
        <div class="alert alert-success" role="alert"><strong>Saved!</strong> You successfully end this lesson.</div>
        <a href="{url}" class="btn btn-lg btn-primary">Next Lesson</a>
    </div>
</div>