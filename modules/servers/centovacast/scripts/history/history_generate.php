<?php
include('top-cache.php');

set_time_limit(30);

$radioname = htmlspecialchars( $_GET[ "radioname" ] );
$lang = htmlspecialchars( $_GET[ "lang" ] );
$cc_username = base64_decode( ( $_GET[ "name" ] ) );

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo base64_decode($radioname) ?>:
<?php if ($lang == "de") { echo "Wunschbox"; } else { echo "Wish box"; } ?>
</title>

<!--begin::Global Theme Styles -->
<link href="https://login.streampanel.net/templates/universal/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
<link href="https://login.streampanel.net/templates/universal/assets/global/base/style.bundle.css" rel="stylesheet" type="text/css" />

<!--begin::Favicons -->
<link rel="shortcut icon" href="https://cassets.streampanel.cloud/favicons/favicon.png">
<link rel="icon" type="image/png" href="https://cassets.streampanel.cloud/favicons/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="https://cassets.streampanel.cloud/favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="https://cassets.streampanel.cloud/favicons/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="https://cassets.streampanel.cloud/favicons/favicon-160x160.png" sizes="160x160">
<link rel="icon" type="image/png" href="https://cassets.streampanel.cloud/favicons/favicon-192x192.png" sizes="192x192">
<link rel="apple-touch-icon" sizes="57x57" href="https://cassets.streampanel.cloud/favicons/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="https://cassets.streampanel.cloud/favicons/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="https://cassets.streampanel.cloud/favicons/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="https://cassets.streampanel.cloud/favicons/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="https://cassets.streampanel.cloud/favicons/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="https://cassets.streampanel.cloud/favicons/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="https://cassets.streampanel.cloud/favicons/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="https://cassets.streampanel.cloud/favicons/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="https://cassets.streampanel.cloud/favicons/apple-touch-icon-180x180.png">
<!--end::Favicons --> 

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --> 
<!-- WARNING: Respond.js doesn't work if you view the page via file:// --> 
<!--[if lt IE 9]>
		  <script src="https://login.streampanel.net/templates/universal/assets/global/plugins/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://login.streampanel.net/templates/universal/assets/global/plugins/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

<link href="https://cassets.streampanel.cloud/fonts/aller/style.css" rel="stylesheet" type="text/css" />

<!--begin:: JS Script --> 
<script src="https://login.streampanel.net/templates/universal/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script> 
<script src="https://login.streampanel.net/templates/universal/assets/base/scripts.bundle.js" type="text/javascript"></script> 
<!--end:: JS Script -->

<style type="text/css">
.dt-buttons.btn-group {
    display: none;
}
body {
    font-family: aller, sans-serif !important;
    font-size: 1.1rem;
    font-weight: 400;
}
.m-portlet.m-portlet--mobile.m-portlet--rounded {
    background-color: transparent;
}
<?php 

// css_id
if ( $_GET[ 'css_id' ] == 'hide' and $_GET[ 'css_cover' ] == 'hide' and $_GET[ 'css_artist' ] == 'hide' ) {
echo ".sp_no_id { display: none; } ";
echo ".sp_no_cover { display: none; } ";
echo ".sp_no_artist { display: none; } ";
}
elseif ( $_GET[ 'css_id' ] == 'hide' and $_GET[ 'css_cover' ] == 'hide' and $_GET[ 'css_title' ] == 'hide' ) {
echo ".sp_no_id { display: none; } ";
echo ".sp_no_cover { display: none; } ";
echo ".sp_no_title { display: none; } ";
}
elseif ( $_GET[ 'css_cover' ] == 'hide' and $_GET[ 'css_artist' ] == 'hide') {
echo ".sp_no_cover { display: none; } ";
echo ".sp_no_artist { display: none; } ";
}
elseif ( $_GET[ 'css_cover' ] == 'hide' and $_GET[ 'css_title' ] == 'hide') {
echo ".sp_no_cover { display: none; } ";
echo ".sp_no_title { display: none; } ";
}
elseif ( $_GET[ 'css_id' ] == 'hide' and $_GET[ 'css_cover' ] == 'hide' ) {
echo ".sp_no_id { display: none; } ";
echo ".sp_no_cover { display: none; } ";
}
elseif ( $_GET[ 'css_id' ] == 'hide' and $_GET[ 'css_artist' ] == 'hide' ) {
echo ".sp_no_id { display: none; } ";
echo ".sp_no_artist { display: none; } ";
}
elseif ( $_GET[ 'css_id' ] == 'hide' and $_GET[ 'css_title' ] == 'hide' ) {
echo ".sp_no_id { display: none; } ";
echo ".sp_no_title { display: none; } ";
}
elseif ( $_GET[ 'css_id' ] == 'hide' ) {
echo ".sp_no_id { display: none; } ";
}
elseif ( $_GET[ 'css_cover' ] == 'hide' ) {
echo ".sp_no_cover { display: none; } ";
}
elseif ( $_GET[ 'css_artist' ] == 'hide' ) {
echo ".sp_no_artist { display: none; } ";
}
elseif ( $_GET[ 'css_title' ] == 'hide' ) {
echo ".sp_no_title { display: none; } ";
}

?>
</style>

<!-- Custom Wishbox CSS -->
<style type="text/css">
<?php
$getCustomCSS = str_replace(' ', '+', $_GET[ 'customcss' ]);
echo base64_decode($getCustomCSS);
?>
</style>

</head>
<body>
<?php
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
if ( $conn->connect_error ) {
  die( "Connection failed: " . $conn->connect_error );
}

$sql_accounts = "SELECT id, title FROM accounts WHERE username = '$cc_username' LIMIT 1";
$query_accounts = mysqli_query( $conn, $sql_accounts );
$result_accounts = mysqli_fetch_assoc( $query_accounts );

#$sql_tracks = "SELECT t.id, t.pathname, t.title, t.artistid, a.name FROM (SELECT id, pathname, title, artistid FROM tracks WHERE accountid = '$cc_accountid' LIMIT 5) t, (SELECT name FROM track_artists WHERE accountid = '$cc_accountid' LIMIT 5) a";
#$sql_track_artists = "SELECT a.name FROM (SELECT name FROM track_artists WHERE id = '7992' LIMIT 5) t";
#$result_track_artists = $conn->query($sql_track_artists);

$cc_accountid = $result_accounts[ 'id' ];
$sql_tracks = "SELECT t.id, t.pathname, t.title, t.artistid FROM (SELECT id, pathname, title, artistid FROM tracks WHERE accountid = '$cc_accountid' LIMIT 1000) t";
$result_tracks = $conn->query( $sql_tracks );
$result_tracks_modal = $conn->query( $sql_tracks );
?>
<div class="m-portlet m-portlet--mobile m-portlet--rounded">
  <div class="m-portlet__head">
    <div class="m-portlet__head-caption">
      <div class="m-portlet__head-title">
        <h3 class="m-portlet__head-text"> <?php echo $result_accounts['title'];?>: Wunschbox </h3>
      </div>
    </div>
  </div>
  <div class="m-portlet__body"> 
    <!--begin: Datatable -->
    <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
      <div class="row">
        <div class="col-sm-12">
          <?php
          // Debug
          #echo $sql_accounts;
          #echo $sql_tracks;

          echo "<table id='SPAutomaticWishbox' class='table table-striped table-bordered table-checkable dataTable no-footer dtr-inline'>";
          echo "<thead class='sp_thead_color'>";
          echo "<tr>";
          echo "<th class='sp_no_id'>Support ID</th>";
          echo "<th class='sp_no_cover'>Cover</th>";
          echo "<th class='sp_no_artist'>Artist</th>";
          echo "<th class='sp_no_title'>Title</th>";
          echo "<th class='sp_no_action'>Aktion</th>";
          //echo "<tr>"; ??
          echo "</thead>";
          echo "<tbody>";

          $search_value = ['(', ')', 'Ã¤', 'Ã¼', 'Ã¶', 'Ã³', 'ÃÂ', '.mp3', '.aac', 'xxx', 'xxx', 'xxx', 'xxx'];
          $replace_value = ['', '', 'ä', 'ü', 'ö', 'ó', 'ê', '', '', 'xxx', 'xxx', 'xxx', 'xxx'];

          if ( $result_tracks->num_rows > 0 ) {
            // output data of each row
            while ( $row = $result_tracks->fetch_assoc() ) {

              // Get Artist Name
              $sql_track_artists = "SELECT a.name FROM (SELECT name FROM track_artists WHERE id = '" . $row[ "artistid" ] . "' LIMIT 1) a";
              $query_track_artists = mysqli_query( $conn, $sql_track_artists );
              $result_track_artists = mysqli_fetch_assoc( $query_track_artists );
              
              $cc_track_artist = $result_track_artists['name'];
              $cc_track_artist_utf8 = utf8_encode($cc_track_artist);
            
              $cc_track_title = str_replace($search_value, $replace_value, $row["title"]);
              $cc_track_title_utf8 = utf8_encode($cc_track_title);
              
              echo "<tr class='sp_row_color sp_id_".$row[ "id" ]."'>";
              echo "<td class='sp_no_id'>" . $row[ "id" ] . "</td>";
              
              $cover_small_output = file_get_contents("https://cover.streampanel.net/cover-api/sp/track.php?title=" . str_replace(['+', '%26apos%3B', '%20%20'], ['%20', '%27', '%20'], urlencode($cc_track_artist_utf8 . " - " . $cc_track_title_utf8)) . "&size=small&urlonly=yes");

              if(empty($cover_small_output)){
                echo "<td class='sp_no_cover'><img src='https://www.shoutcast-tools.de/component/shoutcast/images/icons/nocover100.png' loading='lazy' class='sp_wishbox_cover' width='64px' height='64px' /></td>";
              } else {
                echo "<td class='sp_no_cover'><img src='".$cover_small_output."' alt='" . $cc_track_artist_utf8 . " - " . $cc_track_title_utf8 . "' loading='lazy' class='sp_wishbox_cover' width='64px' height='64px' /></td>";
              }
                            
              echo "<td class='sp_no_artist'>" . $cc_track_artist_utf8 . "</td>";
              
              echo "<td class='sp_no_title'>" . $cc_track_title_utf8 . "</td>";
              
              echo "<td class='sp_no_action'>
		<a href='https://scripts.streampanel.net/cc/history/wishbox.php?
		lang=de
		&spsystem=" . $_GET[ "spsystem" ] . "
		&radioname=" . base64_encode( $result_accounts[ 'title' ] ) . "
		&artist=" . base64_encode( $cc_track_artist_utf8 ) . "
		&title=" . base64_encode( $cc_track_title_utf8 ) . "
		&name=" . base64_encode( $cc_username ) . "
		' class='btn btn-primary btn-block btn-focus sp_btn_custom' target='_blank'>Titel jetzt wünschen</a>
		</td>";
              echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";

          } else {
            echo "0 results";
            echo "</tbody>";
            echo "</table>";
          }

          echo "<div class='modal fade' id='m_modal_website_integration' tabindex='-1' role='dialog' aria-hidden='true'>
<div class='modal-dialog modal-dialog-centered' role='document'>
<div class='modal-content'>
<div class='modal-body'>
<pre>fff</pre>
</div>
</div>
</div>
</div>";

          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$conn->close();
?>
<script src="https://login.streampanel.net/templates/universal/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script> 
<script src="https://login.streampanel.net/templates/universal/assets/custom/crud/datatables/extensions/buttons.js" type="text/javascript"></script> 
<script type="text/javascript">
$('#SPAutomaticWishbox').dataTable({
	pagingType: "simple_numbers",
	order: [[ 2, 'asc' ]],
	dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
	iDisplayLength: 10,
	language: {
		search: "",
		searchPlaceholder: "<?php if ($lang == "de") { echo "Suche nach..."; } else { echo "Search for..."; } ?>",
		emptyTable: "<?php if ($lang == "de") { echo "Es wurden keine Musiktitel gefunden."; } else { echo "No songs were found."; } ?>",
		info: "<?php if ($lang == "de") { echo "Zeige"; } else { echo "Show"; } ?> _START_ <?php if ($lang == "de") { echo "bis"; } else { echo "to"; } ?> _END_ <?php if ($lang == "de") { echo "von"; } else { echo "of"; } ?> _TOTAL_ <?php if ($lang == "de") { echo "Einträge"; } else { echo "entries"; } ?>",
		infoEmpty: "<?php if ($lang == "de") { echo "Zeige 0 bis 0 von 0 Einträgen"; } else { echo "Showing 0 to 0 of 0 entries"; } ?>",
		loadingRecords: "<?php if ($lang == "de") { echo "Wird geladen..."; } else { echo "Loading..."; } ?>",
		processing: "<?php if ($lang == "de") { echo "Wird bearbeitet..."; } else { echo "Processing..."; } ?>",
		zeroRecords: "<?php if ($lang == "de") { echo "Es wurden keine Einträge gefunden"; } else { echo "No entries have been found"; } ?>",
		paginate: {
			"first": "<?php if ($lang == "de") { echo "Erste"; } else { echo "First"; } ?>",
			"last": "<?php if ($lang == "de") { echo "Letzte"; } else { echo "Last"; } ?>",
			"next": "<?php if ($lang == "de") { echo "Weiter"; } else { echo "Next"; } ?>",
			"previous": "<?php if ($lang == "de") { echo "Zurück"; } else { echo "Previous"; } ?>"
		},
		lengthMenu: '<?php if ($lang == "de") { echo "Zeige"; } else { echo "Show"; } ?> <select> '+
		'<option value="10">10</option>'+
		'<option value="20">20</option>'+
		'<option value="30">30</option>'+
		'<option value="40">40</option>'+
		'<option value="50">50</option>'+
		'<option value="100">100</option>'+
		'<option value="250">250</option>'+
		'<option value="500">500</option>'+
		'<option value="-1">All</option>'+
		'</select> <?php if ($lang == "de") { echo "Einträge"; } else { echo "entries"; } ?>',
	},
  drawCallback: function () {
	    $('#SPAutomaticWishbox_paginate li.paginate_button.page-item.previous.disabled').addClass("active");
	    $('#SPAutomaticWishbox_paginate li.paginate_button.page-item.previous').addClass("active");
	    $('#SPAutomaticWishbox_paginate li.paginate_button.page-item.next').addClass("active");
	}
});
</script> 

<script type="text/javascript">
$(document).ready(function () {
   $('img').each(function () {
       if($(this).attr('src')=="") {
          $(this).attr('src', 'https://cover.streampanel.net/cover-api/images/nocover100.jpg');
   }})});
</script>

<!-- begin::Page Loader --> 
<script>
	$(window).on('load', function() {
		$('body').removeClass('m-page--loading');         
	});
</script> 
<!-- end::Page Loader -->

</body>
</html>

<?php include('bottom-cache.php');?>
