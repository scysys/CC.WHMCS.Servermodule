<?php

$radioname = htmlspecialchars($_GET['radioname']);
$artist = htmlspecialchars($_GET['artist']);
$title = htmlspecialchars($_GET['title']);
$lang = htmlspecialchars($_GET['lang']);
$name = htmlspecialchars($_GET['name']);

?>

<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <title><?php echo base64_decode($radioname); ?>: <?php if ('de' == $lang) {
    echo 'Wunschbox';
} else {
    echo 'Wish box';
} ?>
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

<?php

if ('bud' == $_GET['spsystem']) {
    echo "<script language='javascript' type='text/javascript' src='https://bud.streampanel.net:2199/system/request.js'></script>";
}

if ('bayern' == $_GET['spsystem']) {
  echo "<script language='javascript' type='text/javascript' src='https://bayern.streampanel.net:2199/system/request.js'></script>";
}

if ('saurus' == $_GET['spsystem']) {
  echo "<script language='javascript' type='text/javascript' src='https://saurus.streampanel.net:2199/system/request.js'></script>";
}

if ('myron' == $_GET['spsystem']) {
  echo "<script language='javascript' type='text/javascript' src='https://myron.streampanel.net:2199/system/request.js'></script>";
}

?>

</head>

<body>

  <?php

$search_value = ['(', ')', 'Ã¤', 'Ã¼', 'Ã¶', 'Ã³', 'ÃÂ', '.mp3', '.aac', 'xxx', 'xxx', 'xxx', 'xxx'];
$replace_value = ['', '', 'ä', 'ü', 'ö', 'ó', 'ê', '', '', 'xxx', 'xxx', 'xxx', 'xxx'];
$title2 = base64_decode($title);

?>

  <div class="d-flex justify-content-center">
    <div class="m-portlet">
      <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
          <div class="m-portlet__head-title"> <span class="m-portlet__head-icon"> <i class="fas fa-headphones"></i> </span>
            <h3 class="m-portlet__head-text"> <?php echo base64_decode($radioname); ?>: <?php if ('de' == $lang) {
    echo 'Wunschbox';
} else {
    echo 'Wish box';
} ?>
            </h3>
          </div>
        </div>
      </div>
      <div class="m-portlet__body">
        <form class='cc_request_form' data-username='<?php echo base64_decode($name); ?>'>
          <div data-type='result'></div>
          <input type='text' class='form-control' name='request[artist]' placeholder='Artist / Künstler' value='<?php echo base64_decode($artist); ?>' />
          <input type='text' class='form-control' name='request[title]' placeholder='Musiktitel' value='<?php echo str_replace($search_value, $replace_value, $title2); ?>' />
          <input type='hidden' name='request[dedication]' />
          <input type='hidden' name='request[sender]' />
          <input type='hidden' class='form-control' name='request[email]'
            placeholder='<?php if ('de' == $lang) {
    echo 'Ihre E-Mail-Adresse';
} else {
    echo 'Your E-Mail-Address';
} ?>'
            value='noreply@streampanel.net' />
          <input type='button' class='btn btn-primary btn-block sp_btn_custom'
            value='<?php if ('de' == $lang) {
    echo 'Musikwunsch abschicken';
} else {
    echo 'Submit music request';
} ?>'
            data-type='submit' />
        </form>
      </div>
      <div class="m-portlet__foot">
        <div class="row align-items-center">
          <div class="col-lg-6 m--valign-middle"> </div>
          <div class="col-lg-6 m--align-right">
            <button type='button' class='btn btn-danger btn-block' data-dismiss='modal' onclick='close_window();return false;'>
              <?php if ('de' == $lang) {
    echo 'Fenster schließen';
} else {
    echo 'Close Window';
} ?>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    function close_window() {
      window.close();
    }
  </script>
</body>

</html>