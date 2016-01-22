<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogo_model extends CI_Model {
    function __construct(){
		parent::__construct();
	}
    
    public function obtenerid($filtro){
        //armamos la consulta
        $query = $this->db->query('SELECT id FROM nesitelco.CATALOGO_BODEGA where CODIGO = "'.$filtro.'"');
        $id = "";
        foreach ($query->result_array() as $row){
            $id = $row['id'];
        }
        return $id;
    }
    
    public function obtenertipo($filtro){
        //armamos la consulta
        $query = $this->db->query('SELECT TIPO FROM nesitelco.CATALOGO_BODEGA where id = "'.$filtro.'"');
        $tipo = "";
        foreach ($query->result_array() as $row){
            $tipo = $row['TIPO'];
        }
        return $tipo;
    }
    
    public function obtenerestado($filtro){
        //armamos la consulta
        $query = $this->db->query('SELECT ESTADO FROM nesitelco.CATALOGO_BODEGA where id = "'.$filtro.'"');
        $estado = "";
        foreach ($query->result_array() as $row){
            $estado = $row['ESTADO'];
        }
        return $estado;
    }
}
?>