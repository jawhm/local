<?php
if(isset($_GET['isoCode']))
{
	
	$isoCode = ($_GET['isoCode'] == 'CA')? '021' : $_GET['isoCode'];
	$name = $_GET['name'];
	
    if(isset($_GET['map_width']) && !empty($_GET['map_width']))
        $map_width = $_GET['map_width'];
    else
        $map_width = 140; 
	
	?>
    <html>
    <head>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

	function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Popularity'],
          ['<?php echo  $name; ?>', 1]
        ]);

        var options = {
			region:'<?php echo  $isoCode; ?>',
			datalessRegionColor: '#FFFFFF',
			enableRegionInteractivity:false,
			legend:'none',
			colorAxis: {colors: ['#F2B50F']},
			width:<?php echo  $map_width; ?>
		};

        var chart = new google.visualization.GeoChart(document.getElementById('chart_<?php echo  $isoCode; ?>'));
        chart.draw(data, options);
    }

    </script>
    </head>
    <body>
        <div id="chart_<?php echo  $isoCode; ?>" style="float:right;"></div>
    </body>
    </html>
<?php
}
?>
