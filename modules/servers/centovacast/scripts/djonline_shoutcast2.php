<?php

$server = $_GET['url'];

$url = "$server/stats?sid=1&json=1";
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

// Show is DJ on or not
$search = $result['songtitle'];
if (false !== strpos($search, 'dj_') || false !== strpos($search, 'DJ_') || false !== strpos($search, 'Dj_') || false !== strpos($search, 'dJ_') || false !== strpos($search, 'dj ') || false !== strpos($search, 'DJ ') || false !== strpos($search, 'Dj ') || false !== strpos($search, 'dJ ') || false !== strpos($search, ' | ')) {
    $customText = $_GET['ctext'];
    echo '<div style="color:'.$_GET['color'].';">DJ'.htmlspecialchars($customText).'</div>';
} else {
    $customText = $_GET['ctext'];
    echo '<div style="color:'.$_GET['color'].';">AutoDJ'.htmlspecialchars($customText).'</div>';
}
