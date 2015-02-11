<?php
if(isset($_GET['cityoffset']))
{
	$cityoffset = $_GET['cityoffset'];
	
	?>
    <!DOCTYPE html>
    <head>
		<script type="text/javascript" src="js/excanvas.js"></script>
        <script type="text/javascript" src="js/coolclock.js"></script>
        <script type="text/javascript" src="js/moreskins.js"></script>
        <style type="text/css">
		body {margin:0; padding:0; overflow:hidden;}
		</style>
    </head>
    <body onLoad="CoolClock.findAndCreateClocks();">
        <canvas style="width:68px;height:68px;" class="CoolClock:jawhm:38::<?php echo $cityoffset;?>"></canvas>
    </body>
    </html>
<?php
}
?>
