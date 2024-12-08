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

if ('' == $source[2]['artist']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source[2]['artist'].'</div>';
    exit;
}

if ('' == $source[1]['artist']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source[1]['artist'].'</div>';
    exit;
}

if ('' == $source[0]['artist']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source[0]['artist'].'</div>';
    exit;
}

if ('' == $source['artist']) {
    // Do nothing
} else {
    echo '<div style="color:'.$_GET['color'].';">'.$source['artist'].'</div>';
    exit;
}
