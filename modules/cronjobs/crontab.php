<?php
$Module = $Params['Module'];
$tpl = eZTemplate::factory();
$crontabReader = new CronTabReader( false );
$globalScripts = array();
$scripts = $crontabReader->scripts;


//send variables to template
$tpl->setVariable( 'globalScripts', $globalScripts );
$tpl->setVariable( 'scripts', $scripts );
$tpl->setVariable( 'page_title', ezpI18n::tr( 'extension/occronjobs', 'Crontab list' ) );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:cronjobs/list.tpl' );
$Result['left_menu'] = "design:parts/cronjob/menu.tpl";
$Result['path'] = array( array( 'url' => '/cronjobs/crontab/',
                                'text' => ezpI18n::tr( 'extension/occronjobs', 'Crontab' ) ),
                         array( 'url' => false,
                                'text' => 'list' ) );

?>
