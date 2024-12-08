<!--
Valid element IDs include:

centovacast_hostname, centovacast_servertype, centovacast_sourcetype, centovacast_serverstate, centovacast_sourcestate,
centovacast_ipaddress, centovacast_port, centovacast_username, centovacast_maxclients, centovacast_transferlimit,
centovacast_diskquota, centovacast_mountlimit, centovacast_channels, centovacast_samplerate, centovacast_crossfade,
centovacast_maxbitrate, centovacast_url, centovacast_title, centovacast_email, centovacast_organization,
centovacast_cachedtransfer, centovacast_cacheddiskusage, centovacast_status
-->
<div id="centovacast_details">

    <div class="alert alert-danger" role="alert">
        <h4>{lang key="sp_centovacast_lastnote"}</h4>
        <p>{lang key="sp_centovacast_lastnote_desc"}</p>
        <p>{lang key="sp_centovacast_lastnote_desc2"} <strong><a href="submitticket.php?step=2&deptid=2">{lang key="sp_centovacast_askus"}</a></strong></p>
    </div>

    <div class="card card-custom sp-margin-bottom">
        <div class="card-header py-3">
            <div class="card-title">
                <h3 class="card-label">{lang key="sp_api"}</h3>
            </div>
        </div>
        <div class="card-body">

            <h4>{lang key="sp_centovacast_json"}</h4>
            <pre>https://{$serverdata.hostname}:2199/api.php?xm=server.getstatus&f=json&a[username]={$username}&a[password]={$password}</pre>
            <h4>{lang key="sp_centovacast_xml"}</h4>
            <pre>https://{$serverdata.hostname}:2199/api.php?xm=server.getstatus&f=xml&a[username]={$username}&a[password]={$password}</pre>

            <h4>{lang key="sp_centovacast_text_output"}</h4>
            <!-- Streamserver: Songtitel -->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_titleurl"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-titelausgabe/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/songtitle_shoutcast2.php?url=http://<span id="centovacast_ipaddress"></span>:<span id="centovacast_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_titleurl"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-titelausgabe/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/songtitle_icecast.php?url=http://<span id="centovacast_ipaddress"></span>:<span id="centovacast_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <!-- Streamserver: Mountpint Name -->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_servername"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-streamserver-name/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/servername_shoutcast2.php?url=http://<span id="centovacast11_ipaddress"></span>:<span id="centovacast11_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_servername"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-streamserver-name/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/servername_icecast.php?url=http://<span id="centovacast11_ipaddress"></span>:<span id="centovacast11_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <!-- Streamserver: Songtitel with Mountpint Name -->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_titleurl_with_mountpointname"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-titelausgabe-inklusive-streamserver-name/" target="_blank"
                    rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/songtitle_2_shoutcast2.php?url=http://<span id="centovacast10_ipaddress"></span>:<span id="centovacast10_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_titleurl_with_mountpointname"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-titelausgabe-inklusive-streamserver-name/" target="_blank"
                    rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/songtitle_2_icecast.php?url=http://<span id="centovacast10_ipaddress"></span>:<span id="centovacast10_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <!-- Artist -->
            {if $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_artist"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-artist/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/artist_icecast.php?url=http://<span id="centovacast14_ipaddress"></span>:<span id="centovacast14_port"></span></span></pre>
            {/if}

            <!-- Streamserver: Bitrate -->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_bitrate"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-bitrate/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/bitrate_shoutcast2.php?url=http://<span id="centovacast2_ipaddress"></span>:<span id="centovacast2_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_bitrate"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-bitrate/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/bitrate_icecast.php?url=http://<span id="centovacast2_ipaddress"></span>:<span id="centovacast2_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <!-- Streamserver: Genre -->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_genre"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-genre/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/genre_shoutcast2.php?url=http://<span id="centovacast3_ipaddress"></span>:<span id="centovacast3_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_genre"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-genre/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/genre_icecast.php?url=http://<span id="centovacast3_ipaddress"></span>:<span id="centovacast3_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <!-- Streamserver: Listener -->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_listener"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-aktuelle-zuhoerer-slots/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/listener_shoutcast2.php?url=http://<span id="centovacast4_ipaddress"></span>:<span id="centovacast4_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_listener"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-aktuelle-zuhoerer-slots/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/listener_icecast.php?url=http://<span id="centovacast4_ipaddress"></span>:<span id="centovacast4_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <!-- Streamserver: Listener Peak-->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_listenerpeak"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-aktueller-zuhoerer-peak/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/listenerpeak_shoutcast2.php?url=http://<span id="centovacast5_ipaddress"></span>:<span id="centovacast5_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_listenerpeak"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-aktueller-zuhoerer-peak/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/listenerpeak_icecast.php?url=http://<span id="centovacast5_ipaddress"></span>:<span id="centovacast5_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <!-- Streamserver: Samplerate-->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_samplerate"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-samplerate/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/samplerate_shoutcast2.php?url=http://<span id="centovacast6_ipaddress"></span>:<span id="centovacast6_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_samplerate"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-samplerate/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/samplerate_icecast.php?url=http://<span id="centovacast6_ipaddress"></span>:<span id="centovacast6_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <h4>{lang key="sp_centovacast_cover"}</h4>
            <!-- Streamserver: Cover (small)-->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_cover_small"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-coverabfrage-klein/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://www.shoutcast-tools.com/external/api/cover/shoutcastv2/small.php?url=http://<span id="centovacast7_ipaddress"></span>:<span id="centovacast7_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_cover_small"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-coverabfrage-klein/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://www.shoutcast-tools.com/external/api/cover/icecastkh/small.php?url=http://<span id="centovacast7_ipaddress"></span>:<span id="centovacast7_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <!-- Streamserver: Cover (medium)-->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_cover_medium"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-coverabfrage-mittel/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://www.shoutcast-tools.com/external/api/cover/shoutcastv2/medium.php?url=http://<span id="centovacast8_ipaddress"></span>:<span id="centovacast8_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_cover_medium"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-coverabfrage-mittel/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://www.shoutcast-tools.com/external/api/cover/icecastkh/medium.php?url=http://<span id="centovacast8_ipaddress"></span>:<span id="centovacast8_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <!-- Streamserver: Cover (large)-->
            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_cover_large"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-coverabfrage-gross/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://www.shoutcast-tools.com/external/api/cover/shoutcastv2/large.php?url=http://<span id="centovacast9_ipaddress"></span>:<span id="centovacast9_port"></span></span></pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_cover_large"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-coverabfrage-gross/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://www.shoutcast-tools.com/external/api/cover/icecastkh/large.php?url=http://<span id="centovacast9_ipaddress"></span>:<span id="centovacast9_port"></span></span></pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            <!-- Streamserver: Start / Stop -->
            <h4>{lang key="sp_centovacast_streamserver"}</h4>
            <strong>{lang key="sp_centovacast_streamserver_start"}</strong>
            <pre>https://{$serverdata.hostname}:2199/api.php?xm=server.start&f=json&a[username]={$username}&a[password]={$password}</pre>
            <strong>{lang key="sp_centovacast_streamserver_stop"}</strong>
            <pre>https://{$serverdata.hostname}:2199/api.php?xm=server.stop&f=json&a[username]={$username}&a[password]={$password}</pre>

            <!-- AutoDJ: start / Stop -->
            <h4>{lang key="sp_centovacast_autodj"}</h4>
            <strong>{lang key="sp_centovacast_autodj_start"}</strong>
            <pre>https://{$serverdata.hostname}:2199/api.php?xm=server.switchsource&f=json&a[username]={$username}&a[password]={$password}&a[state]=up</pre>
            <strong>{lang key="sp_centovacast_autodj_stop"}</strong>
            <pre>https://{$serverdata.hostname}:2199/api.php?xm=server.switchsource&f=json&a[username]={$username}&a[password]={$password}&a[state]=down</pre>
            <strong>{lang key="sp_centovacast_autodj_nextsong"}</strong>
            <pre>https://{$serverdata.hostname}:2199/api.php?xm=server.nextsong&f=json&a[username]={$username}&a[password]={$password}</pre>
            <strong>{lang key="sp_centovacast_autodj_reindex"}</strong>
            <pre>https://{$serverdata.hostname}:2199/api.php?xm=server.reindex&f=json&a[username]={$username}&a[password]={$password}</pre>

            <!-- DJ based Outputs -->
            <h4>{lang key="sp_centovacast_dj"}</h4>

            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_dj_whoisonline"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-pruefen-wer-sendet-moderator-oder-autodj/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/djonline_shoutcast2.php?url=http://<span id="centovacast12_ipaddress"></span>:<span id="centovacast12_port"></span>&ctext=%20CustomText</pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_dj_whoisonline"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-pruefen-wer-sendet-moderator-oder-autodj/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/djonline_icecast.php?url=http://<span id="centovacast12_ipaddress"></span>:<span id="centovacast12_port"></span>&ctext=%20CustomText</pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

            {if $moduleParams.configoption1 == "shoutcastv201" or $moduleParams.configoption1 == "shoutcastv202" or $moduleParams.configoption1 == "shoutcast-v1" or $moduleParams.configoption1 == "shoutcast-v2"}
                <strong>{lang key="sp_centovacast_dj_imageoutput"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-dj-moderator-bilder-ausgeben/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/djimage_shoutcast2.php?url=http://<span id="centovacast13_ipaddress"></span>:<span id="centovacast13_port"></span>&cimgpath=https://via.placeholder.com/150?text=</pre>
            {elseif $moduleParams.configoption1 == "icecastv201" or $moduleParams.configoption1 == "icecastv202" or $moduleParams.configoption1 == "icecast-v2" or $moduleParams.configoption1 == "icecast-v2-liquidsoap"}
                <strong>{lang key="sp_centovacast_dj_imageoutput"}</strong> (<a href="https://www.streampanel.net/faq/streamserver-api-beispiel-dj-moderator-bilder-ausgeben/" target="_blank" rel="noopener">{lang key="sp_example"}</a>)
                <pre>https://scripts.streampanel.net/cc/djimage_icecast.php?url=http://<span id="centovacast13_ipaddress"></span>:<span id="centovacast13_port"></span>&cimgpath=https://via.placeholder.com/150?text=</pre>
            {else}
                <div class="sp-red">{lang key="sp_centovacast_error_getting_streamserver"}</div>
            {/if}

        </div>
    </div>

</div>