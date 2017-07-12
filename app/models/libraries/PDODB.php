<?php
/**
 * PDO connection class
 * 
 * @package
 * @author  Sboniso Nzimande
 */
class PDODB extends PDO_Conn implements DB {

    private $new_link       = true;
    private $client_flags   = 0;
    
    public function __construct() {
        $this->connect ();
        // $this->select_db ($this->dbname);
    }
    
    public function __destruct() {
        // $this->close();
    }
    
    public function connect() {
        try{

        $this->link = new PDO ('mysql:host=' .$this->host . ';dbname=' . $this->dbname, 
                                $this->user, 
                                $this->pass,
                                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        }catch(PDOException $ex){
            print json_encode(array('status'=> false, 'text' => 'Error!: ' . $ex->getMessage()));
            die();
        }
        
        // if ($this->link->connect_errno) {
        //     /* Error connecting */
        //     return 'Error connecting: '.$this->link->connect_errno;
        // }
    }

    public function errno () {
        return $this->link->errno;
    }

    public function error() {
        return $this->link->error;
    }

    public function escape_string($string) {
        return $this->link->quote($string);
    }

    public function query($query) {
        $this->last_sql = $query;
        return $this->link->query($query);
    }
    
    public function fetch_array($result, $array_type = MYSQL_BOTH) {
        return $result->fetchAll($array_type);
    }

    public function fetch_row($result) {
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    public function fetch_assoc($result) {
        return $this->link->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function fetch_object($result)  {
        return $this->link->fetchAll(PDO::FETCH_CLASS, 'ArrayObject');
    }
    
    public function num_rows($result) {
        return $result->num_rows;
    }

    public function insert_id() {
        return $this->link->lastInsertId;
    }
    
    public function close() {
        return $this->link->close();
    }
    
    public function select_db ($db) {
        return $this->link->select_db($db);
    }

    public function prepare ($query){
        return $this->link->prepare ($query);
    }
    
    public function quote ($string){
        return $this->link->quote ($query);
    }

  

    public function execute($stmt){
        return $stmt->execute();
    }

    public function mssql_init($sp){}
    public function mssql_bind($sp, $varName, $varValue, $varType){}
    public function mssql_execute($query){}

}