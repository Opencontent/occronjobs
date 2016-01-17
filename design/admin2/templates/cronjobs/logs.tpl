{ezscript_require( array( 'ezjsc::jquery' ) )}
{literal}
<script type="text/javascript">
function refresh(){
    jQuery.ajax({
      url: "{/literal}{'/layout/set/blank/cronjobs/logs'|ezurl('no')}{literal}",
      timeout: 3600 * 1000,
      success: function(data) {          
          jQuery( '#output' ).html( jQuery( '#output', data ).html() ).prop({ scrollTop: $("#output").prop("scrollHeight") });
          //jQuery( '#errors' ).html( jQuery( '#errors', data ).html() ).attr({ scrollTop: $("#errors").attr("scrollHeight") });
      }
    });        
}
jQuery(document).ready(function() {
    //jQuery( '#tabs' ).tabs();
    window.setInterval("refresh()", 20000 );     
});
</script>
<style type="text/css">
    #tabs .ui-tabs-hide{display: none;}
    #tabs .content{padding: 1em;background-color: #000;border-top: 1px solid #CCCCCC; color: #fff; font-size: 1.1em; font-family: monospace;line-height: 1.3em;overflow-y: scroll;overflow-x: hidden;height: 400px;}
    #tabs li.ui-state-active a{background: none repeat scroll 0 0; padding-box #FFFFFF;}
</style>
{/literal}
<div id="tabs">
    {*
    <ul class="tabs float-break">
        <li><a href="#output">{'Output:'|i18n('extension/occronjobs')} </a></li>
        <li><a href="#errors">{'Errors:'|i18n('extension/occronjobs')} </a></li>
    </ul>
    *}
    <div id="output" class="content output">
        {$output|nl2br}
    </div>
    {*
    <div id="errors" class="content errors">
        {$errors|nl2br}
    </div>
    *}
</div>
