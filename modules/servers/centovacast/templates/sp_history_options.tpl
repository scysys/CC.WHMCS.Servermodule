{php}
$serverhost = $_SERVER['HTTP_HOST'];
$serverurl = $_SERVER[REQUEST_URI];
$saveurl = str_replace('&amp;','&', $serverhost . $serverurl);

if (isset($_POST['submitwishboxoptions']))
{
header("Location: https://".$saveurl."");
}
{/php}

<div class="card card-custom">
    <div class="card-header py-3">
        <div class="card-title">
            <h3 class="card-label">{lang key="sp_centovacast_wishbox_options"}</h3>
        </div>
    </div>
    <div class="card-body">

        <form method="post" action="https://{$smarty.server.HTTP_HOST}{$smarty.server.REQUEST_URI}" role="form">
            <div class="form-group">
                <label for="radionameInput"><strong>{lang key="sp_centovacast_wishbox_radioname"}</strong></label>
                <small id="radionameHelp" class="form-text text-muted">
                    {lang key="sp_centovacast_wishbox_radioname_desc"}
                </small><br />
                <input type="text" class="form-control" name="radioname" value="{$setradioname}" id="radionameInput" aria-describedby="radionameHelp" />
            </div>

            <div class="form-group">
                <input type="checkbox" name="hide_row1" value="1" {if $sethide_row1} checked{/if} class="no-icheck toggle-switch-success" data-size="small" data-on-text="{lang key='sp_yes'}" data-off-text="{lang key='sp_no'}" />
                {lang key="sp_centovacast_wishbox_options_hiderow1"}
            </div>

            <div class="form-group">
                <input type="checkbox" name="hide_row2" value="1" {if $sethide_row2} checked{/if} class="no-icheck toggle-switch-success" data-size="small" data-on-text="{lang key='sp_yes'}" data-off-text="{lang key='sp_no'}" />
                {lang key="sp_centovacast_wishbox_options_hiderow2"}
            </div>

            <div class="form-group">
                <input type="checkbox" name="hide_row3" value="1" {if $sethide_row3} checked{/if} class="no-icheck toggle-switch-success" data-size="small" data-on-text="{lang key='sp_yes'}" data-off-text="{lang key='sp_no'}" />
                {lang key="sp_centovacast_wishbox_options_hiderow3"}
            </div>

            <div class="form-group">
                <input type="checkbox" name="hide_row4" value="1" {if $sethide_row4} checked{/if} class="no-icheck toggle-switch-success" data-size="small" data-on-text="{lang key='sp_yes'}" data-off-text="{lang key='sp_no'}" />
                {lang key="sp_centovacast_wishbox_options_hiderow4"}
            </div>

            <div class="form-group">
                <label for="custom_css"><strong>{lang key="sp_centovacast_wishbox_options_customcss"}</strong></label>
                <small id="custom_cssHelpBlock" class="form-text text-muted">
                    {lang key="sp_centovacast_wishbox_options_customcss_desc"}
                </small><br />
                <textarea class="form-control" name="custom_css" id="custom_css" value="{$setcustom_css}" style="height: 200px;">{$setcustom_css}</textarea>
            </div>

            <div class="form-group">
                <input type="hidden" name="wishbox_url"
                    value='https://scripts.streampanel.net/cc/history/history.php?lang=de&spsystem={$smarty.get.spsystem}&radioname={$setradioname|base64_encode}&name={$username|base64_encode}{if $sethide_row1 == "1"}&css_id=hide{/if}{if $sethide_row2 == "1"}&css_cover=hide{/if}{if $sethide_row3 == "1"}&css_artist=hide{/if}{if $sethide_row4 == "1"}&css_title=hide{/if}&customcss={$setcustom_css|base64_encode}' />
                <input class="btn btn-success btn-block" type="submit" name="submitwishboxoptions" value="{lang key="sp_save"}" />
            </div>
        </form>

        <div class="row">
            <div class="col-sm-6">
                <a href="https://scripts.streampanel.net/cc/history/history_live.php?lang=de&spsystem={$smarty.get.spsystem}&radioname={$setradioname|base64_encode}&name={$username|base64_encode}{if $sethide_row1 == '1'}&css_id=hide{/if}{if $sethide_row2 == '1'}&css_cover=hide{/if}{if $sethide_row3 == '1'}&css_artist=hide{/if}{if $sethide_row4 == '1'}&css_title=hide{/if}&customcss={$setcustom_css|base64_encode}"
                    class="btn btn-primary btn-block" target="_blank" rel="noopener">{lang key="sp_centovacast_wishbox_options_live"}</a>
            </div>
            <div class="col-sm-6">
                <a href="https://scripts.streampanel.net/cc/history/history_generate.php?lang=de&spsystem={$smarty.get.spsystem}&radioname={$setradioname|base64_encode}&name={$username|base64_encode}{if $sethide_row1 == '1'}&css_id=hide{/if}{if $sethide_row2 == '1'}&css_cover=hide{/if}{if $sethide_row3 == '1'}&css_artist=hide{/if}{if $sethide_row4 == '1'}&css_title=hide{/if}&customcss={$setcustom_css|base64_encode}"
                    class="btn btn-primary btn-block" target="_blank" rel="noopener">{lang key="sp_centovacast_wishbox_options_generate"} ({lang key="sp_centovacast_wishbox_options_generate_note"})</a>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <h4>{lang key="sp_centovacast_wishbox_options_address"}</h4>
        <p><small>{lang key="sp_centovacast_wishbox_options_address_desc"}</small></p>
        <pre><code>https://scripts.streampanel.net/cc/history/hid/{$username|base64_encode}.html</code></pre>
    </div>
</div>