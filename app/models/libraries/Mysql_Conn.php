<?php
/**
 * Mysql connection class
 * 
 * @package 
 * @author  Sboniso Nzimande
 */
class Mysql_Conn {
    public $last_sql;

    protected $host     = "dedi484.jnb2.host-h.net";
    protected $port 	= 3306;
    protected $user 	= "nconnectncon";
    protected $pass 	= "Sandpiper121021";
    protected $dbname  	= "nconnect";
    protected $secure  	= FALSE;
    protected $link;
}