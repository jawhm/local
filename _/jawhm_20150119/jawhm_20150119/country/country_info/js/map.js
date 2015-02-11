
	google.load("visualization", "1", {"packages": ["geochart"]});
    google.setOnLoadCallback(drawRegionsMap);

	function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ["Country", "", "isoCode", "weatherCity", "JPname"],
          ["Canada", 1, "CA", "toronto", "カナダ"],
          ["Denmark", 1, "DK", "copenhagen", "デンマーク"],
          ["Germany", 1, "DE", "berlin", "ドイツ"],
          ["United Kingdom", 1, "GB", "london", "イギリス"],
          ["Ireland", 1, "IE", "dublin", "アイルランド"],
          ["France", 1, "FR", "paris", "フランス"],
          ["Australia", 1, "AU", "sydney", "オーストラリア"],
          ["New Zealand", 1, "NZ", "auckland", "ニュージーランド"],
          ["South Korea", 1, "KR", "seoul", "韓国" ],
          ["Taiwan", 1, "TW", "taipei", "台湾"],
          ["Hong Kong", 1, "HK", "hongkong", "香港"]
        ]);

        var options = {
			region:"world",
			backgroundColor:"#EAF7FE",
			resolution:"continents",
			displayMode:"markers",
			datalessRegionColor: "#F9FFED",
			enableRegionInteractivity:true,
			legend:"none",
			sizeAxis:{minValue:0, maxSize:3},
			colorAxis: {colors: ["#FBD843", "#FBD843"]},
			tooltip:{trigger:"focus"}
		};

        var chart = new google.visualization.GeoChart(document.getElementById("chart"));
        
        var formatter = new google.visualization.PatternFormat("{4}");
        formatter.format( data, [0,1,2,3,4], 1 );
        var formatter = new google.visualization.PatternFormat("ワーキングホリデー協定国");
        formatter.format( data, [0,1,2], 0 );

		// defines the data for the chart values
        var view = new google.visualization.DataView(data);
        view.setColumns([0,1]);

        //play with cursors type by adding class
	    google.visualization.events.addListener(chart, 'ready', function () {
						
			if(options["resolution"]=="countries")
			{
				$('div#chart').addClass('country-view');
			}
			else
			{
				$('div#chart').removeClass('country-view');
			}
			
        });

		//click on a marker
        google.visualization.events.addListener(chart, "select", function(e) {
	        var selection = chart.getSelection();
	        if (selection.length == 1) {
	          var selectedRow = selection[0].row;
	          var selectedCountryCode = data.getValue(selectedRow, 2);
	          var selectedWeatherCity = data.getValue(selectedRow, 3);
	          
	          //make sure the detail are hidden
	          $(".pop").hide();

	          //loading icon (please wait)
		      $("#details").html("Loading...<img src=\""+location.protocol + "//" + location.host + "/seminar/bigLoader.gif\" /><br /><br />");

		      //load data
		      load_data_country(selectedCountryCode, selectedWeatherCity);
				
			  //show popup for details
	          $(".pop").slideFadeToggle();
	         
	          // Deselect the country - this is a workaround to make selection behave like click.
	          chart.setSelection();
	        }
	    });

	    //click on link in the page
	    $(".view").click(function(){
	    	//make sure the detail are hidden
	        $(".pop").hide();

	        var isoCode = $(this).attr("id");
 			//get data
	        var j=1
	        for(var i=0;i<(i+j);i++)
	        {
	        	var selection = data.getValue(i, 2);
	        	
	        	if( selection == isoCode)
	        	{
	        	  j=0;
	        	  var city = data.getValue(i, 3);
	        	}

	        }

	        //loading icon (please wait)
		      $("#details").html("Loading...<img src=\""+location.protocol + "//" + location.host + "/seminar/bigLoader.gif\" /><br /><br />");

		      //load data
		      load_data_country(isoCode, city);
				
			  //show popup for details
	          $(".pop").slideFadeToggle();
	    
	    });
		
		//zoom in action while clicking on continent
 		google.visualization.events.addListener(chart, "regionClick", function(eventData) {
	        
	        //only on continents view
	        if (options["resolution"] == "countries")
	        {
	        	return false;
	        }
	        else
	        {
		        //$("#zoomout").attr("title",options["region"]);

		        //use china zoom for Asia
			    if(eventData.region == "142")
			    {
			       	eventData.region = "CN";
			    }
			    //use aus/nz zoom for oceania
			    if(eventData.region == "009")
			    {
			       	eventData.region = "053";
			    }
			    //use North america zoom for americas
			    if(eventData.region == "019")
			    {
			       	eventData.region = "021";
			    }

			    if(eventData.region != "002")
			    {
		         	//alert(eventData.region);
		         	options["region"] = eventData.region;
		         	options["resolution"] = "countries";
		         	options["displayMode"] = "countries";
					options["tooltip"] = {trigger:"focus"};	         	

			 		chart.draw(view, options);
			 	}
			 }
		});
		
		//zoomout btn
		$("#zoomout").click(function(){ 
			options["region"] = "world";
			options["resolution"] = "continents";
			options["displayMode"] = "markers";
			chart.draw(view, options);
			return false;
		});
		//close btn
		$("#close").click(function(){ 
			$(".pop").slideFadeToggle();
			return false;
		});

		//function getting country data
		function load_data_country(isoCode,city1){	
				setTimeout($.ajax({
					type: "POST",
					url: location.protocol + "//" + location.host + "/country/country_info/load_country_info.php",
					data:  "isoCode="+isoCode+"&city1="+city1,
					cache:false,
					success: function(msg){
						//alert(msg);
						$("#details").html(msg);
						CoolClock.findAndCreateClocks();
					},
					error:function(){
						//alert("通信エラーが発生しました。");
					}
				}),1000);
		};

		//details displayed
		$.fn.slideFadeToggle = function(easing, callback) {
		    return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
		};
        
        chart.draw(view,options);
        $("#zoomout").show();
    }
