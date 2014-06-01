
$(function() {
	//some elements..      
    
    var $tb_toolbox     = $('#tb_toolbox'),
        $tb_files       = $('#tb_files'),
		$tb_imageHolder = $('#tb_imageHolder'),
		$tb_toggle      = $('#tb_toggle'),
        $tb_close       = $('#tb_close'),
        $tb_rulerX      = $('#tb_rulerX'),
        $tb_rulerY      = $('#tb_rulerY'),
        $tb_hide        = $('#tb_hide'),
		$tb_opacity     = $('#tb_opacity');

    $tb_imageHolder.draggable();
    $tb_rulerX.draggable();
    $tb_rulerY.draggable();
    
    var plugin = {
		init: function(){
			plugin.move('down', { top: '+='+1+'px' }, 40);
			plugin.move('up', { top: '-='+1+'px' }, 38);
			plugin.move('next', { left: '+='+1+'px' }, 39);
			plugin.move('prev', { left: '-='+1+'px' }, 37);
		},
		move: function(element, object, key){
			var type = $.browser.mozilla ? 'keypress' : 'keydown';
			$(document).bind(type, function(e) {
                var code = e.keyCode ? e.keyCode : e.which; //alert(code);
        		if(code == key && $tb_imageHolder.is(':visible')) { 
        			$tb_imageHolder.css(object);
                    $.cookie('tb_toolbox_top', $tb_imageHolder.css('top'));
                    $.cookie('tb_toolbox_left', $tb_imageHolder.css('left'));
                    return false;
        		}	
        	});	
		}
	};
    
    plugin.init();
    
    
    $tb_imageHolder.attr('src', $tb_files.val());
    $tb_imageHolder.css('opacity',$tb_opacity.val());
    
    if($.cookie('tb_toolbox_top')){
        $tb_imageHolder.css('top', $.cookie('tb_toolbox_top'));
        $tb_imageHolder.css('left', $.cookie('tb_toolbox_left'));
    }
    
    $tb_files.change(function(e){
        $tb_imageHolder.attr('src', $(this).val());
        $tb_imageHolder.css('top', 0);
        $tb_imageHolder.css('left', 0);
    });
    
    $tb_opacity.change(function(e){
        $tb_imageHolder.css('opacity',$(this).val());
    });

	$tb_toggle.click(function(e){
        $tb_imageHolder.toggle();
        return;
    });
    
    $tb_hide.click(function(e){
        $tb_toolbox.remove();
        return;
    });
    
	$tb_close.click(function(e){
        $tb_toolbox.remove();
        $tb_imageHolder.remove();
        $tb_rulerX.remove();
        $tb_rulerY.remove();
        return;
    });
    
});