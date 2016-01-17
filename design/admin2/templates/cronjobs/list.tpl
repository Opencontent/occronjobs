{literal}
<script type="text/javascript">
function launch(part) {
    var partID = part.split(' ').join('_');    
    jQuery('#loader_'+partID).fadeIn("slow"); 
    jQuery("#result_"+partID).html('');
    var debug = jQuery("#useDebug:checked" ).length;
	var options = '';
	jQuery(".cron-option" ).each( function(){		
		if ($(this).hasClass( 'boolean' )) {
			if ( $(this).is(':checked') ){
				options += '&' + $(this).attr( 'name' ) + '=1';
			}
		}else{
			if ( $(this).val() !== '' ){
				options += '&' + $(this).attr( 'name' ) + '=' + $(this).val();
			}
		}
	});
	console.log(options);
    jQuery.ajax({
      url: "{/literal}{'/cronjobs/launch'|ezurl('no')}{literal}",
      type: "GET",
      data: "part="+part+options,
      timeout: 3600 * 1000,
      context: document.body,
      404: function() {
          alert('Page not found');
          window.clearInterval( refreshTimer );
      },
      error: function() { 
          alert('Cronjob "'+part+'": error'); 
      },
      success: function() {
          jQuery('#loader_'+partID).fadeOut("slow");
          jQuery("#result_"+partID).append('Success');
          window.clearInterval( refreshTimer );
          refresh();
      }
    });
}
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
var refreshTimer = null;
$(document).ajaxStart(function(){
    refreshTimer = window.setInterval("refresh()", 2000 );
});

$(document).ready(function(){    
	var sticky_navigation_offset_top = $('#console').offset().top;
    var sticky_navigation_offset_left = $('#console').offset().left;
    var sticky_navigation_width = $('#console').css( 'width' );
     
    // our function that decides weather the navigation bar should have "fixed" css position or not.
    var sticky_navigation = function(){
        var scroll_top = $(window).scrollTop(); // our current vertical position from the top
         
        // if we've scrolled more than the navigation, change its position to fixed to stick to top,
        // otherwise change it back to relative
        if (scroll_top > sticky_navigation_offset_top) {
            $('#console').css({ 'position': 'fixed', 'top': 0, 'width': sticky_navigation_width, 'left': sticky_navigation_offset_left });
        } else {
            $('#console').css({ 'position': 'relative', 'width': sticky_navigation_width, 'left': 'auto' });
        }  
    };
     
    // run our function on load
    sticky_navigation();
     
    // and run it again every time you scroll
    $(window).scroll(function() {
         sticky_navigation();
    });
});

</script>
{/literal}

<div class="cronjobs-list">
	<div class="left-column">
		<div class="context-block">
			<div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
			    <h1 class="context-title">{$page_title}</h1>
			    <div class="header-mainline">
					{def $options = ezini( 'CronOptions', 'PreOption', 'occronjobs.ini' )}
					{foreach $options as $optionName => $optionType}
						{switch match=$optionType}
							{case match='boolean'}
								<p><strong>--{$optionName}</strong>&nbsp;<input name={$optionName} class="cron-option boolean" type="checkbox" value="1" /></p>
							{/case}
							{case match='date'}
								<p><strong>--{$optionName}</strong>&nbsp;<input name={$optionName} class="cron-option pickcalendar" type="text" value="" /></p>
							{/case}
							{case}
								<p><strong>--{$optionName}</strong>&nbsp;<input name={$optionName} class="cron-option" type="text" value="" /></p>
							{/case}
						{/switch}
					{/foreach}
                    {def $options = ezini( 'CronOptions', 'PostOption', 'occronjobs.ini' )}
					{foreach $options as $optionName => $optionType}
						{switch match=$optionType}
							{case match='boolean'}
								<p><strong>{$optionName}</strong>&nbsp;<input name={$optionName} class="cron-option boolean" type="checkbox" value="1" /></p>
							{/case}
							{case match='date'}
								<p><strong>{$optionName}</strong>&nbsp;<input name={$optionName} class="cron-option pickcalendar" type="text" value="" /></p>
							{/case}
							{case}
								<p><strong>{$optionName}</strong>&nbsp;<input name={$optionName} class="cron-option" type="text" value="" /></p>
							{/case}
						{/switch}
					{/foreach}
                    
                </div>
			</div></div></div></div></div></div>
		</div>
		
		
		<div class="context-block">
			
			<div class="box-ml"><div class="box-mr"><div class="box-content">
				{if $globalScripts|count|gt(0)}
					<h3><a href="#" onclick="launch('global');return false;">Global scripts</a></h3> <img src={"ajax-loader.gif"|ezimage} id="loader_global" width="32" height="32" />
					<div class="cronjob-result" id="result_global"></div>
					<div class="clear"></div>
					<ul>
					{foreach $globalScripts as $script}
						<li>{$script}</li>
					{/foreach}
					</ul>
				{/if}
				
				{foreach $scripts as $groupName => $groupScripts}
					<h3><a href="#" onclick="launch('{$groupName}');return false;">{$groupName}</a></h3>  <img src={"ajax-loader.gif"|ezimage} id="loader_{$groupName|explode(' ')|implode('_')}" width="32" height="32" /> 
					<div class="cronjob-result" id="result_{$groupName|explode(' ')|implode('_')}"></div>
					<div class="clear"></div>
					<ul>
					{foreach $groupScripts as $script}
						<li>{$script}</li>
					{/foreach}
					</ul>
				{/foreach}
			</div></div></div>
			
		</div>
	</div>
	<div class="right-column" id="console">		
		<div id="output" class="content output" style="padding: 1em;background-color: #000;border-top: 1px solid #CCCCCC; color: #fff; font-size: 1.1em; font-family: monospace;line-height: 1.3em;overflow-y: scroll;overflow-x: hidden;height: 400px;"></div>
	    <div class="button-right">
            <p class="versions"><a href={'logicalogs/download?file=var/log/process_output.log'|ezurl}>Download output</a></p>
        </div>
    </div>
</div>

{ezscript(array( 'ui-core.js', 'ui-widgets.js', 'ui-datepicker-it.js' ) )}
<script type="text/javascript">
{literal}
$(document).ready(function(){    
    
	$( ".pickcalendar" ).datepicker({        
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd/mm/yy",
        numberOfMonths: 1
    });
});
{/literal}
</script>
