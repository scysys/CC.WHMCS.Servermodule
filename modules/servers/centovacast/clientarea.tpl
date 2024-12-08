<div class="sp-margin-bottom">
    <h3>{lang key='sp_product_credentials'}</h3>
    <h6>{lang key='sp_host'}</h6>
    <p>https://{$serverdata.hostname}:2199/</p>
    <h6>{lang key='sp_username'}</h6>
    <p>{$username}</p>
    <h6>{lang key='sp_password'}</h6>
    <p>{$password}</p>
</div>

<form method="post" action="https://{$serverdata.hostname}:2199/login/index.php" target="_blank" role="form">
    <input type="hidden" name="username" value="{$username}">
    <input type="hidden" name="password" value="{$password}">
    <input class="btn btn-primary btn-block" type="submit" name="login" value="{lang key='sp_centovacast_login'}">
</form>