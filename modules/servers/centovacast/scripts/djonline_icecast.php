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
    // Show is DJ on or not
    $search = $source[2]['yp_currently_playing'];
    if (false !== strpos($search, 'dj_') || false !== strpos($search, 'DJ_') || false !== strpos($search, 'Dj_') || false !== strpos($search, 'dJ_') || false !== strpos($search, 'dj ') || false !== strpos($search, 'DJ ') || false !== strpos($search, 'Dj ') || false !== strpos($search, 'dJ ') || false !== strpos($search, ' | ')) {
        $customText = $_GET['ctext'];
        echo '<div style="color:'.$_GET['color'].';">DJ'.htmlspecialchars($customText).'</div>';
    } else {
        $customText = $_GET['ctext'];
        echo '<div style="color:'.$_GET['color'].';">AutoDJ'.htmlspecialchars($customText).'</div>';
    }
    exit;
}

if ('' == $source[1]['yp_currently_playing']) {
    // Do nothing
} else {
    // Show is DJ on or not
    $search = $source[1]['yp_currently_playing'];
    if (false !== strpos($search, 'dj_') || false !== strpos($search, 'DJ_') || false !== strpos($search, 'Dj_') || false !== strpos($search, 'dJ_') || false !== strpos($search, 'dj ') || false !== strpos($search, 'DJ ') || false !== strpos($search, 'Dj ') || false !== strpos($search, 'dJ ') || false !== strpos($search, ' | ')) {
        $customText = $_GET['ctext'];
        echo '<div style="color:'.$_GET['color'].';">DJ'.htmlspecialchars($customText).'</div>';
    } else {
        $customText = $_GET['ctext'];
        echo '<div style="color:'.$_GET['color'].';">AutoDJ'.htmlspecialchars($customText).'</div>';
    }
    exit;
}

if ('' == $source[0]['yp_currently_playing']) {
    // Do nothing
} else {
    // Show is DJ on or not
    $search = $source[0]['yp_currently_playing'];
    if (false !== strpos($search, 'dj_') || false !== strpos($search, 'DJ_') || false !== strpos($search, 'Dj_') || false !== strpos($search, 'dJ_') || false !== strpos($search, 'dj ') || false !== strpos($search, 'DJ ') || false !== strpos($search, 'Dj ') || false !== strpos($search, 'dJ ') || false !== strpos($search, ' | ')) {
        $customText = $_GET['ctext'];
        echo '<div style="color:'.$_GET['color'].';">DJ'.htmlspecialchars($customText).'</div>';
    } else {
        $customText = $_GET['ctext'];
        echo '<div style="color:'.$_GET['color'].';">AutoDJ'.htmlspecialchars($customText).'</div>';
    }
    exit;
}

if ('' == $source['yp_currently_playing']) {
    // Do nothing
} else {
    // Show is DJ on or not
    $search = $source['yp_currently_playing'];
    if (false !== strpos($search, 'dj_') || false !== strpos($search, 'DJ_') || false !== strpos($search, 'Dj_') || false !== strpos($search, 'dJ_') || false !== strpos($search, 'dj ') || false !== strpos($search, 'DJ ') || false !== strpos($search, 'Dj ') || false !== strpos($search, 'dJ ') || false !== strpos($search, ' | ')) {
        $customText = $_GET['ctext'];
        echo '<div style="color:'.$_GET['color'].';">DJ'.htmlspecialchars($customText).'</div>';
    } else {
        $customText = $_GET['ctext'];
        echo '<div style="color:'.$_GET['color'].';">AutoDJ'.htmlspecialchars($customText).'</div>';
    }
    exit;
}