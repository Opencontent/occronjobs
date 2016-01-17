<?php
$Module = $Params['Module'];

$tpl = eZTemplate::factory();
$http = eZHTTPTool::instance();
$manager = ProcessManager::instance();
$outputs = array();

if ( $http->hasVariable( 'log_output' ) )
{
	$manager->cleanOutputFile();
	$outputs[] = ezpI18n::tr( 'extension/occronjobs', 'Output file cleared.' );
}
if ( $http->hasVariable( 'log_error' ) )
{
	$manager->cleanErrorFile();
	$outputs[] = ezpI18n::tr( 'extension/occronjobs', 'Error file cleared.' );
}

$tpl->setVariable( 'outputs', $outputs );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:cronjobs/clear.tpl' );
$Result['left_menu'] = "design:parts/cronjob/menu.tpl";
$Result['path'] = array( array( 'url' => '/cronjobs/clear/',
                                'text' => ezpI18n::tr( 'extension/occronjobs', 'Cronjobs' ) ),
                         array( 'url' => false,
                                'text' => 'clear' ) );

?>
