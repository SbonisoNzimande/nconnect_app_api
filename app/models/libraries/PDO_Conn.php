<?php
/**
 * PDO connection class
 * 
 * @package 
 * @author  Sboniso Nzimande
 */
class PDO_Conn {
    public $last_sql;

    protected $host     = "dedi484.jnb2.host-h.net";
    protected $port 	= 3306;
    protected $user 	= "conne_demofmcg";
    protected $pass 	= "Sandpiper121021";
    protected $dbname  	= "conne_demofmcg";
    protected $secure  	= FALSE;
    protected $link;
}