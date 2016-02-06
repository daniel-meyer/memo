/**
 * Created by Daniel on 2014-06-14.
 */
var Memo = {};

Memo.importSrt = {
    form: null,
    radioBtns: '.btn-group button',
    knownBtn: '.btn-known',
    toLearnBtn: '.btn-to-learn',
    ignoredBtn: '.btn-ignored',
    inputStatus: 'input.status',
    inputAnswer: 'input.answer',
    inputQuestion: 'input.question',
    statusKnown: 1,
    statusToLearn: 2,
    statusIgnored: 0,

    init : function(form) {
        this.form = form;
        this.bindKnownBtn();
        this.bindToLearnBtn();
        this.bindIgnoredBtn();
    },
    bindKnownBtn: function() {
        var $this = this;
        this.form.find(this.knownBtn).click(function(){
            $this.setBtnAction(this, $this.statusKnown, false);
            return false;
        });
    },
    bindToLearnBtn: function() {
        var $this = this;
        this.form.find(this.toLearnBtn).click(function(){
            $this.setBtnAction(this, $this.statusToLearn, true);
            $this.getTranslation(this);
            return false;
        });
    },
    bindIgnoredBtn: function() {
        var $this = this;
        this.form.find(this.ignoredBtn).click(function(){
            $this.setBtnAction(this, $this.statusIgnored, false);
            return false;
        });
    },
    setBtnAction: function(btn, status, showAnswer) {
        var tr = $(btn).parents('tr');
        tr.find(this.radioBtns).removeClass('active');
        $(btn).addClass('active');
        tr.find(this.inputStatus).val(status);
        if (showAnswer) tr.find(this.inputAnswer).removeClass('hide');
        else tr.find(this.inputAnswer).addClass('hide');
    },
    getTranslation: function(btn) {
      var $this = this;
      var tr = $(btn).parents('tr');

      $.ajax({
          dataType: "json",
          url: 'http://mymemory.translated.net/api/get',
          data: {
              q: tr.find($this.inputQuestion).val(),
              langpair: 'en|pl'
          },
          success: function(data) {
            var text = [];
            $.each(data.matches, function(row) {
                text.push(row.translation);
            });
            tr.find($this.inputAnswer).tooltip({ placement: 'right', title: text.join(' | ') }).tooltip('show');
          }
        });
    }



};

$(function(){
    Memo.importSrt.init($('#memo-import-srt'));
})
