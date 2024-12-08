{php}
$serverhost = $_SERVER['HTTP_HOST'];
$serverurl = $_SERVER[REQUEST_URI];
$saveurl = str_replace('&amp;','&', $serverhost . $serverurl);

if (isset($_POST['submitplayer02options']))
{
header("Location: https://".$saveurl."");
}
{/php}

<div class="card card-custom">
    <div class="card-header py-3">
        <div class="card-title">
            <h3 class="card-label">{lang key="sp_centovacast_player_options"}</h3>
        </div>
    </div>
    <div class="card-body">

        <form method="post" action="https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" role="form">

            <div class="form-group">
                <label for="radionameInput"><strong>{lang key="sp_centovacast_player_radioname"}</strong></label>
                <input type="text" class="form-control" id="radionameInput" aria-describedby="radionameHelp" name="radioname" value="{$setradioname}" />
                <small id="radionameHelp" class="form-text text-muted">{lang key="sp_centovacast_player_radioname_desc"}</small>
            </div>

            <div class="form-group">
                <label for="typeInput"><strong>{lang key="sp_centovacast_player_type"}</strong></label>
                <select class="form-control" id="typeInput" aria-describedby="typeHelp" name="type" value="{$settype}">
                    <option {if $settype == "shoutcast"}selected="selected" {/if}>shoutcast</option>
                    <option {if $settype == "icecastkh"}selected="selected" {/if}>icecastkh</option>
                    <option {if $settype == "icecastv2"}selected="selected" {/if}>icecastv2</option>
                </select>
                <small id="typeHelp" class="form-text text-muted">{lang key="sp_centovacast_player_type_desc"}</small>
            </div>

            <div class="form-group">
                <label for="mpnumberInput"><strong>{lang key="sp_centovacast_player_mpnumber"}</strong></label>
                <input type="number" class="form-control" id="mpnumberInput" aria-describedby="mpnumberHelp" name="mpnumber" value="{$setmpnumber}" />
                <small id="mpnumberHelp" class="form-text text-muted">{lang key="sp_centovacast_player_mpnumber_desc"}</small>
            </div>

            <div class="form-group">
                <label for="playerurlInput"><strong>{lang key="sp_centovacast_player_radiourl"}</strong></label>
                <input type="url" class="form-control" id="playerurlInput" aria-describedby="playerurlHelp" name="playerurl" value="{$setplayerurl}" />
                <small id="playerurlHelp" class="form-text text-muted">{lang key="sp_centovacast_player_radiourl_desc"}<br /><br />
                    <strong>SHOUTcast V2 {lang key="sp_example"}:</strong> https://<font color="red">SYSTEMNAME</font>.streampanel.cloud/<font color="red">CENTOVA-USERNAME</font>?mp=/stream<br />
                    <strong>Icecast V2 {lang key="sp_example"}:</strong> https://<font color="red">SYSTEMNAME</font>.streampanel.cloud:<font color="red">PORT</font>/stream<br /></small>
            </div>

            <div class="form-group">
                <label for="defaultcoverInput"><strong>{lang key="sp_centovacast_player_coverurl"}</strong></label>
                <input type="url" class="form-control" id="defaultcoverInput" aria-describedby="defaultcoverHelp" name="defaultcover" value="{$setdefaultcover}" />
                <small id="defaultcoverHelp" class="form-text text-muted">{lang key="sp_centovacast_player_coverurl_desc"}</small>
            </div>

            <div class="form-group">
                <label for="backgroundurlInput"><strong>{lang key="sp_centovacast_player_backgroundurl"}</strong></label>
                <input type="url" class="form-control" id="backgroundurlInput" aria-describedby="backgroundurlHelp" name="backgroundurl" value="{$setbackgroundurl}" />
                <small id="backgroundurlHelp" class="form-text text-muted">{lang key="sp_centovacast_player_backgroundurl_desc"}</small>
            </div>

            <!--<div class="form-group">
                <input type="checkbox" name="lyrics" value="1" {if $setlyrics} checked{/if} class="no-icheck toggle-switch-success" data-size="small" data-on-text="{lang key='yes'}" data-off-text="{lang key='no'}" />
                {$LANG.streampanel_player_lyrics}
            </div>

            <div class="form-group">
                <input type="checkbox" name="history" value="1" {if $sethistory} checked{/if} class="no-icheck toggle-switch-success" data-size="small" data-on-text="{lang key='yes'}" data-off-text="{lang key='no'}" />
                {lang key="sp_centovacast_player_history"}
            </div>-->

            <div class="form-group">
                <input class="btn btn-success btn-block" type="submit" name="submitplayer02options" value="{lang key="sp_save"}" />
            </div>

        </form>

        <a href="https://scripts.streampanel.net/cc/player/player02_generate.php?lang=de&servertype={$settype}&radioname={$setradioname|base64_encode}&mountpointnumber={$setmpnumber}&username={$username|base64_encode}&userid={$userid}{if $setlyrics == '1'}&showlyrics=true{else}&showlyrics=false{/if}{if $sethistory == '1'}&showhistory=true{else}&showhistory=false{/if}&playerurl={$setplayerurl|base64_encode}&defaultcover={$setdefaultcover|base64_encode}&backgroundurl={$setbackgroundurl|base64_encode}"
            class="btn btn-primary btn-block" target="_blank" rel="noopener">{lang key="sp_centovacast_player_generate"} ({lang key="sp_centovacast_player_generate_note"})</a>

    </div>
    <div class="card-footer">
        <h4>{lang key="sp_centovacast_player_address"}</h4>
        <p><small>{lang key="sp_centovacast_player_address_desc"}</small></p>
        <pre><code>https://scripts.streampanel.net/cc/player/cache/{$username|base64_encode|replace:"=":""}_02.html</code></pre>
    </div>
</div>