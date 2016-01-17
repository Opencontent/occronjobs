<?php

class CronTabReader
{
    public $crontab, $root, $scripts = array();
    
    function __construct()
    {        
        $ini = eZINI::instance( 'occronjobs.ini' );
        $cronTabPath = $ini->variable( 'GeneralSettings', 'CrontabPath' );
        $this->crontab = file_get_contents( $cronTabPath );
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->parse();
        ksort( $this->scripts );
    }
    
    function parse()
    {
        $rows = explode( "\n", $this->crontab );
        $parsed = array();
        foreach( $rows as $row )
        {                    
            $this->parseRow( $row );             
        }
    }
    
    function parseRow( $row )
    {
        $siteAccessList = eZINI::instance()->variable( 'SiteAccessSettings', 'RelatedSiteAccessList' );
        
        if ( strpos( (string)$row, '-s' ) !== false )
        {            
            $temp = 0;
            foreach( $siteAccessList as $siteAccess )
            {
                if ( strpos( (string)$row, $siteAccess ) !== false )
                {
                    $temp++;
                }                
            }
            if ( $temp == 0 )
            {
                return false;
            }
        }
        
        if ( strpos( (string)$row, $this->root ) === false )
        {
            return false;
        }
        
        if ( strpos( (string)$row, 'runcronjobs.php' ) === false )
        {
            return false;
        }
        
        if ( strpos( (string)$row, '#' ) === 0 )
        {
            return false;
        }
        
        $row = explode( 'php', $row );
        if ( count( $row ) > 1 )
        {
            array_shift( $row );
            $row = implode( 'php', $row );
        }
        else
        {
            return false;
        }
        
          
        $row = explode( '>', $row );
        array_pop( $row );
        $row = implode( '>', $row );
        
        $row = str_replace( '-q', '', $row );
        
        if ( in_array( $row, $this->scripts ) )
        {
            return false;
        }
        
        $id = trim( str_replace( 'runcronjobs.php', '', $row ) );
        
        if ( !in_array( $id, eZINI::instance( 'occronjobs.ini' )->variable( 'Forbidden', 'Scripts' ) ) )
        {
            $this->scripts[$id] = array( $row );
        }
        return $row;
    }
    
    function parseRowForRead( $row )
    {
        $siteAccessList = eZINI::instance()->variable( 'SiteAccessSettings', 'RelatedSiteAccessList' );
        
        if ( strpos( (string)$row, '-s' ) !== false )
        {            
            $temp = 0;
            foreach( $siteAccessList as $siteAccess )
            {
                if ( strpos( (string)$row, $siteAccess ) !== false )
                {
                    $temp++;
                }                
            }
            if ( $temp == 0 )
            {
                return false;
            }
        }
        
        if ( strpos( (string)$row, $this->root ) === false )
        {
            return false;
        }
        
        if ( strpos( (string)$row, '#' ) === 0 )
        {
            return false;
        }
        
        $rows = explode( 'cd', $row );
        $row = trim( $rows[0] ) . ' cd ' . trim( $rows[1] );
        
        return $row;
    }
    
    
    function output( $dirty = false )
    {
        if ( $dirty )
        {
            return $this->crontab;
        }
        $rows = explode( "\n", $this->crontab );
        $parsed = array();
        foreach( $rows as $row )
        {                    
            $r = $this->parseRowForRead( $row ); 
            if ( $r )
                $parsed[] = trim( $r );
        }
        return $parsed;
    }
}

?>