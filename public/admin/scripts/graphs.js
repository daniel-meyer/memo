$(document).ready(function() {
    
    if(!$("#placeholder") || !$("#placeholder").text()){
        return;
    }
    
    var d 	= [[1257138000000, 123], 
    [1257310800000, 344], [1257656400000, 355], [1257814800000, 357], [1257872400000, 433], [1257955200000, 522], [1258041600000, 433], [1258214400000, 533], [1258395120000, 644], [1258567920000, 767], [1258791120000, 986], [1259050320000, 677], [1259280720000, 866], [1259367120000, 900], [1259680320000, 766], [1259939520000, 766], [1260025920000, 788], [1260371520000, 988], [1260457920000, 890], [1260544320000, 800], [1260818700000, 850], [1260905100000, 900], [1260991500000, 1155], [1261077660000, 1255], [1261250460000, 1433], [1261336860000, 1675]];
    //alert(d);
    //alert($("#placeholder").html());
    var d = jQuery.parseJSON($("#placeholder").html());
    $("#placeholder").text('');
    $("#placeholder").css('display', 'block');

    var max = 0;
    for (var i = 0; i < d.length; ++i){
      d[i][0] = d[i][0] * 1000 + 60 * 60 * 1000;  
      if(max < parseInt(d[i][1]))max = parseInt(d[i][1]);
    }

    max = max + Math.floor(max/5);
    

    
    
    // helper for returning the weekends in a period
    function weekendAreas(axes) {
        var markings = [];
        var d = new Date(axes.xaxis.min);
        // go to the first Saturday
        d.setUTCDate(d.getUTCDate() - ((d.getUTCDay() + 1) % 7))
        d.setUTCSeconds(0);
        d.setUTCMinutes(0);
        d.setUTCHours(0);
        var i = d.getTime();
        do {
            // when we don't set yaxis the rectangle automatically
            // extends to infinity upwards and downwards
            markings.push({ xaxis: { from: i, to: i + 2 * 24 * 60 * 60 * 1000 } });
            i += 7 * 24 * 60 * 60 * 1000;
        } while (i < axes.xaxis.max);

        return markings;
    }
	
    // OPTIONS FOR THE FLOT
    var options = {
        xaxis: { mode: "time" },
		selection: { mode: "xy" },
		lines: { show: true, fill: 0.5 },
		points: { show: true },
		yaxis: { min: 0, max: max },
        grid: { hoverable: true, clickable: true, labelMargin: 10, borderWidth: 1, borderColor: "#ccc" },
		
		// BLUE (DEFAULT):#00769D; GREEN: #729f32 ;RED: #a11e06; ORANGE: #D07200; BLACK: #D07200
		colors: ["##1B1B1B"], 
		shadowSize: 2
    };
	
	// SET TOOLTIP DEFAULTS.
  	function showTooltip(x, y, contents) {
        $('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            left: x + -35,
			top: y - 45,
			padding: '4px',
			color: '#000',
			
			// BLUE (DEFAULT):#00769D; GREEN: #729f32 ;RED: #a11e06; ORANGE: #D07200; BLACK: #D07200
            border: '1px solid ##1B1B1B', 
			
			// BLUE (DEFAULT):#00769D; GREEN: #729f32 ;RED: #a11e06; ORANGE: #D07200; BLACK: #D07200
            'background-color': '##1B1B1B', 
			
            opacity: 0.90
        }).appendTo("body").fadeIn(200);
    }
	
    var plot = $.plot($("#placeholder"), [d], options);
    var previousPoint = null;
    $("#placeholder").bind("plothover", function (event, pos, item) {
        $("#x").text(pos.x.toFixed(2));
        $("#y").text(pos.y.toFixed(2));
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    // CALL TOOLTIPS
                    $("#tooltip").remove();
                    var x = item.datapoint[0],
                        y = item.datapoint[1];
                    
                    showTooltip(item.pageX, item.pageY,
                               y + " Odwiedzin(y)");
                }
            }
			
            else {
                $("#tooltip").remove();
                previousPoint = null;            
            }
    });
});