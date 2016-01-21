<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salidas_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
    
    public function buscarencargado(){
        //armamos la consulta
       $query = $this->db->query('SELECT CEDULA, concat(NOMBRE, " ", APELLIDOS) AS label FROM nesitelco.directorio where directorio.activos_bodega=1');
       return $query->result();
       /*
       //SI HAY RESULTADOS
       if ($query->num_rows() > 0) {
         //almacenamos en matriz bidimencional
         foreach ($query->result() as $row) {
            $arrDatos[htmlspecialchars($row->CEDULA, ENT_QUOTES)] = htmlspecialchars($row->label);
            $query->free_result();
            return $arrDatos;
         }
       }*/
    }
    
	public function buscartecnico(){
	   //armamos la consulta
       $query = $this->db->query('SELECT CEDULA, concat(NOMBRE, " ", APELLIDOS) AS label FROM nesitelco.directorio');
       
       return $query->result();
       /*
       //SI HAY RESULTADOS
       if ($query->num_rows() > 0) {
         //almacenamos en matriz bidimencional
         foreach ($query->result() as $row) {
            $arrDatos[htmlspecialchars($row->CEDULA, ENT_QUOTES)] = htmlspecialchars($row->label);
            $query->free_result();
            return $arrDatos;
         }
       }*/
    }
    
    public function buscarrequisiones(){
        //armamos la consulta
       $query = $this->db->query('SELECT id FROM ');
       return $query->result();
       /*
       //SI HAY RESULTADOS
       if ($query->num_rows() > 0) {
         //almacenamos en matriz bidimencional
         foreach ($query->result() as $row) {
            $arrDatos[htmlspecialchars($row->CEDULA, ENT_QUOTES)] = htmlspecialchars($row->label);
            $query->free_result();
            return $arrDatos;
         }
       }*/
    }
}
?>