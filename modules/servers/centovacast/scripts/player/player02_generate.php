<?php
// Top Cache
$url = $_SERVER['SCRIPT_NAME'];
$break = explode('/', $url);
$file = $break[count($break) - 1];

$username = $_GET['username'];
$usernameReplace = str_replace('=', '', $username);
$cachefile = 'cache/'.$usernameReplace.'_02.html';

$cachetime = 15;

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    echo '<!-- Cached copy, generated '.date('H:i', filemtime($cachefile))." -->\n";
    readfile($cachefile);
    exit;
}
ob_start(); // Start the output buffer

// Script
set_time_limit(30);

$radioname = htmlspecialchars($_GET['radioname']);
$mountpointnumber = htmlspecialchars($_GET['mountpointnumber']);
$servertype = htmlspecialchars($_GET['servertype']);
$showhistory = htmlspecialchars($_GET['showhistory']);
$showlyrics = htmlspecialchars($_GET['showlyrics']);
$playerurl = htmlspecialchars($_GET['playerurl']);
$defaultcover = htmlspecialchars($_GET['defaultcover']);
$backgroundurl = htmlspecialchars($_GET['backgroundurl']);
$spuserid = htmlspecialchars($_GET['userid']);
$lang = htmlspecialchars($_GET['lang']);
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="noindex,noarchive,nosnippet" />
    <link rel="stylesheet" href="https://spuassets.streampanel.cloud/global/plugins/fontawesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://spuassets.streampanel.cloud/global/plugins/animate/3.7.2/animate.min.css" />
    <link rel="stylesheet" href="https://scripts.streampanel.net/cc/player/02/css/style.min.css" />

    <style type="text/css">
        .cover-album {
            max-width: 80%;
            margin: auto;
            background: url('<?php echo base64_decode($defaultcover); ?>') no-repeat;
            background-size: cover;
            border: 1px solid #383838;
            box-shadow: 0px 5px 10px 3px rgba(0, 0, 0, 0.4);
            transition: background-image 1s;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <main>
        <section id="player">



            <div class="card" style="width: 321px;">

                <div class="cover-album">
                    <div id="currentCoverArt"></div>
                    <div class="watermark"></div>
                </div>

                <div class="card-body">
                    <h1 class="card-title"><?php echo base64_decode($radioname); ?>
                    </h1>
                    <p class="card-text">

                    <div class="info-current-song">
                        <h2 id="currentSong" class="current-song text-uppercase">...</h2>
                        <h3 id="currentArtist" class="current-artist text-captalize">...</h3>
                    </div>

                    </p>

                    <div class="row">
                        <div class="volume-icon col-1"><i id="playerButton" class="fas fa-play" onclick="togglePlay()"></i></div>
                        <div class="play-icon col-1"><i class="fas fa-volume-up"></i></div>
                        <div class="volume-slide col-9 text-center">
                            <input class="form-control-range" type="range" id="volume" step="1" min="0" max="100" value="80" />
                            <div class="percentual-volume col-12">
                                <?php if ('de' == $lang) {
    echo 'Lautstärke';
} else {
    echo 'Volume';
} ?> <span id="volIndicator">...</span>%
                            </div>
                        </div>
                    </div>

                    <a href="#" class="lyrics" style="" data-target="#modalLyrics">
                        <?php if ('de' == $lang) {
    echo '<!--Songtext-->';
} else {
    echo '<!--Lyrics-->';
} ?>
                    </a>

                </div>

            </div>


            <div class="modal fade" id="modalLyrics" tabindex="-1" role="dialog" aria-labelledby="lyricsSong" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="lyricsSong">Lyric</h5>
                            <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="lyric"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <?php if ('de' == $lang) {
    echo 'Schließen';
} else {
    echo 'Close';
} ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </main>

    <script type="text/javascript" src="https://spuassets.streampanel.cloud/global/plugins/jquery/3.6.0/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://spuassets.streampanel.cloud/global/plugins/popper.js/1.14.7/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://spuassets.streampanel.cloud/global/plugins/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        var settings = {
            'radio_name': '<?php echo base64_decode($radioname); ?>',
            'url_streaming': '<?php echo base64_decode($playerurl); ?>',
            'streaming_type': '<?php echo $servertype; ?>',
            'mountpoint_number': '<?php echo $mountpointnumber; ?>',
            'api_key': 'bbade670c84329e71ff96322ae879244',
            'historic': <?php echo $showhistory; ?> ,
            'next_song': false,
            'sp_userid': '<?php echo $spuserid; ?>',
            'default_cover_art': '<?php echo base64_decode($defaultcover); ?>',
        };
    </script>
    <script type="text/javascript" src="https://scripts.streampanel.net/cc/player/02/js/script.min.js"></script>



</body>

</html>

<?php
// Cache the contents to a cache file
$cached = fopen($cachefile, 'w');
fwrite($cached, ob_get_contents());
fclose($cached);
ob_end_flush(); // Send the output to the browser
