<?php

// For debugging
// ini_set('display_errors', 1);
// error_reporting(E_ALL ^ E_NOTICE);

// Extracting meta tag
function getMetaTags($str)
{
  $pattern = '
  ~<\s*meta\s
  # using lookahead to capture type to $1
    (?=[^>]*?
    \b(?:name|property|http-equiv)\s*=\s*
    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
  )
  # capture content to $2
  [^>]*?\bcontent\s*=\s*
    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
  [^>]*>
  ~ix';
 
  if(preg_match_all($pattern, $str, $out))
    return array_combine($out[1], $out[2]);
  return array();
}

// Crawler
function crawler($url)
{
	$ch = curl_init();
	
	$ua = 'NokiaE63/210.21.004 (SymbianOS/9.2; U; Series60/3.1 Mozilla/5.0; Profile/MIDP-2.0 Configuration/CLDC-1.1 ) AppleWebKit/413 (KHTML, like Gecko) Safari/413';
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
$post = json_decode(file_get_contents('php://input'));
//$metaTags = getMetaTags(crawler('https://web.facebook.com/AsoepanSYM/videos/196668778213459/?t=7'));
$metaTags = filter_var($post->url, FILTER_VALIDATE_URL) ? getMetaTags(crawler($post->url)) : false;
// header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: http://fbdown.now.sh');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Content-Type: application/json');
echo json_encode(array(
	'status' => $metaTags ? 'success': 'error',
	'data' => $metaTags ? [
		'title' => !$metaTags['og:title'] ? 'Facebook Watch' : $metaTags['og:title'],
		'image' => htmlspecialchars_decode($metaTags['og:image']),
		// 'video' => $metaTags
		'video' => htmlspecialchars_decode($metaTags['og:video'])
	] : null
));