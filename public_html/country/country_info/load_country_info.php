<?php
if(isset($_POST['isoCode']))
{
	require_once ('class-country.php');
	
	$country = new Country($_POST['isoCode']);
	
	$city1 = $country->weather($_POST['city1']);
	$map_width = $_POST['map_width'];
	?>
        <div class="country-preview">
            <p><?php echo $country->countryFlag(60) .'<span class="country-name">'.$country->countryName.'</span><br /><br />'; ?>
            <strong>首都 : </strong> <?php echo  $country->countryCapital; ?><br />
            <strong>人口 : </strong> <?php echo  $country->countryPopulation; ?><br/>
            <strong>エリア : </strong> <?php echo  $country->countryArea; ?><br/>
            <!--<strong>言語 : </strong> <?php echo  $country->countryLanguages; ?><br/>
            <strong>通貨 : </strong> <?php echo  $country->countryCurrencyName; ?><br/>-->
            <strong>為替レート : </strong><?php echo  $country->exchangeRate;?>
        </div>
        <div class="weather">
        	<div class="city1">
            	<span class="icon-weather"><?php echo $city1->icon; ?></span>
                <span class="weather-detail">
                	<strong><?php echo $city1->name; ?> <?php echo $city1->temperature->now; ?></strong><br />
					<small><?php echo $city1->date; ?><br /></small><?php echo $city1->description; ?></span>
                    
            <!--[if lte IE 8 ]>
                <div class="clock"><iframe src="/country/country_info/clock.php?&amp;cityoffset=<?php echo  urlencode($city1->offset); ?>" scrolling="no" frameborder="0"></iframe></div>
            <![endif]-->
            
        		<canvas id="<?php echo $country->countryIsoCode; ?>-city1-time" class="CoolClock:jawhm:38::<?php echo $city1->offset; ?> clock"></canvas>
            </div>
        </div>
        <div id="tools" class="country-preview">
            <p><strong>もっと見る : </strong><a id="visa-page-link" href="../visa/<?php echo $country->countryVisaPage(); ?>" title="ビザ情報">ビザ情報</a><a id="country-page-link" href="./<?php echo strtolower(preg_replace('/\s+/','',$country->countryName)); ?>" title="国情報">国情報</a></p>
        </div>

<?php
}
?>
