<?php
$Module = $Params['Module'];

$tpl = eZTemplate::factory();
$manager = SystemLogManager();

$tpl->setVariable( 'list', $manager->list() );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:cronjobs/systemlogs.tpl' );
$Result['left_menu'] = "design:parts/cronjob/menu.tpl";
$Result['path'] = array( array( 'url' => '/cronjobs/systemlogs/',
                                'text' => ezpI18n::tr( 'extension/occronjobs', 'System logs' ) ),
                         array( 'url' => false,
                                'text' => 'logs' ) );



?>
