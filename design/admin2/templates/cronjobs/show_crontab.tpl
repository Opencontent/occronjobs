<div class="cronjobs-list">
    <div class="context-block">
        <div class="box-header"><div class="box-tc"><div class="box-ml"><div class="box-mr"><div class="box-tl"><div class="box-tr">
            <h1 class="context-title">{$page_title}</h1>
            <div class="header-mainline"></div>
        </div></div></div></div></div></div>
    </div>
    
    
<div class="context-block">
{if is_array($output)}
<pre style="overflow-x: scroll">
{foreach $output as $o}

{$o}

{/foreach}
</pre>
{else}
<p>{$output|nl2br}</p>
{/if}
</div>
	
</div>
