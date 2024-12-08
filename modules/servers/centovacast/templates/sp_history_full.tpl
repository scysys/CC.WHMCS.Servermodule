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

if ( $_GET[ 'spsystem' ] == 'bud' ) {
$conn = new mysqli( 'bud.streampanel.net', 'YdXV919F717tRHyq', 'KAzE68Kb$9WZgTh1sqnoI60b$LBn0#VD', 'TvemW7qs7yamrqMY0HjLXKTihZBpTn2Q' );
#create user YdXV919F717tRHyq;
#GRANT SELECT ON TvemW7qs7yamrqMY0HjLXKTihZBpTn2Q.* TO YdXV919F717tRHyq@'%' IDENTIFIED BY 'KAzE68Kb$9WZgTh1sqnoI60b$LBn0#VD';
#FLUSH PRIVILEGES;
} elseif ( $_GET[ 'spsystem' ] == 'bayern' ) {
$conn = new mysqli( 'bayern.streampanel.net', '4Zj53tAofmoh0p1e', '1EFjs9okgpW#4*jqjdt68$kjONd8CBBj', 'yVFDhYBNTaiEJcLg' );
#create user 4Zj53tAofmoh0p1e;
#GRANT SELECT ON yVFDhYBNTaiEJcLg.* TO 4Zj53tAofmoh0p1e@'%' IDENTIFIED BY '1EFjs9okgpW#4*jqjdt68$kjONd8CBBj';
#FLUSH PRIVILEGES;
} elseif ( $_GET[ 'spsystem' ] == 'myron' ) {
$conn = new mysqli( 'myron.streampanel.net', 'LbeG76gldFG7GcBL', 'n4hP*1V^7iJSlezw4kx8nr7I*mihec2p', 'iplxjrqdzejhgzdz' );
#create user LbeG76gldFG7GcBL;
#GRANT SELECT ON iplxjrqdzejhgzdz.* TO LbeG76gldFG7GcBL@'%' IDENTIFIED BY 'n4hP*1V^7iJSlezw4kx8nr7I*mihec2p';
#FLUSH PRIVILEGES;
} elseif ( $_GET[ 'spsystem' ] == 'saurus' ) {
$conn = new mysqli( 'saurus.streampanel.net', 'mK2BqOFyIo8BhZAO', 'rSzguqz1txRU8NwGb6mKP4Qw4r15eE1f', 'nobzoladbyglslbt' );
#create user mK2BqOFyIo8BhZAO;
#GRANT SELECT ON nobzoladbyglslbt.* TO mK2BqOFyIo8BhZAO@'%' IDENTIFIED BY 'rSzguqz1txRU8NwGb6mKP4Qw4r15eE1f';
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
$sql_tracks = "SELECT t.id, t.pathname, t.title, t.artistid FROM (SELECT id, pathname, title, artistid FROM tracks WHERE accountid = '".mysql_real_escape_string($cc_accountid)."' LIMIT 7500) t";
$result_tracks = $conn->query($sql_tracks);
$result_tracks_modal = $conn->query($sql_tracks);
{/php}

<div class="card card-custom">
    <div class="card-header py-3">
        <div class="card-title">
            <h3 class="card-label">{php}echo $result_accounts['title'];{/php}</h3>
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
                echo "
                <tr>";
                    echo "
                    <th class='sp_no_id'>".$SP_LANG[sp_id]."</th>
                    ";
                    echo "
                    <th class='sp_no_cover'>".$SP_LANG[sp_cover]."</th>
                    ";
                    echo "
                    <th class='sp_no_artist'>".$SP_LANG[sp_artist]."</th>
                    ";
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
                $cc_track_artist_utf8 = $cc_track_artist;

                $cc_track_title = str_replace($search_value, $replace_value, $row["title"]);
                $cc_track_title_utf8 = $cc_track_title;

                echo "
                <tr class='sp_id_".$row["id"]."'>";
                    echo "
                    <td class='sp_no_id'>" . $row["id"]. "</td>
                    ";

                    echo "
                    <td class='sp_no_cover'>".$SP_LANG[sp_centovacast_wishbox_nocoveractually]."</td>
                    ";

                    echo "
                    <td>" . $cc_track_artist_utf8 . "</td>
                    ";

                    echo "
                    <td>" . $cc_track_title_utf8 . "</td>
                    ";

                    echo "
                    <td><a href='https://scripts.streampanel.net/cc/history/wishbox.php?
		lang=de
		&spsystem=" . $_GET[ "spsystem" ] . "
		&radioname=" . base64_encode($result_accounts["title"]) . "
		&artist=" . base64_encode($cc_track_artist_utf8) . "
		&title=" . base64_encode($cc_track_title_utf8) . "
		&name=" . base64_encode($cc_username) . "'
		class='btn btn-primary btn-block btn-focus btn-sm' target='_blank' rel='noopener'>".$SP_LANG[sp_centovacast_wishbox_sendrequest]."</a></td>
              " ; echo "</tr>
            " ; } echo "
              </tbody>
            " ; echo "
          </table>
          " ; }
          {/php} </div>
    </div>
    {php}
    $conn->close();
    {/php}