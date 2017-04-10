<?php

if(!defined('SERVER_USER')){ require(dirname(__FILE__)."/../_config/config.php"); }

class dbo {
    
    var $db_name = SERVER_DB;
    
    public function __construct(){ }
    
    function setDatabase($name = NULL){
        $this->db_name = $name;
    }
    
    
    function CONNECT(){
        $mysqli = mysqli_connect(SERVER_HOST, SERVER_USER, SERVER_PASS, SERVER_DB);
        if(mysqli_connect_errno($mysqli)){
            trigger_error('Database connection failed: '  . mysqli_connect_error(), E_USER_ERROR);
        }
        $mysqli->query("SET NAMES 'utf8'");
        return $mysqli;
    }
    
    
    
    function getColumns($table) {
        $arrayCollection = NULL;
        $arrayCollection = array();
        $this->CONNECT();
        $cont = 0;
        $query = "SHOW COLUMNS FROM ".$table;
        $result = mysql_query($query) or die(mysql_error());
        while($row = mysql_fetch_array($result)) {
            $arrayCollection[$cont] = $row['Field'];
            $cont++;
        }
        return $arrayCollection;
    }
    
    function getTables($db) {
        $arrayCollection = array();
        $cont = 0;
        $query = "SHOW TABLES FROM ".$db;
        $result = mysql_query($query) or die(mysql_error());
        while($row = mysql_fetch_array($result)) {
            $arrayCollection[$cont] = $row[0];
            $cont++;
        }
        return $arrayCollection;
    }
    
    
    
}

?>