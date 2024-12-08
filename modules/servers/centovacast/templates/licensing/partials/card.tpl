<div class="card-header py-3">
    <div class="card-title">
        <h3 class="card-label">{lang key="sp_centovacast_licensingreports"} /
            {if $smarty.get.spmonth == "january"}
                {lang key='sp_january'}
            {else if $smarty.get.spmonth == "february"}
                {lang key='sp_february'}
            {else if $smarty.get.spmonth == "march"}
                {lang key='sp_march'}
            {else if $smarty.get.spmonth == "april"}
                {lang key='sp_april'}
            {else if $smarty.get.spmonth == "may"}
                {lang key='sp_may'}
            {else if $smarty.get.spmonth == "june"}
                {lang key='sp_june'}
            {else if $smarty.get.spmonth == "july"}
                {lang key='sp_july'}
            {else if $smarty.get.spmonth == "august"}
                {lang key='sp_august'}
            {else if $smarty.get.spmonth == "september"}
                {lang key='sp_september'}
            {else if $smarty.get.spmonth == "october"}
                {lang key='sp_october'}
            {else if $smarty.get.spmonth == "november"}
                {lang key='sp_november'}
            {else}
                {lang key='sp_december'}
            {/if}
        {if $smarty.get.spyear == "actual"}{$date_year}{/if}
        {if $smarty.get.spyear == "last"}2023{/if}
        </h3>
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
        <a href="
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "january"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=january&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "february"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=february&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "march"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=march&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "april"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=april&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "may"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=may&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "june"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=june&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "july"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=july&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "august"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=august&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "september"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=september&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "october"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=october&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "november"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=november&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "actual" and $smarty.get.spmonth == "december"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=last&amp;spmonth=december&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "january"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=january&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "february"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=february&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "march"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=march&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "april"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=april&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "may"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=may&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "june"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=june&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "july"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=july&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "august"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=august&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "september"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=september&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "october"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=october&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "november"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=november&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
        {if $smarty.get.spyear == "last" and $smarty.get.spmonth == "december"}clientarea.php?action=productdetails&amp;id={$id}&amp;sppage=splr&amp;spyear=actual&amp;spmonth=december&amp;spsystem={$serverdata.name|replace:'.streampanel.net':''}{/if}
            " class="btn btn-light-primary font-weight-bolder">
            <span class="svg-icon svg-icon-md">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <path
                            d="M10.9630156,7.5 L11.0475062,7.5 C11.3043819,7.5 11.5194647,7.69464724 11.5450248,7.95024814 L12,12.5 L15.2480695,14.3560397 C15.403857,14.4450611 15.5,14.6107328 15.5,14.7901613 L15.5,15 C15.5,15.2109164 15.3290185,15.3818979 15.1181021,15.3818979 C15.0841582,15.3818979 15.0503659,15.3773725 15.0176181,15.3684413 L10.3986612,14.1087258 C10.1672824,14.0456225 10.0132986,13.8271186 10.0316926,13.5879956 L10.4644883,7.96165175 C10.4845267,7.70115317 10.7017474,7.5 10.9630156,7.5 Z"
                            fill="#000000" />
                        <path
                            d="M7.38979581,2.8349582 C8.65216735,2.29743306 10.0413491,2 11.5,2 C17.2989899,2 22,6.70101013 22,12.5 C22,18.2989899 17.2989899,23 11.5,23 C5.70101013,23 1,18.2989899 1,12.5 C1,11.5151324 1.13559454,10.5619345 1.38913364,9.65805651 L3.31481075,10.1982117 C3.10672013,10.940064 3,11.7119264 3,12.5 C3,17.1944204 6.80557963,21 11.5,21 C16.1944204,21 20,17.1944204 20,12.5 C20,7.80557963 16.1944204,4 11.5,4 C10.54876,4 9.62236069,4.15592757 8.74872191,4.45446326 L9.93948308,5.87355717 C10.0088058,5.95617272 10.0495583,6.05898805 10.05566,6.16666224 C10.0712834,6.4423623 9.86044965,6.67852665 9.5847496,6.69415008 L4.71777931,6.96995273 C4.66931162,6.97269931 4.62070229,6.96837279 4.57348157,6.95710938 C4.30487471,6.89303938 4.13906482,6.62335149 4.20313482,6.35474463 L5.33163823,1.62361064 C5.35654118,1.51920756 5.41437908,1.4255891 5.49660017,1.35659741 C5.7081375,1.17909652 6.0235153,1.2066885 6.2010162,1.41822583 L7.38979581,2.8349582 Z"
                            fill="#000000" opacity="0.3" />
                    </g>
                </svg>
            </span>{if $smarty.get.spyear == "actual"}{lang key='sp_last_year'}{/if}{if $smarty.get.spyear == "last"}{lang key='sp_actual_year'}{/if}
        </a>
    </div>
</div>