
(function($){
	
	$.fn.gmaps = function(options) {
		var d = {
			show: 'fade',
            width: 225,
            height: 180
		}; // default settings
		
		var s = $.extend({}, d, options); 
        var included = false;
        
        
        
		return this.each(function(){
            
            var $t = $(this);
            
            var plugin = {
			    init: function(){
			        this.title = $t.find('.title:first').html();
                    this.text = $t.find('.text:first').html();
                    this.lat = parseFloat($t.find('.lat:first').html());
                    this.lng = parseFloat($t.find('.lng:first').html());
                    this.zoom = parseInt($t.find('.zoom:first').html());
                    this.draggable = $t.find('.draggable:first').html();
                    
                    plugin.createMap(this.lat, this.lng, this.zoom);
                    plugin.antiBug();
                    
                    var opcjeMarkera = {title: this.title, text: this.text};
                    
                    if(this.draggable){
                        opcjeMarkera.draggable = true;
                    }
                    
                    plugin.addMarker(this.lat, this.lng, opcjeMarkera);  
				},
        		createMap: function(lat, lng, zoom){  
                    var center_lat = lat, 
                        center_lng = lng;
                        
                    // tworzymy mapę satelitarną i centrujemy w okolicy Szczecina na poziomie zoom = 10
                    var wspolrzedne = new google.maps.LatLng(center_lat, center_lng);
                    var opcjeMapy = {
                        zoom: zoom,
                        center: wspolrzedne,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    this.mapa = new google.maps.Map($t.get(0), opcjeMapy);     

                },
                
                antiBug: function(){
                    google.maps.event.addListener(this.mapa, "idle", function(){
                    	google.maps.event.trigger(this.mapa, 'resize'); 
                    });	
                    
                    this.mapa.setZoom( this.mapa.getZoom() - 1);
                    this.mapa.setZoom( this.mapa.getZoom() + 1);  
                },
                
                addMarker: function(lat, lng, opcjeMarkera){
                    opcjeMarkera.position = new google.maps.LatLng(lat,lng);
                    opcjeMarkera.map = this.mapa;
                    
                    var marker = new google.maps.Marker(opcjeMarkera);
                    
                    if(opcjeMarkera.text){ 
                        var dymek = new google.maps.InfoWindow({
                            content: opcjeMarkera.text
                        });

                        google.maps.event.addListener(marker, "click", function(){
                            dymek.open(plugin.mapa, marker);
                        });
                        //google.maps.event.trigger(marker, 'click');
                    }
                    
                    if(opcjeMarkera.draggable){
                        google.maps.event.addListener(marker, "dragend", function(event) {
                          var point = marker.getPosition();
                          $('#lat').val( point.lat() );
                          $('#lng').val( point.lng() );
                        }); 
                        google.maps.event.addListener(this.mapa, "zoom_changed", function(){
                            $('#zoom').val( plugin.mapa.getZoom() );
                        });
                    }
   
                }
        	};
			plugin.init();
			
		});
	}
	
})(jQuery); 