<?php
$Module = array( 'name' => 'OC Cronjobs' );

$ViewList = array();

$ViewList['list'] = array(
    'script' => 'list.php',
    'functions' => array( 'list' ),
    'default_navigation_part' => 'occronjobnavigationpart'
);

$ViewList['launch'] = array(
    'script' => 'launch.php',
    'functions' => array( 'launch' ),
    'default_navigation_part' => 'occronjobnavigationpart'
);
    
$ViewList['logs'] = array(
    'script' => 'logs.php',
    'functions' => array( 'launch' ),
    'default_navigation_part' => 'occronjobnavigationpart'
);

$ViewList['clear'] = array(
    'script' => 'clear.php',
    'functions' => array( 'launch' ),
    'default_navigation_part' => 'occronjobnavigationpart'
);

$ViewList['crontab'] = array(
    'script' => 'crontab.php',
    'functions' => array( 'list' ),
    'default_navigation_part' => 'occronjobnavigationpart'
);

$ViewList['show_crontab'] = array(
    'script' => 'show_crontab.php',
    'functions' => array( 'list' ),
    'default_navigation_part' => 'occronjobnavigationpart'
);

$FunctionList = array();
$FunctionList['launch'] = array();
$FunctionList['list'] = array();
?>
