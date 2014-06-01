(function($){
	
	$.fn.paginator = function(options) {
		var d = {
            page: 1,
            pages: 'tr',
		}; // default settings
		
		var s = $.extend({}, d, options); 
		return this.each(function(){
            
            var $t = $(this);
            var p = 'div';
            if($t.is("ul")){
                p = 'li';
            }else if($t.is("table")){
                p = 'tr';
            }

            var $pages = $(this).find(p);
            var $pager = $(this).next('.pager').get(0);
            
            var plugin = {
			    init: function(){
                    if($pager == null){
                        $pages.hide();
                        this.createPager();
                    }
                    this.go(s.page);
				},
                createPager: function(){
    				$pager = $('<ul />',{'class':'nolist pager'})
                    $pages.each(function(i){
                        var p = i+1;
                        var li = $('<li />')
                        var a = $('<a>',{
                            'href':'#'+p,
                            'text':p
                        }).appendTo(li);
                        
                        a.click(function(){
                            plugin.go(p);
                        });
                        
                        li.appendTo($pager);
                    });
                    
                    $t.after($pager);
  
    			}, 
                go: function(page){
                    if(parseInt($pager.find('a.active:first').html())==page){
                        return;
                    }
                    var p = page-1;
                    var i = 0;
                    $pages.fadeOut(100,
                     (function(){
                        ++i;
                        if(i==$pages.length){
                            $pages.hide();
                            var el = $pages.get(p);
                            $(el).fadeIn('slow');
                        } 
                    }));
                    
                    $pager.find('a').removeClass('active');
                    var el = $pager.find('a').get(p);
                    $(el).addClass('active');
                     
    			}
        	};
			plugin.init();
			
		});
	}
	
})(jQuery); 