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

if ('' == $source[2]['yp_currently_playing']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source[2]['yp_currently_playing'].'</div>';
    exit;
}

if ('' == $source[1]['yp_currently_playing']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source[1]['yp_currently_playing'].'</div>';
    exit;
}

if ('' == $source[0]['yp_currently_playing']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source[0]['yp_currently_playing'].'</div>';
    exit;
}

if ('' == $source['yp_currently_playing']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source['yp_currently_playing'].'</div>';
    exit;
}
