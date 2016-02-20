<?php
$Module = $Params['Module'];

$tpl = eZTemplate::factory();
$tpl->setVariable( 'module', $Module );
$http = eZHTTPTool::instance();

if ( $http->hasVariable( 'part' ) )
{
	$part = $http->variable('part');
}
else
{
	$part = '';
}

if( $part == 'global' )
{
	$part = '';
}


$options = eZINI::instance( 'occronjobs.ini' )->variable( 'CronOptions', 'PreOption' );
foreach( $options as $name => $type )
{
	if ( $http->variable( $name, false ) )
	{
		if ( $type == 'boolean' )
			$part = "--$name " . $part;
		else
			$part = " --$name={$http->variable( $name )} " . $part;
	}
}

$lastOptions = eZINI::instance( 'occronjobs.ini' )->variable( 'CronOptions', 'PostOption' );
foreach( $lastOptions as $name => $type )
{
	if ( $http->variable( $name, false ) )
	{		
		$part .= " $name={$http->variable( $name )} ";
	}
}

//$debug =  $http->variable( 'debug', 0 );
//if ( $debug > 0 )
//{
//    $part = '--debug ' . $part;
//}

eZLog::write( $part, 'occrontab.log' );

$manager = OCCronJobProcessManager::instance();
$manager->cleanOutputFile();
$manager->cleanErrorFile();
$manager->addScript( "runcronjobs.php", $part );
$manager->execAll();

eZExecution::cleanExit();

?>
