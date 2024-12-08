{php}
set_time_limit(30);
$SP_LANG = $template->getVariable('LANG')->value;
{/php}

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

$cc_accountid = $result_accounts['id'];
$sql_playbackstats_tracks = "SELECT * FROM playbackstats_tracks WHERE accountid = '".mysql_real_escape_string($cc_accountid)."' AND starttime >= '".date('Y')."-07-01 00:00:00' AND endtime <= '".date('Y')."-07-31 23:59:59'";
#SELECT * FROM playbackstats_tracks WHERE accountid = '$cc_accountid' and listeners >= '1' and DATE(starttime) >= DATE(NOW() - INTERVAL 3 MONTH - INTERVAL 3 DAYS)
$result_playbackstats_tracks = $conn->query($sql_playbackstats_tracks);
{/php}

<div class=" card card-custom">

    {include file="modules/servers/centovacast/templates/licensing/partials/card.tpl"}

    <div class="card-body">
        {php}
        // Debug
        #echo $sql_accounts;
        #echo $sql_playbackstats_tracks;

        echo "
        <input type='text' id='SPCustomSearchBox' class='form-control' placeholder='".$SP_LANG[sp_enter_your_search]."' />
        <table class='table table-striped table-bordered table-hover' id='SPDataTable'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th>".$SP_LANG[sp_id]."</th>";
                    echo "<th>".$SP_LANG[sp_start]."</th>";
                    echo "<th>".$SP_LANG[sp_end]."</th>";
                    echo "<th>".$SP_LANG[sp_centovacast_licensingreports_playtime]." (".$SP_LANG[sp_seconds].")</th>";
                    echo "<th>".$SP_LANG[sp_centovacast_licensingreports_artist_title]."</th>";
                    echo "<th>".$SP_LANG[sp_listener]."</th>";
                    echo "</tr>
            </thead>";
            echo "<tbody>";

                $search_value = ['(', ')', 'Ã¤', 'Ã¼', 'Ã¶', 'Ã³', 'ÃÂ', '.mp3', '.aac', 'xxx', 'xxx', 'xxx', 'xxx'];
                $replace_value = ['', '', 'ä', 'ü', 'ö', 'ó', 'ê', '', '', 'xxx', 'xxx', 'xxx', 'xxx'];

                if ($result_playbackstats_tracks->num_rows > 0) {
                // output data of each row
                while($row = $result_playbackstats_tracks->fetch_assoc()) {

                echo "<tr>";
                    echo "<td>" . $row["id"]. "</td>";
                    echo "<td>" . $row["starttime"]. "</td>";
                    echo "<td>" . $row["endtime"] . "</td>";
                    echo "<td>" . $row["duration"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["listeners"] . "</td>";
                    echo "</tr>";

                }}
                echo "</tbody>";
            echo "</table>";
        {/php}
    </div>
</div>

{php}
$conn->close();
{/php}