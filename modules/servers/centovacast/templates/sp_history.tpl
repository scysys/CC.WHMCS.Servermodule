{php}
set_time_limit(30);
$SP_LANG = $template->getVariable('LANG')->value;
{/php}

<style type="text/css">
    .dt-buttons.btn-group {
        display: none;
    }
</style>

{php}
// Create connection

if ( $_GET[ 'spsystem' ] == 'xxx' ) {
$conn = new mysqli( 'xxx.streampanel.net', 'xxx', 'xxx', 'xxx' );
#create user xxx;
#GRANT SELECT ON xxx.* TO xxx'%' IDENTIFIED BY 'xxx';
#FLUSH PRIVILEGES;
} elseif ( $_GET[ 'spsystem' ] == 'xxx' ) {
$conn = new mysqli( 'xxx.streampanel.net', 'xxx', 'xxx', 'xxx' );
#create user xxx;
#GRANT SELECT ON xxx.* TO xxx'%' IDENTIFIED BY 'xxx';
#FLUSH PRIVILEGES;
} elseif ( $_GET[ 'spsystem' ] == 'xxx' ) {
$conn = new mysqli( 'xxx.streampanel.net', 'xxx', 'xxx', 'xxx' );
#create user xxx;
#GRANT SELECT ON xxx.* TO xxx'%' IDENTIFIED BY 'xxx';
#FLUSH PRIVILEGES;
} elseif ( $_GET[ 'spsystem' ] == 'xxx' ) {
$conn = new mysqli( 'xxx.streampanel.net', 'xxx', 'xxx', 'xxx' );
#create user xxx;
#GRANT SELECT ON xxx.* TO xxx'%' IDENTIFIED BY 'xxx';
#FLUSH PRIVILEGES;
} elseif ( $_GET[ 'spsystem' ] == 'xxx' ) {
$conn = new mysqli( 'xxx.streampanel.net', 'xxx', 'xxx', 'xxx' );
#create user xxx;
#GRANT SELECT ON xxx.* TO xxx'%' IDENTIFIED BY 'xxx';
#FLUSH PRIVILEGES;
} elseif ( $_GET[ 'spsystem' ] == 'xxx' ) {
$conn = new mysqli( 'xxx.streampanel.net', 'xxx', 'xxx', 'xxx' );
#create user xxx;
#GRANT SELECT ON xxx.* TO xxx'%' IDENTIFIED BY 'xxx';
#FLUSH PRIVILEGES;
} elseif ( $_GET[ 'spsystem' ] == 'xxx' ) {
$conn = new mysqli( 'xxx.streampanel.net', 'xxx', 'xxx', 'xxx' );
#create user xxx;
#GRANT SELECT ON xxx.* TO xxx'%' IDENTIFIED BY 'xxx';
#FLUSH PRIVILEGES;
} elseif ( $_GET[ 'spsystem' ] == 'xxx' ) {
$conn = new mysqli( 'xxx.streampanel.net', 'xxx', 'xxx', 'xxx' );
#create user xxx;
#GRANT SELECT ON xxx.* TO xxx'%' IDENTIFIED BY 'xxx';
#FLUSH PRIVILEGES;
}

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$cc_username = $template->getVariable('username')->value;
$sql_accounts = "SELECT id, title FROM accounts WHERE username = '".mysql_real_escape_string($cc_username)."' LIMIT 1";
$query_accounts = mysqli_query($conn, $sql_accounts);
$result_accounts = mysqli_fetch_assoc($query_accounts);

#$sql_tracks = "SELECT t.id, t.pathname, t.title, t.artistid, a.name FROM (SELECT id, pathname, title, artistid FROM tracks WHERE accountid = '$cc_accountid' LIMIT 5) t, (SELECT name FROM track_artists WHERE accountid = '$cc_accountid' LIMIT 5) a";
#$sql_track_artists = "SELECT a.name FROM (SELECT name FROM track_artists WHERE id = '7992' LIMIT 5) t";
#$result_track_artists = $conn->query($sql_track_artists);

$cc_accountid = $result_accounts['id'];
$sql_tracks = "SELECT t.id, t.pathname, t.title, t.artistid FROM (SELECT id, pathname, title, artistid FROM tracks WHERE accountid = '".mysql_real_escape_string($cc_accountid)."' LIMIT 25) t";
$result_tracks = $conn->query($sql_tracks);
$result_tracks_modal = $conn->query($sql_tracks);
{/php}

<div class="card card-custom">
    <div class="card-header py-3">
        <div class="card-title">
            <h3 class="card-label">{php}echo $result_accounts['title'];{/php}: {lang key="sp_centovacast_wishbox"}</h3>
        </div>
        <div class="card-toolbar">
            <div class="dropdown dropdown-inline mr-2">
                <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path
                                    d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                    fill="#000000" opacity="0.3" />
                                <path
                                    d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                    fill="#000000" />
                            </g>
                        </svg>
                    </span>{lang key='sp_tableexport'}</button>
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <ul class="navi flex-column navi-hover py-2">
                        <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">{lang key='sp_export_options'}</li>
                        <li class="navi-item">
                            <a href="#" class="navi-link" id="export_print">
                                <span class="navi-icon">
                                    <i class="la la-print"></i>
                                </span>
                                <span class="navi-text">{lang key='sp_print'}</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link" id="export_copy">
                                <span class="navi-icon">
                                    <i class="la la-copy"></i>
                                </span>
                                <span class="navi-text">{lang key='sp_copy'}</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link" id="export_excel">
                                <span class="navi-icon">
                                    <i class="la la-file-excel-o"></i>
                                </span>
                                <span class="navi-text">Excel</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link" id="export_csv">
                                <span class="navi-icon">
                                    <i class="la la-file-text-o"></i>
                                </span>
                                <span class="navi-text">CSV</span>
                            </a>
                        </li>
                        <li class="navi-item">
                            <a href="#" class="navi-link" id="export_pdf">
                                <span class="navi-icon">
                                    <i class="la la-file-pdf-o"></i>
                                </span>
                                <span class="navi-text">PDF</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">

        {php}
        // Debug
        #echo $sql_accounts;
        #echo $sql_tracks;

        echo "
        <input type='text' id='SPCustomSearchBox' class='form-control' placeholder='".$SP_LANG[sp_enter_your_search]."' />
        <table class='table table-striped table-bordered table-hover' id='SPDataTable'>
            ";
            echo "
            <thead>
                ";
                echo "<tr>";
                    echo "<th class='sp_no_id'>".$SP_LANG[sp_id]."</th>";
                    echo "<th class='sp_no_cover'>".$SP_LANG[sp_cover]."</th>";
                    echo "<th class='sp_no_artist'>".$SP_LANG[sp_artist]."</th>";
                    echo "
                    <th class='sp_no_title'>".$SP_LANG[sp_title]."</th>
                    ";
                    echo "
                    <th class='sp_no_action'>".$SP_LANG[sp_options]."</th>
                    ";
                    echo "
                </tr>
            </thead>
            ";
            echo "

            <tbody>
                ";

                $search_value = ['(', ')', 'Ã¤', 'Ã¼', 'Ã¶', 'Ã³', 'ÃÂ', '.mp3', '.aac', 'xxx', 'xxx', 'xxx', 'xxx'];
                $replace_value = ['', '', 'ä', 'ü', 'ö', 'ó', 'ê', '', '', 'xxx', 'xxx', 'xxx', 'xxx'];

                if ($result_tracks->num_rows > 0) {
                // output data of each row
                while($row = $result_tracks->fetch_assoc()) {

                // Get Artist Name
                $sql_track_artists = "SELECT a.name FROM (SELECT name FROM track_artists WHERE id = '" . mysql_real_escape_string($row["artistid"]) . "' LIMIT 1) a";
                $query_track_artists = mysqli_query($conn, $sql_track_artists);
                $result_track_artists = mysqli_fetch_assoc($query_track_artists);
                $cc_track_artist = $result_track_artists['name'];
                $cc_track_artist_utf8 = utf8_encode($cc_track_artist);

                $cc_track_title = str_replace($search_value, $replace_value, $row["title"]);
                $cc_track_title_utf8 = utf8_encode($cc_track_title);

                echo "
                <tr class='sp_id_".$row["id"]."'>";
                    echo "<td class='sp_no_id'>" . $row["id"]. "</td>";

                    $cover_small_output = file_get_contents("https://cover.streampanel.net/cover-api/sp/track.php?title=" . str_replace(['+', '%26apos%3B', '%20%20'], ['%20', '%27', '%20'], urlencode($cc_track_artist_utf8 . " - " . $cc_track_title_utf8)) . "&size=small&urlonly=yes");
                    echo "
                    <td class='sp_no_cover'><img src='".$cover_small_output."' loading='lazy' alt='".$cc_track_artist_utf8." - ".$cc_track_title_utf8."' class='sp_wishbox_cover' width='64px' height='64px' /></td>
                    ";

                    echo "<td>" . $cc_track_artist_utf8 . "</td>";

                    echo "<td>" . $cc_track_title_utf8 . "</td>";

                    echo "<td><a href='https://scripts.streampanel.net/cc/history/wishbox.php?
		lang=de
		&spsystem=" . $_GET["spsystem"] . "
		&radioname=" . base64_encode($result_accounts["title"]) . "
		&artist=" . base64_encode($cc_track_artist_utf8) . "
		&title=" . base64_encode($cc_track_title_utf8) . "
		&name=" . base64_encode($cc_username) . "'
		class='btn btn-primary btn-block btn-focus btn-sm' target='_blank' rel='noopener'>".$SP_LANG[sp_centovacast_wishbox_sendrequest]."</a></td>
        ";
        echo "</tr>";
    }
}
echo "</tbody>"; 
echo "</table>";
          {/php} </div>
    </div>
    {php}
    $conn->close();
    {/php}