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
    
    public function obternerCedulas($nombre){
        $query = $this->db->query('SELECT CEDULA FROM nesitelco.DIRECTORIO where concat(NOMBRE, " ", APELLIDOS) = "'.$nombre.'"');
        $cedula = "";
        foreach ($query->result_array() as $row){
            $cedula = $row['CEDULA'];
        }
        return $cedula;
    }
    
    public function obtenerSalidas($filtro){
        $query = $this->db->query('select id as label FROM controlm.movimientos where id like "%'.$filtro.'%" and tipo="Salida" order by id desc');
        return $query->result();
    }
    
    public function obtenerElementos($filtro){
        $query = $this->db->query('select concat(CODIGO, " ", DESCRIPCION) as label, DESCRIPCION, CODIGO, UNIDAD, replace(format(VALOR, 0), ",", ".") as VALOR FROM nesitelco.CATALOGO_BODEGA where concat(CODIGO, " ", DESCRIPCION) like "%'.$filtro.'%" order by id desc');
        return $query->result();
    }
    
    public function crearSalida($arraySalida){
        $this->db->trans_start();
     	$this->db->insert('movimientos', $arraySalida);
        $ids = $this->db->insert_id();
     	$this->db->trans_complete();
     	return $ids;
    }
    
    public function actualizarEstadoMov($estado, $id){
        $this->db->query('update movimientos set estado="'.$estado.'" where id='.$id);
    }
    
    public function guardarDetalle($arrayDetalleSalida){
        $this->db->trans_start();
     	$this->db->insert('detalle_movimiento', $arrayDetalleSalida);
        $ids = $this->db->insert_id();
     	$this->db->trans_complete();
     	return $ids;
    }
}
?>