<?php
$Module = $Params['Module'];

$tpl = eZTemplate::factory();

$ocCronjobsIni = eZINI::instance( 'occronjobs.ini' );
$forbiddenParts = $ocCronjobsIni->variable( 'Forbidden', 'Parts' );

$ini = eZINI::instance( 'cronjob.ini' );
$globalScripts = array();
if( !in_array('global',$forbiddenParts)  )
{
    $globalScripts = $ini->variable( 'CronjobSettings', 'Scripts' );
}

$scripts = array();
foreach($ini->groups() as $groupName => $group)
{
	
	if( preg_match('/^CronjobPart-(.*)/i', $groupName, $matches ) )
    {
		if( !in_array($matches[1],$forbiddenParts)  ) {
			$scripts[$matches[1]] = $ini->variable( $groupName, 'Scripts' );
		}
	}
}

$tpl->setVariable( 'globalScripts', $globalScripts );
$tpl->setVariable( 'scripts', $scripts );
$tpl->setVariable( 'page_title', ezpI18n::tr( 'extension/occronjobs', 'Active eZ cronjobs' ) );

$Result = array();
$Result['content'] = $tpl->fetch( 'design:cronjobs/list.tpl' );
$Result['left_menu'] = "design:parts/cronjob/menu.tpl";
$Result['path'] = array( array( 'url' => '/cronjobs/list/',
                                'text' => ezpI18n::tr( 'extension/occronjobs', 'Cronjobs' ) ),
                         array( 'url' => false,
                                'text' => 'list' ) );

?>
