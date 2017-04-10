<?php

require_once("class.helper.php");

class Dashboard extends Helper {
    var $zona;
    var $created_at;
    var $status;
    var $modified_at;
    var $id;
    var $id_ciudad;
    
    public function __construct(){ $this->sql = new dbo(); }
    
    public function db($key){
    }
    
    public function getLastInserted(){ return $this->lastInserted; }
    
    public function getData($id = NULL){
        
    }

    public function get_cotizaciones(){
        $query = 'SELECT MONTH(created_at) AS mes FROM requerimiento ORDER BY CAST(created_at AS datetime) ASC';
        return $this->execute($query);
    }

    public function get_negocios(){
        $query = 'SELECT MONTH(created_at) AS mes FROM negocio ORDER BY CAST(created_at AS DATETIME) ASC';
        return $this->execute($query);
    }

    public function get_usuarios(){
        $query = 'SELECT MONTH(created_at) AS mes FROM usuario ORDER BY CAST(created_at AS datetime) ASC';
        return $this->execute($query);
    }
    
    public function zonaNegocio($id){
        
    }
}
?>