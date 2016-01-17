<?php
$Module = $Params['Module'];

$tpl = eZTemplate::factory();
$manager = ProcessManager::instance();

$tpl->setVariable( 'output', file_get_contents($manager->getOutputFile()) );
$tpl->setVariable( 'errors', file_get_contents($manager->getErrorFile()) );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:cronjobs/logs.tpl' );
$Result['left_menu'] = "design:parts/cronjob/menu.tpl";
$Result['path'] = array( array( 'url' => '/cronjobs/logs/',
                                'text' => ezpI18n::tr( 'extension/occronjobs', 'Cronjobs' ) ),
                         array( 'url' => false,
                                'text' => 'logs' ) );



?>
