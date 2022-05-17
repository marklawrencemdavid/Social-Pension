<?php 
	function is_bot($user_agent) {
		$botRegexPattern = "(googlebot\/|Googlebot\-Mobile|Googlebot\-Image|Google favicon|Mediapartners\-Google|bingbot|slurp|java|wget|curl|Commons\-HttpClient|Python\-urllib|libwww|httpunit|nutch|phpcrawl|msnbot|jyxobot|FAST\-WebCrawler|FAST Enterprise Crawler|biglotron|teoma|convera|seekbot|gigablast|exabot|ngbot|ia_archiver|GingerCrawler|webmon |httrack|webcrawler|grub\.org|UsineNouvelleCrawler|antibot|netresearchserver|speedy|fluffy|bibnum\.bnf|findlink|msrbot|panscient|yacybot|AISearchBot|IOI|ips\-agent|tagoobot|MJ12bot|dotbot|woriobot|yanga|buzzbot|mlbot|yandexbot|purebot|Linguee Bot|Voyager|CyberPatrol|voilabot|baiduspider|citeseerxbot|spbot|twengabot|postrank|turnitinbot|scribdbot|page2rss|sitebot|linkdex|Adidxbot|blekkobot|ezooms|dotbot|Mail\.RU_Bot|discobot|heritrix|findthatfile|europarchive\.org|NerdByNature\.Bot|sistrix crawler|ahrefsbot|Aboundex|domaincrawler|wbsearchbot|summify|ccbot|edisterbot|seznambot|ec2linkfinder|gslfbot|aihitbot|intelium_bot|facebookexternalhit|yeti|RetrevoPageAnalyzer|lb\-spider|sogou|lssbot|careerbot|wotbox|wocbot|ichiro|DuckDuckBot|lssrocketcrawler|drupact|webcompanycrawler|acoonbot|openindexspider|gnam gnam spider|web\-archive\-net\.com\.bot|backlinkcrawler|coccoc|integromedb|content crawler spider|toplistbot|seokicks\-robot|it2media\-domain\-crawler|ip\-web\-crawler\.com|siteexplorer\.info|elisabot|proximic|changedetection|blexbot|arabot|WeSEE:Search|niki\-bot|CrystalSemanticsBot|rogerbot|360Spider|psbot|InterfaxScanBot|Lipperhey SEO Service|CC Metadata Scaper|g00g1e\.net|GrapeshotCrawler|urlappendbot|brainobot|fr\-crawler|binlar|SimpleCrawler|Livelapbot|Twitterbot|cXensebot|smtbot|bnf\.fr_bot|A6\-Indexer|ADmantX|Facebot|Twitterbot|OrangeBot|memorybot|AdvBot|MegaIndex|SemanticScholarBot|ltx71|nerdybot|xovibot|BUbiNG|Qwantify|archive\.org_bot|Applebot|TweetmemeBot|crawler4j|findxbot|SemrushBot|yoozBot|lipperhey|y!j\-asr|Domain Re\-Animator Bot|AddThis|YisouSpider|BLEXBot|YandexBot|SurdotlyBot|AwarioRssBot|FeedlyBot|Barkrowler|Gluten Free Crawler|Cliqzbot)";

		return preg_match("/{$botRegexPattern}/", $user_agent);
	}
	if ( !is_bot($_SERVER['HTTP_USER_AGENT']) ) {
		$curPageName = basename($_SERVER['PHP_SELF']);
		if($curPageName == 'portfolio.php' || $curPageName == 'accomplishment-report.php'){
			include('../assets/vendor/browser-detect/BrowserDetection.php');
		}else{
			include('assets/vendor/browser-detect/BrowserDetection.php');
		}
		date_default_timezone_set('Asia/Manila');

		$browser = new Wolfcast\BrowserDetection;

		$vis_browser_name = $browser->getName();
		$vis_browser_version = $browser->getVersion();
		$vis_platform = $browser->getPlatform();
		$vis_platform_version = $browser->getPlatformVersion();

		// Device
		if($browser->isMobile()){$vis_device = 'Mobile';}
		else{$vis_device = 'Computer';}

		// Page viewed
		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parse = parse_url($url);
		if(str_replace('/','',$parse['path']) == ''){
            $parse['path'] = '/';
        }
        $vis_url = preg_replace('#^www\.(.+\.)#i', '$1', $parse['host']) . $parse['path'];
		$vis_url = str_replace('.php', '', $vis_url);
		$vis_url = str_replace('index', '', $vis_url);
		$vis_url = str_replace('./', '/', $vis_url);

		// Referer
		$vis_referred = '';
		if(isset($_SERVER['HTTP_REFERER'])){$parse=parse_url($_SERVER['HTTP_REFERER']);}
		if (strpos($parse['host'], 't.co')!==false){$parse['host']='www.twitter.com';}
		if(isset($parse['host'])){$vis_referred =$parse['host'];}


		// Get IP Address
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){$ip=$_SERVER['HTTP_CLIENT_IP'];}
		else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
		else{$ip=$_SERVER['REMOTE_ADDR'];}
		// Use JSON encoded string and converts it into a PHP variable
		$ipdat = @json_decode(file_get_contents( "http://www.geoplugin.net/json.gp?ip=" . $ip));
		
		$tmp = (array) $ipdat;
        if(!empty($tmp)){
    		$vis_country = $ipdat->geoplugin_countryName;
    		$vis_city = $ipdat->geoplugin_city;
        }else{
    		$vis_country = '';
    		$vis_city = '';
        }

		$sql = "INSERT INTO tbl_visitor(vis_browser_name,vis_browser_version,vis_device,vis_platform,vis_platform_version,vis_url,vis_referred,vis_country,vis_city,vis_date) 
				VALUES('$vis_browser_name','$vis_browser_version','$vis_device','$vis_platform','$vis_platform_version','$vis_url','$vis_referred','$vis_country','$vis_city','".date('Y-m-d H:i:s')."')";
		mysqli_query($con,$sql);
	}
?>