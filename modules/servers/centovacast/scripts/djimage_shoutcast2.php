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

// Show DJ Image when Online
$search = $result['songtitle'];
if (false !== strpos($search, 'dj_') || false !== strpos($search, 'DJ_') || false !== strpos($search, 'Dj_') || false !== strpos($search, 'dJ_') || false !== strpos($search, 'dj ') || false !== strpos($search, 'DJ ') || false !== strpos($search, 'Dj ') || false !== strpos($search, 'dJ ') || false !== strpos($search, ' | ')) {
    $imagepath = $_GET['cimgpath'];
    $width = $_GET['width'];

    $djImage = substr($search, strpos($search, ' | '));
    $djImageReplace = substr($djImage, 0, 6);
    $djOutput = str_replace(' ', '', $djImageReplace);

    echo "<img src='".htmlspecialchars($imagepath).$djOutput.".png' width='".$width."' alt='".$djOutput.".png' />";
} else {
    $imagepath = $_GET['cimgpath'];
    $width = $_GET['width'];
    echo "<img src='".htmlspecialchars($imagepath)."autodj.png' width='".$width."' alt='autodj.png' />";
}