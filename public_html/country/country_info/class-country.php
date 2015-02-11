<?php

/**
 * Define MyClass
 */
class Country
{
	public $countryName;
	public $countryCapital;
	public $countryPopulation;
	public $countryArea;
	public $countryLanguages;
	public $countryCurrency;
	public $countryCurrencyName;
	public $exchangeRate;
	public $countryIsoCode;
		
	//legacy support for php4
	public function Country() {
			$this->__construct();
	}
	
	//set sCountryISOCode 2 Digit eg-> CA, AU, FR, DE
	public function __construct($countrycode){
		
		// Open CURL session:
		$data = curl_init("http://api.geonames.org/countryInfoJSON?country={$countrycode}&username=jawhm");
		curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
		
		// Get the rates data:
		$json_data = curl_exec($data);
		curl_close($data);
		
		// Decode JSON response:
		$country_info = json_decode($json_data);
		
		$this->countryName = $country_info->geonames[0]->countryName;
		$this->countryCapital = $country_info->geonames[0]->capital;
		$this->countryPopulation = $country_info->geonames[0]->population.'  M';
		$this->countryArea = $country_info->geonames[0]->areaInSqKm.' Km&sup2;';
		$this->countryCurrency = $country_info->geonames[0]->currencyCode;
		$this->countryLanguages = $this->languages($country_info->geonames[0]->languages);
		$this->countryIsoCode = $countrycode;
		
		$this->latest_currency_rate();
	}

	public function __destruct(){}

	//visa pages name
	public function countryVisaPage(){

		$pages = array( 'AU' => "v-aus.html",
						'NZ' => "v-nz.html",
						'CA' => "v-can.html",
						'KR' => "v-kor.html",
						'FR' => "v-fra.html",
						'DE' => "v-deu.html",
						'GB' => "v-uk.html",
						'IE' => "v-ire.html",
						'DK' => "v-dnk.html",
						'HK' => "v-hkg.html",
						'TW' => "v-ywn.html", );

		return $pages[$this->countryIsoCode];
	}
	//Get Flag
	public function countryFlag($width="") {
		//$flagURL = 'http://www.geonames.org/flags/x/'.strtolower($this->countryIsoCode).'.gif';

		//$flagURL = 'http://api.hostip.info/images/flags/'.strtolower($this->countryIsoCode).'.gif';
		
		$flagURL = 'http://www.pdfpad.com/flags/img/'.strtolower($this->countryIsoCode).'.png';
			
		// Open CURL session:
		// $flag = curl_init("http://www.oorsprong.org/websamples.countryinfo/CountryInfoService.wso/CountryFlag/JSON?sCountryISOCode={$this->countryIsoCode}");
		// curl_setopt($flag, CURLOPT_RETURNTRANSFER, 1);
		
		// // Get data:
		// $json_flag = curl_exec($flag);
		// curl_close($flag);
		
		// // Decode JSON response:
		// $flagURL = json_decode($json_flag);
		
		return "<img src=\"{$flagURL}\" width=\"{$width}\" title=\"flag{$this->countryIsoCode}\" />";
	}
	
	//Get languages Name
	private function languages($list) {
	
		require('iso_lang_code.php');

		$languages = explode(',', str_replace('-',',',$list)); //separated code such as en-CA and fr-CA into en,CA fr,CA

		$i=0;
		$spoken_language;
		$separation;
				
		foreach ($languages as $lang)
		{
			
			if(array_key_exists($lang, $ISO639_Char2Code))
			{
				//if not already found
				if(substr_count($spoken_language, $ISO639_Char2Code[$lang]) == 0)
				{
					if($i > 0) //insert comma from the second data we get
						$separation = ', ';
					
					$spoken_language .= $separation.$ISO639_Char2Code[$lang];
					$i++;
				}
			}
		}
		
		return $spoken_language;
	}
	
	//Get currency rates with JPY
	private function latest_currency_rate() {
	
		$currency_of_thecountry = $this->countryCurrency;

		//Get Currency Name
		//-------------------
		
		// Open CURL session:
		$currency_list = curl_init("http://openexchangerates.org/api/currencies.json");
		curl_setopt($currency_list, CURLOPT_RETURNTRANSFER, 1);
		
		// Get the name of the currency
		$json_currency = curl_exec($currency_list);
		curl_close($currency_list);
		
		// Decode JSON response:
		$currencyNames = json_decode($json_currency);
		
		$this->countryCurrencyName = $currencyNames->$currency_of_thecountry;

		
		//Get Currency Rate
		//----------------------
		$url_data = "http://www.google.com/ig/calculator?hl=en&q=1{$currency_of_thecountry}=?JPY";
		
		//set to right json format
		$array_from = array('lhs','rhs','error','icc');
		$array_to	= array('"lhs"','"rhs"','"error"','"icc"');
		$json_format_data = str_replace($array_from,$array_to,file_get_contents($url_data));

		$json_data = json_decode($json_format_data);
		
		$this->exchangeRate = preg_replace('/[^0-9.]/', '', $json_data->lhs).$currency_of_thecountry.' = '.preg_replace('/[^0-9.]/', '', $json_data->rhs).'JPY';
	}

	// Currency Chart
	/*option info => period : 1 Day = 1d, 5 Days = 5d, 3 Months = 3m, 6 Months = 6m, 1 Year = 1y, 2 Years = 2y, 5 Years = 5y, Maximum = my
					 type : Line = l, Bar = b, Candle = c
					 scale : Arithmetic = off, Logarithmic = on
					 size : Large = l, Medium = m, Small = s
					 average_indicator : MovingAverageInterval (m5, m10, m20, m50, m100, m200) you can replace the letter {m} by {e} for Exponential Moving Average Indicator. Separate your value by a comma.
					 					 e.g: $average_indicator='m50' / $average_indicator='m50, m200' / $average_indicator='m50, e200' etc.
	*/
	public function currency_chart($period='6m', $type='l', $scale='off', $size='s', $average_indicator=''){
		return "<img src=\"http://chart.finance.yahoo.com/z?s={$this->countryCurrency}JPY=x&amp;t={$period}&amp;q={$type}&amp;l={$scale}&amp;z={$size}&amp;p={$average_indicator}\" alt=\"\" title=\"Currency Chart\" />";
	}

	//get weather data from a city of the country we are displaying the information.
	public function weather($city, $stats=false){
		
		require('weather_lang_jp.php');
		
		// WEATHER FORECAST //
		$key='6ae8c9cc22982ef8cad939095a33c9c3';
				
		$url = "http://openweathermap.org/data/2.1/find/name?q={$city}&APPID={$key}";
		
		
		// Open CURL session:
		$weather_channel= curl_init($url);
		curl_setopt($weather_channel, CURLOPT_RETURNTRANSFER, 1);
		
		// Get the rates data:
		$json = curl_exec($weather_channel);
		curl_close($weather_channel);
		
		// Decode JSON response:
		$weather_forecast = json_decode($json);
			
		//echo '<pre>';print_r($weather_forecast);echo '</pre>';
		
		$i=0;
		
		while ($weather_forecast->list[$i]->sys->country != $this->countryIsoCode)
		{
			$i++;
		}
		
		//get on the offset time
		$urlXML = "http://www.earthtools.org/timezone/{$weather_forecast->list[$i]->coord->lat}/{$weather_forecast->list[$i]->coord->lon}";
		$timezone = simplexml_load_file($urlXML);
		//
		
		$treeH = '3h';
		
		//echo $timeOffset;
		
		//gather all detail
		$weather_detail = (object) array(
			'id' 			=> $weather_forecast->list[$i]->id,
			'coordinates'	=> (object) array(  'latitude' 	=> $weather_forecast->list[$i]->coord->lat,
												'longitude' => $weather_forecast->list[$i]->coord->lon),
			'name'		 	=> $weather_forecast->list[$i]->name,
			'temperature'	=> (object) array(  'now'	=> round($weather_forecast->list[$i]->main->temp - 273.15)  . '&deg;C',	//Temperature in Kelvin. Subtracted 273.15 from this figure to convert to Celsius.
												'max' 	=> round($weather_forecast->list[$i]->main->temp_max - 273.15) ,//Temperature in Kelvin. Subtracted 273.15 from this figure to convert to Celsius.
												'min' 	=> round($weather_forecast->list[$i]->main->temp_min - 273.15)),//Temperature in Kelvin. Subtracted 273.15 from this figure to convert to Celsius.
			'pressure'		=> $weather_forecast->list[$i]->main->pressure .' hPa',
			'humidity' 		=> $weather_forecast->list[$i]->main->humidity . '%',
			'unixtime'		=> $weather_forecast->list[$i]->dt,
			'date' 			=> substr($timezone->localtime,0,-3),
			'wind' 			=> (object) array(  'speed' => $weather_forecast->list[$i]->wind->speed .'m/s', //speed in mps (metres par second) info: 1 mps=2.2 mph(miles perhour) 1mph=1.6kmph(kilometres per hour)
												'degree'=> $weather_forecast->list[$i]->wind->deg .'&deg;'),
			'clouds' 		=> $weather_forecast->list[$i]->clouds->all . '%',
			'rain' 			=> $weather_forecast->list[$i]->rain->$treeH . 'mm',
			'snow' 			=> $weather_forecast->list[$i]->snow->$treeH . 'mm',
			'code' 			=> $weather_forecast->list[$i]->weather[0]->code,
			'forecast'		=> $weather_forecast->list[$i]->weather[0]->main,
			//'description'	=> $weather_forecast->list[$i]->weather[0]->description,
			'description'	=> $weather_description[$weather_forecast->list[$i]->weather[0]->id],
			'icon' 			=> "<a href=\"{$weather_forecast->list[$i]->url}\" title=\"{$weather_forecast->list[$i]->name}\"><img src=\"http://openweathermap.org/img/w/{$weather_forecast->list[$i]->weather[0]->icon}.png\" title=\"{$weather_forecast->list[$i]->weather->main}\" alt=\"{$weather_forecast->list[$i]->weather->main}\" /></a>",
			'offset' => $timezone->offset
		);
		
		if($stats)
			$weather_detail->population = $this->cityPopulation($weather_forecast->list[$i]->coord->lat, $weather_forecast->list[$i]->coord->lon, $weather_forecast->list[$i]->id);
		
		return $weather_detail;
	}
	
	public function cityPopulation($currentLatitude, $currentLongitude, $cityID) {
		//10001.965729km = 90 degrees    
		//1degree = 111.1329525444444 km
		//1km = 90/10001.965729 degrees = 0.0089982311916 degrees
		
		$km_for_1deg = 111.1329525444444;
		
		$RadiusInKm = 5; //in km
		
		$latitudeDelta = $RadiusInKm/$km_for_1deg;
		$longitudeDelta = $latitudeDelta * cos($latitudeDelta);
		
		//http://api.geonames.org/citiesJSON?north=44.1&south=-9.9&east=-22.4&west=55.2&lang=de&username=demo 
		//min max longitude latitude
		
		$north	= $currentLatitude - ($latitudeDelta); //$minLatitude
		$south	= $currentLatitude + ($latitudeDelta); //$maxLatitude 
		$west	= $currentLongitude - ($longitudeDelta);//$minLongitude
		$east	= $currentLongitude + ($longitudeDelta); //$maxLongitude
		
		// Open CURL session:
		$data = curl_init("http://api.geonames.org/citiesJSON?north={$north}&south={$south}&east={$east}&west={$west}&lang=ja&username=jawhm&style=full");
		curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
		
		// Get the rates data:
		$json_data = curl_exec($data);
		curl_close($data);
		
		// Decode JSON response:
		$city_info = json_decode($json_data);
		
		//get the right data
		$i=0;
		while ($city_info->geonames[$i]->geonameId != $cityID)
		{
			$i++;
		}

		
		$info = (object) array(
			'nameJP' 	=> $city_info->geonames[$i]->name,
			'number'	=> $city_info->geonames[$i]->population
			//'debug'		=> $city_info
			);

		return $info;
	}
	

	
	public function datasource() {
		
		echo '<div id="source-info">各データの提供元:<br />
		一般的な情報 : <a href="http://www.geonames.org/" title="GeoNames" target="_blank">GeoNames</a>, 天気予報 : <a href="http://openweathermap.org/" title="Open Weather Map" target="_blank">Open Weather Map</a>, 国通貨 : <a href="https://openexchangerates.org/" title="Open Exchange Rates" target="_blank">Open Exchange Rates</a>, 通貨レート : <a href="http://www.google.com" title="Google" target="_blank">Google</a>, 通貨図表 : <a href="http://finance.yahoo.com/" title="Yahoo Finance" target="_blank">Yahoo Finance</a> </div>';
		
	}



}
?>