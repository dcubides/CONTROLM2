<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salidas_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
    
    public function buscarencargado($filtro){
        //armamos la consulta
       $query = $this->db->query('SELECT CEDULA, concat(NOMBRE, " ", APELLIDOS) AS label FROM nesitelco.DIRECTORIO where concat(NOMBRE, " ", APELLIDOS) like "%'.$filtro.'%" and DIRECTORIO.activos_bodega=1 AND ESTADO="ALTA" ORDER BY concat(NOMBRE, " ", APELLIDOS) ASC');
       return $query->result();
    }
    
	public function buscartecnico($filtro){
	   //armamos la consulta
       $query = $this->db->query('SELECT CEDULA, concat(NOMBRE, " ", APELLIDOS) AS label FROM nesitelco.DIRECTORIO where concat(NOMBRE, " ", APELLIDOS) like "%'.$filtro.'%" and CEDULA>0 AND ESTADO="ALTA" ORDER BY concat(NOMBRE, " ", APELLIDOS) ASC');
       return $query->result();
    }
    
    public function buscarrequisiones($filtro){
        //armamos la consulta
       $query = $this->db->query('SELECT id as label FROM nesitelco.SOLICITUDES_BODEGA WHERE ESTADO="ATENDIDA" AND id like "%'.$filtro.'%"');
       return $query->result();
    }
    
    public function crearSalida($arraySalida){
        $this->db->trans_start();
     	$this->db->insert('movimientos', $arrarOrder);
     	$this->db->trans_complete();
    }
}
?>