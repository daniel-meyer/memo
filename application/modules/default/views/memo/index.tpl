{literal}
    <script type="text/javascript">
        $( document ).ready( function () {
            var answers = {};
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
                var $this = this;
                if (Object.keys(answers).length == 0) {
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
    <style>
        .memos-items {
            padding: 15px 22px 12px;
        }

        .memo-item {
            display: none;
        }

        .memo-item.show {
            display: block;
        }

        .memo-item .question {
            font-weight: bold;
        }

        .memo-item .answer {
            display: none;
            padding-bottom: 15px
        }

        .memo-item .answer.show {
            display: block;
        }
    </style>
{/literal}
<div class="memos-items">
    {foreach from=$memos item=item name=memos}
        <div class="memo-item {if $smarty.foreach.memos.first}show{/if}" id="memo-item-{$smarty.foreach.memos.iteration}" data-id="{$item->getId()}">
            <p class="question">{$item->getQuestion()}</p>
            <hr/>
            <div class="answer">
                <p>{$item->getAnswer()}</p>
                <button class="btn btn-large memo-answer memo-ok">OK</button>
                <button class="btn btn-large memo-answer memo-wrong">WRONG</button>
            </div>

        </div>
    {/foreach}
    <button id="memo-next" class="btn btn-large">NEXT</button>
    <button id="memo-save" class="btn btn-large hide" data-url="memo/save-stats">SAVE</button>
</div>