<?php

$server = $_GET['url'];

$url = "$server/status-json.xsl";
//  Initiate curl
$ch = curl_init();
// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set UserAgent
curl_setopt($curl, CURLOPT_USERAGENT, 'SPMetaDataCrawler/1.0');
// Set the url
curl_setopt($ch, CURLOPT_URL, $url);
// Execute
$result = curl_exec($ch);
// Closing
curl_close($ch);

$result = json_decode($result, true); /* UPDATED */
$stats = $result['icestats'];
// go deeper
$source = $stats['source'];

echo '<div style="color:'.$_GET['color'].';">'.$source['listeners'].'</div>';

if ('0' == $source[0]['listeners']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source[0]['listeners'].'</div>';
}

if ('0' == $source[1]['listeners']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source[1]['listeners'].'</div>';
}

if ('0' == $source[2]['listeners']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source[2]['listeners'].'</div>';
}
