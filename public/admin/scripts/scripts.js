var baseHref = null;
function baseUrl(uri){
    if(null == baseHref){
        var thebase = document.getElementsByTagName("base"); 
        baseHref = thebase[0].href;
    }
    
    return baseHref+uri;
}

$(document).ready(function() {
    
	var mceConfig = {
		// Location of TinyMCE script
		script_url : 'public/scripts/tinymce/jscripts/tiny_mce/tiny_mce.js',
        language: 'pl',
        theme : "advanced",
        skin : "default",
        entity_encoding : "raw",
		// General options
        content_css : "public/scripts/tinymce/style.css",
		relative_urls : false,

		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
        file_browser_callback : function(field_name, url, type, win) {
              tinyMCE.activeEditor.windowManager.open({
                file: baseUrl('public/scripts/tinymce/tinymce_backend.html'),
                title: 'elFinder',
                width: 900,  
                height: 450,
                resizable: 'yes',
                inline: 'yes',    // This parameter only has an effect if you use the inlinepopups plugin!
                popup_css: false, // Disable TinyMCE's default popup CSS
                close_previous: 'no'
              }, {
                window: win,
                input: field_name
              });
              return false;
        }
	};
    
    $('textarea.fck').tinymce(mceConfig);
    
    mceConfigSimple = jQuery.extend({}, mceConfig);
    //mceConfigSimple.theme = 'simple';
    mceConfigSimple.theme_advanced_buttons1 = "bold,italic,underline,strikethrough,|,undo, redo,|,cleanup,code,|,bullist,numlist";
    mceConfigSimple.theme_advanced_buttons2 = "";
    mceConfigSimple.theme_advanced_buttons3 = "";
    mceConfigSimple.theme_advanced_buttons4 = "";
    
    $('textarea.fckSimple').tinymce(mceConfigSimple);






    //Tabs...
	$(".tab_content").hide(); //Hide all content
	
    
    if(window.location.hash){
        var activeTab = window.location.hash;
        $('ul.tabs a[href="'+activeTab+'"]').parent('li').addClass("active").show(); //Activate first tab
        $(activeTab).show();
    }

    if($("ul.tabs li.active").length == 0){
        $("ul.tabs li:first").addClass("active").show(); //Activate first tab
	    $(".tab_content:first").show(); //Show first tab content
    }
    
	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});


	//Accordion
	$('.acc_container').hide(); //Hide/close all containers
	$('.acc_trigger:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container
	
	//On Click
	$('.acc_trigger').click(function(){
		if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
			$('.acc_trigger').removeClass('active').next().slideUp(); //Remove all "active" state and slide up the immediate next container
			$(this).toggleClass('active').next().slideDown(); //Add "active" state to clicked trigger and slide down the immediate next container
		}
		return false; //Prevent the browser jump to the link anchor
	});


	//$("tr:even").addClass("even");

	// Closing Divs - used on Notification Boxes
	$(".canhide").click(function() {
		
		$(this).fadeOut(700);
	});
	
	$("#icondock li a").tooltip ({ placement: 'bottom' });
	
    $(".tip, .help").tooltip ();

    
	
	
	// Check all the checkboxes when the head one is selected:
	$('.checkall').click(
		function(){
			$(this).parent().parent().parent().parent().find("input[type='checkbox']").attr('checked', $(this).is(':checked'));   
		}
	);
    
    //init sub menu
    initSubMenu();
    // Closing jQuery
    

    // zastąp textarea na FCK editor
    //initFCK();
    
    // zdarzenie dla przycisku, ładujace zawartość do elementu oznaczonego w rel
    $('a.ajaxTrigger').click(function(){
        $($(this).attr('rel')).load($(this).attr('href'));
        return false;
    });
    
    // zdarzenie dla przycisku publikuj itp
    $('a.ajaxStatus').click(function(){
        var href=$(this).attr('href');
        $(this).load(href, function() {
            var new_status = (href.substr(href.length-1)=='1') ? '0' : '1';
            $(this).attr('href', href.substr(0, href.length-1)+new_status);
        });
        return false;
    });
    
    // ELFINDER
    $('input.elfinder').elFinderRow();
    
    $('input.elfinderMovie').elFinderMovieRow();
    
    $("#sortable li.new").hide().delay(500).show(200);
    
    
    //Datepicker
    initDatepicker();

});


/* Polish initialisation for the jQuery UI date picker plugin. */
/* Written by Jacek Wysocki (jacek.wysocki@gmail.com). */
jQuery(function($){
        $.datepicker.regional['pl'] = {
                closeText: 'Zamknij',
                prevText: '&#x3c;Poprzedni',
                nextText: 'Następny&#x3e;',
                currentText: 'Dziś',
                monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
                monthNamesShort: ['Sty','Lut','Mar','Kwi','Maj','Cze','Lip','Sie','Wrz','Paź','Lis','Gru'],
                dayNames: ['Niedziela','Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota'],
                dayNamesShort: ['Nd','Pn','Wt','Śr','Czw','Pt','So'],
                dayNamesMin: ['Nd','Pn','Wt','Śr','Cz','Pt','So'],
                weekHeader: 'Tydz',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pl']);
});

function addDatepicker(el){
    var $t = $( el );
    var options = $t.data();
    
    if(options.minDate && options.maxDate){
        var minY = options.minDate.substr(0, 4);
        var maxY = options.maxDate.substr(0, 4);
        options.yearRange = minY + ' ' + maxY;
    }

    $t.datepicker(options);
        
    $t.parent().find('.icon-calendar').parent().click(function(){
        
        var visible = $('#ui-datepicker-div').is(':visible');
        
        $t.datepicker( visible ? 'hide' : 'show' );
        return false;
    });
}
function addDatepickerRange(el){
    var $t = $( el );
    var options = $t.data();
    
    if(options.minDate && options.maxDate){
        var minY = options.minDate.substr(0, 4);
        var maxY = options.maxDate.substr(0, 4);
        options.yearRange = minY + ' ' + maxY;
    }
    
    options.onSelect = function( selectedDate ) {
		var option = el.id == "from" ? "minDate" : "maxDate",
			instance = $( el ).data( "datepicker" ),
			date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
				selectedDate, instance.settings );
		$( ".datepicker-range" ).not( el ).datepicker( "option", option, date );
	};

    $t.datepicker(options);
        
    $t.parent().find('.icon-calendar').parent().click(function(){
        
        var visible = $('#ui-datepicker-div').is(':visible');
        
        $t.datepicker( visible ? 'hide' : 'show' );
        return false;
    });
}
function initDatepicker(){
    $.datepicker.setDefaults( $.datepicker.regional[ "pl" ] );
    $.datepicker.setDefaults({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
		changeYear: true
    });
    
    $( ".datepicker" ).each(function(){
       addDatepicker(this);
       
    });  
    
      
    $( ".datepicker-range" ).each(function(){
       addDatepickerRange(this);
       
    });
    
    
}

(function($){
	$.fn.elFinderMovieRow = function(options) {
		var d = {
		}; // default settings
		
		var s = $.extend({}, d, options); 
		return this.each(function(){
            
            var field = $(this).attr('name').replace('button_', '');
            $(this).click(function(){
                var finder = new CKFinder();
                finder.basePath = s.basePath;
                finder.selectActionFunction = function(fileUrl) {
                    $('#'+field).val(fileUrl);
                    $('#'+'img_'+field).fadeOut('slow', function(){
                        var jwp = jwplayer('place_'+field).setup({
                            'flashplayer': 'public/scripts/jwplayer/player-licensed.swf',
                            'file': fileUrl,
                            'controlbar': 'bottom',
                            'width': '470',
                            'height': '320',
                            'events': {
                                onMeta: function() {
                                    $('#'+field+'_duration').val(secToTime(jwp.getDuration())); 
                                }
                            }
                          });
                         jwp.play().pause();
                        $('#'+'img_'+field).fadeIn('slow');
                    });  
                }
                finder.popup();
             return false;
            });
        
            $('#'+'del_'+field).change(function(){
                if(confirm("Czy na pewno chcesz usunąć plik?")){
                    $('#'+field).val('');
                    $('#'+'img_'+field).fadeOut('slow');
                }
                $(this).attr('checked', false);
                return false;
            });
            
			
		});
	}
	
})(jQuery); 

function secToTime(sec){ 
    var d = new Date(sec*1000);
    var h = d.getHours()-1; 
    if(h){
        return h+':'+padZero(d.getMinutes(),2)+':'+padZero(d.getSeconds(),0); 
    }else{
        return d.getMinutes()+':'+padZero(d.getSeconds(),0);
    }
}
function padZero(number, length) {
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }
    return str;
}
(function($){
	$.fn.elFinderRow = function(options) {
		var d = {
		}; // default settings
		
		var s = $.extend({}, d, options); 
		return this.each(function(){

            var field = $(this).attr('name').replace('button_', '');
            $(this).click(function(){
                $('<div id="myelfinder" />').elfinder({
                        url : 'public/scripts/elfinder/connectors/php/connector.php',
                        lang : 'pl',
                        closeOnEditorCallback : true,
                        editorCallback : function(fileUrl) {
                              // pass selected file path to TinyMCE
                              $('#'+field).val(fileUrl);
                              $('#'+'img_'+field).fadeOut('slow', function(){
                                $('#'+'img_'+field+' img').attr('src', fileUrl);
                                $('#'+'img_'+field).fadeIn('slow');
                              }); 
                        },
                        dialog : {
                            title : 'Repozytorium plików',
                            height : 500,
                            width : 900,
                            zIndex: 100
                        }
                    });
                
             return false;
            });
        
            $('#'+'del_'+field).change(function(){
                if(confirm("Czy na pewno chcesz usunąć plik?")){
                    $('#'+field).val('');
                    $('#'+'img_'+field).fadeOut('slow');
                }
                $(this).attr('checked', false);
                return false;
            });
			
		});
	}
	
})(jQuery);







/**
 * function initSubMenu()
 **/
 function initSubMenu(){
     return;
     
     var menu_active_id =  parseInt($("#navigation ul li a.active").attr('id').replace('menu_id', ''));

	 $("#navigation ul li a").click(function () {
        
        var menu_id = parseInt($(this).attr('id').replace('menu_id', ''));
        
        showMenuById(menu_id);
     });
     /*
     $('#main_content_wrap').mouseover(function () {
       showMenuById(menu_active_id);
     }); */
     
     var showMenuById = function (id) {
         
        //ukryj wszystkie podmenu
        $('#navigation ul li a').removeClass('active');
            
        //aktywuj menu
        $('#menu_id'+id).addClass('active');
            
        //ukryj wszystkie podmenu
        $('#subnav ul').addClass('hidden');
        
        
        //pokaz aktywne podmenu
        $('#sub_menu_id'+id).removeClass('hidden');
        
     };   
      
 }
 