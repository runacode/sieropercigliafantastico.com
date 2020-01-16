<?php

KformConfig::setConfig(array(
    "isWordpress" => false,
    "apiLoginId" => "os_api",
    "apiPassword" => 'p@$$w0rd123123',
"authString"=>"c2f9d089f0e7ea7dde2402ffb3efebe2",
	"autoUpdate_allowedIps"=>array("80.248.30.132"),
	"campaignId"=>15,
	"resourceDir"=>"resources/"));




/* 
!---------------------------------IMPORTANT-----------------------------------!

Documentation:
	
	-Full documentation on landing pages can be found at 

Auto-Update Feature:

	-The auto-update feature will automatically update settings on your landing page
	when you make changes to your campaign within the konnektive CRM. Use this feature
	to keep your landing page up-to-date concerning new coupons / shipping options
	and product changes.

	-To use the campaign auto-update feature, the apache or ngix user 
	(depending on your httpd software) must have write access to this file
	
	-If you are not using the auto-update feature, you will need to manually 
	replace this file after making changes to the campaign	
	
!---------------------------------IMPORTANT-----------------------------------!
*/

class KFormConfig
{
	
	public $isWordpress = false;
	public $apiLoginId = '';
	public $apiPassword = '';
	public $resourceDir;
	public $baseDir;
	
	
	public $mobileRedirectUrl;
	public $desktopRedirectUrl;
	
	
	public $continents;
	public $countries;
	public $coupons;
	public $currencySymbol;
	public $insureShipPrice;
	public $landerType;
	public $offers;
	public $upsells;
	public $products;
	public $shipProfiles;
	public $states;
	public $taxes;
	public $termsOfService;
	public $webPages;
	
	static $instance = NULL;
	static $options;
	static $campaignData;
	// class constructor to set the variable values	
	
	static function setConfig($options)
	{
		self::$options = $options;	
	}
	
	public function __construct()
	{
		if(!empty(self::$instance))
			throw new Exception("cannot recreated KFormConfig");
		
		foreach((array) self::$options as $k=>$v)
			$this->$k = $v;
			
		if($this->isWordpress)
		{
			$options = get_option('konnek_options');
			foreach((array)$options as $k=>$v)
				$this->$k = $v;
		
			$data = json_decode(get_option('konnek_campaign_data'));
			foreach($data as $k=>$v)
				$this->$k = $v;
		}
		elseif(!empty(self::$campaignData))
		{
			if(json_decode(self::$campaignData) === NULL)
			{
				echo 'JSON in config.php is broken!';
				die;
			}
			else
				$data = (array)json_decode(self::$campaignData);


			foreach($data as $k=>$v)
				$this->$k = $v;
		}

		self::$instance = $this;
		
	
	}
}

/* 
!---------------------------------IMPORTANT-----------------------------------!

	ABSOLUTELY DO NOT EDIT BELOW THIS LINE
	
!---------------------------------IMPORTANT-----------------------------------!
*/
$requestUri = $_SERVER['REQUEST_URI'];
$baseFile = basename(__FILE__);

if($_SERVER['REQUEST_METHOD']=='POST' && strstr($requestUri,$baseFile))
{
	
	$authString = filter_input(INPUT_POST,'authString',FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
	if(empty($authString))
		die(); //exit silently, don't want people to know that this file processes api requests if they are just sending random posts at it
	
	
	$remoteIp = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
		  $remoteIp =  $_SERVER["HTTP_CF_CONNECTING_IP"];
	
	$allowedIps = KFormConfig::$options['autoUpdate_allowedIps'];
	if(!in_array($remoteIp,$allowedIps))
		die("ERROR: Invalid IP Address. Please confirm that the Konnektive IP Address is in the allowedIps array.");
	if($authString != KFormConfig::$options['authString'])
		die("ERROR: Could not authenticate authString. Please re-download code package and replace config file on your server.");

	$data = filter_input(INPUT_POST,'data');
	$data = trim($data);
	$data = utf8_encode($data);
	$decoded = json_decode($data);
	if($decoded != NULL)
	{
		$file = fopen(__FILE__,'r');
		if(empty($file))
			die("ERROR: File not writable");

		$new_file = '';

		while($line = fgets($file))
		{
			$new_file .= $line;

			if(strpos($line,"/*[DYNAMIC-DATA-TOKEN]") === 0)
				break;
		}
		fclose($file);

		$new_file .= "KFormConfig::\$campaignData = '$data';".PHP_EOL;
		$ret = file_put_contents(__FILE__,$new_file);


		if(is_int($ret))
			die("SUCCESS");
		else
			die("ERROR: File not writable");
	}
	else
	{
		die("ERROR: what data");
	}
}

/*[DYNAMIC-DATA-TOKEN] do not remove */

KFormConfig::$campaignData = '{
    "countries": {
        "IT": "Italy"
    },
    "states": {
        "IT": {
            "65": "Abruzzo",
            "AG": "Agrigento",
            "AL": "Alessandria",
            "AN": "Ancona",
            "AO": "Aosta",
            "AR": "Arezzo",
            "AP": "Ascoli Piceno",
            "AT": "Asti",
            "AV": "Avellino",
            "BA": "Bari",
            "BT": "Barletta-Andria-Trani",
            "77": "Basilicata",
            "BL": "Belluno",
            "BN": "Benevento",
            "BG": "Bergamo",
            "BI": "Biella",
            "BO": "Bologna",
            "BZ": "Bolzano",
            "BS": "Brescia",
            "BR": "Brindisi",
            "CA": "Cagliari",
            "78": "Calabria",
            "CL": "Caltanissetta",
            "72": "Campania",
            "CB": "Campobasso",
            "CI": "Carbonia-Iglesias",
            "CE": "Caserta",
            "CT": "Catania",
            "CZ": "Catanzaro",
            "CH": "Chieti",
            "CO": "Como",
            "CS": "Cosenza",
            "CR": "Cremona",
            "KR": "Crotone",
            "CN": "Cuneo",
            "45": "Emilia-Romagna",
            "EN": "Enna",
            "FM": "Fermo",
            "FE": "Ferrara",
            "FI": "Firenze",
            "FG": "Foggia",
            "FC": "Forli-Cesena",
            "36": "Friuli-Venezia Giulia",
            "FR": "Frosinone",
            "GE": "Genova",
            "GO": "Gorizia",
            "GR": "Grosseto",
            "IM": "Imperia",
            "IS": "Isernia",
            "AQ": "L\u0027Aquila",
            "SP": "La Spezia",
            "LT": "Latina",
            "62": "Lazio",
            "LE": "Lecce",
            "LC": "Lecco",
            "42": "Liguria",
            "LI": "Livorno",
            "LO": "Lodi",
            "25": "Lombardia",
            "LU": "Lucca",
            "MC": "Macerata",
            "MN": "Mantova",
            "57": "Marche",
            "MS": "Massa-Carrara",
            "MT": "Matera",
            "VS": "Medio Campidano",
            "ME": "Messina",
            "MI": "Milano",
            "MO": "Modena",
            "67": "Molise",
            "MB": "Monza e Brianza",
            "NA": "Napoli",
            "NO": "Novara",
            "NU": "Nuoro",
            "OG": "Ogliastra",
            "OT": "Olbia-Tempio",
            "OR": "Oristano",
            "PD": "Padova",
            "PA": "Palermo",
            "PR": "Parma",
            "PV": "Pavia",
            "PG": "Perugia",
            "PU": "Pesaro e Urbino",
            "PE": "Pescara",
            "PC": "Piacenza",
            "21": "Piemonte",
            "PI": "Pisa",
            "PT": "Pistoia",
            "PN": "Pordenone",
            "PZ": "Potenza",
            "PO": "Prato",
            "75": "Puglia",
            "RG": "Ragusa",
            "RA": "Ravenna",
            "RC": "Reggio Calabria",
            "RE": "Reggio Emilia",
            "RI": "Rieti",
            "RN": "Rimini",
            "RM": "Roma",
            "RO": "Rovigo",
            "SA": "Salerno",
            "88": "Sardegna",
            "SS": "Sassari",
            "SV": "Savona",
            "82": "Sicilia",
            "SI": "Siena",
            "SR": "Siracusa",
            "SO": "Sondrio",
            "TA": "Taranto",
            "TE": "Teramo",
            "TR": "Terni",
            "TO": "Torino",
            "52": "Toscana",
            "TP": "Trapani",
            "32": "Trentino-Alto Adige",
            "TN": "Trento",
            "TV": "Treviso",
            "TS": "Trieste",
            "UD": "Udine",
            "55": "Umbria",
            "23": "Valle d\u0027Aosta",
            "VA": "Varese",
            "34": "Veneto",
            "VE": "Venezia",
            "VB": "Verbano-Cusio-Ossola",
            "VC": "Vercelli",
            "VR": "Verona",
            "VV": "Vibo Valentia",
            "VI": "Vicenza",
            "VT": "Viterbo"
        }
    },
    "currencySymbol": "\u20ac",
    "shipOptions": [],
    "coupons": [],
    "products": [],
    "webPages": {
        "catalogPage": {
            "disableBack": 0,
            "url": "https:\/\/www.sieropercigliafantastico.com\/"
        },
        "checkoutPage": {
            "disableBack": 0,
            "url": "https:\/\/www.sieropercigliafantastico.com\/checkout.php",
            "autoImportLead": 1,
            "productId": null,
            "requireSig": 0,
            "sigType": 0,
            "cardinalAuth": 0,
            "paayApiKey": null
        },
        "thankyouPage": {
            "disableBack": 0,
            "url": "https:\/\/www.sieropercigliafantastico.com\/thankyou.php",
            "createAccountDialog": 0,
            "reorderUrl": null,
            "allowReorder": 0
        },
        "upsellPage1": {
            "disableBack": 1,
            "url": "https:\/\/www.sieropercigliafantastico.com\/upsell1.php",
            "createAccountDialog": 0,
            "requirePayInfo": 0,
            "productId": 62,
            "replaceProductId": null
        },
        "upsellPage2": {
            "disableBack": 1,
            "url": "https:\/\/www.sieropercigliafantastico.com\/upsell2.php",
            "createAccountDialog": 0,
            "requirePayInfo": 0,
            "productId": 61,
            "replaceProductId": null
        },
        "upsellPage3": {
            "disableBack": 1,
            "url": "https:\/\/www.sieropercigliafantastico.com\/upsell3.php",
            "createAccountDialog": 0,
            "requirePayInfo": 0,
            "productId": 63,
            "replaceProductId": null
        },
        "productDetails": {
            "url": "product-details.php"
        }
    },
    "landerType": "CART",
    "googleTrackingId": "UA-156371226-1",
    "enableFraudPlugin": 0,
    "autoTax": 0,
    "taxServiceId": null,
    "companyName": "optin_solutions_llc",
    "offers": {
        "59": {
            "productId": 59,
            "name": "Feg Serum - Eyelash Enhancer",
            "description": "*No description available",
            "imagePath": "https:\/\/www.sieropercigliafantastico.com\/resources\/images\/smain-small.jpg",
            "imageId": 1,
            "price": "11.97",
            "shipPrice": "0.00",
            "category": "FEG"
        },
        "60": {
            "productId": 60,
            "name": "Feg Serum - Eyelash Enhancer - Free",
            "description": "*No description available",
            "imagePath": "https:\/\/www.sieropercigliafantastico.com\/resources\/images\/smain-small.jpg",
            "imageId": 1,
            "price": "0.00",
            "shipPrice": "0.00",
            "category": "FEG"
        }
    },
    "upsells": {
        "61": {
            "productId": 61,
            "name": "Feg Serum - Eyelash Enhancer - Free Gift",
            "description": "*No description available",
            "imagePath": "https:\/\/www.sieropercigliafantastico.com\/resources\/images\/upsell1.jpg",
            "imageId": 1,
            "price": "4.95",
            "shipPrice": "0.00",
            "category": "FEG"
        },
        "62": {
            "productId": 62,
            "name": "FEG - EyeBrown (2pcs - 2 months of treatment)",
            "description": "*No description available",
            "imagePath": "https:\/\/www.sieropercigliafantastico.com\/resources\/images\/upsell2.jpg",
            "imageId": 2,
            "price": "9.95",
            "shipPrice": "0.00",
            "category": "FEG"
        },
        "63": {
            "productId": 63,
            "name": "Silicone Make-Up Sponge",
            "description": "*No description available",
            "imagePath": "https:\/\/www.sieropercigliafantastico.com\/resources\/images\/upsell3-it.jpg",
            "imageId": 3,
            "price": "4.95",
            "shipPrice": "0.00",
            "category": "FEG"
        }
    },
    "shipProfiles": [],
    "continents": {
        "IT": "EU"
    },
    "paypal": {
        "paypalBillerId": 6
    }
}';