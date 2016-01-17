<?php

$Module = $Params['Module'];
$http = eZHTTPTool::instance();
$tpl = eZTemplate::factory();
$crontabReader = new CronTabReader();
$globalScripts = array();
$output = $crontabReader->output( $http->hasGetVariable( 'full' ) );

$tpl->setVariable( 'output', $output );
$tpl->setVariable( 'page_title', ezpI18n::tr( 'extension/occronjobs', 'Crontab' ) );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:cronjobs/show_crontab.tpl' );
$Result['left_menu'] = "design:parts/cronjob/menu.tpl";
$Result['path'] = array( array( 'url' => '/cronjobs/crontab/',
                                'text' => ezpI18n::tr( 'extension/occronjobs', 'Crontab' ) ),
                         array( 'url' => false,
                                'text' => 'crontab' ) );

?>
