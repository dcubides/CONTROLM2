<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entradas_model extends CI_Model {

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
       $query = $this->db->query('SELECT distinct CEDULA, concat(NOMBRE, " ", APELLIDOS) AS label FROM nesitelco.DIRECTORIO 
       inner join controlm.movimientos
       on directorio.cedula=movimientos.quien_recibe
       inner join controlm.detalle_movimiento
       on movimientos.id=detalle_movimiento.id_movimiento
       where concat(NOMBRE, " ", APELLIDOS) like "%'.$filtro.'%"
       and CEDULA>0
       and DIRECTORIO.ESTADO="ALTA"
       and detalle_movimiento.pendiente>0
       ORDER BY concat(NOMBRE, " ", APELLIDOS) ASC');
       return $query->result();
    }
    
    public function buscartickets($filtro){
        //armamos la consulta
       $query = $this->db->query('SELECT id as label FROM nesitelco.ticket WHERE ESTADO="ABIERTO" AND id like "%'.$filtro.'%"');
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
        $query = $this->db->query('select id as label FROM controlm.movimientos where id like "%'.$filtro.'%" order by id desc');
        return $query->result();
    }
    
    public function obtenerElementos($tecnico, $filtro){
        $query = $this->db->query('select concat(CODIGO, " ", DESCRIPCION) as label, DESCRIPCION, CODIGO, detalle_movimiento.cantidad, UNIDAD, replace(format(detalle_movimiento.valor, 0), ",", ".") as VALOR
        FROM nesitelco.CATALOGO_BODEGA
        inner join controlm.detalle_movimiento
        on detalle_movimiento.id_elemento=CATALOGO_BODEGA.id
        inner join controlm.movimientos
        on movimientos.id=detalle_movimiento.id_movimiento
        where concat(CODIGO, " ", DESCRIPCION) like "%'.$filtro.'%" and
        movimientos.quien_recibe="'.$tecnico.'" order by CATALOGO_BODEGA.id desc');
        return $query->result();
    }
    
    public function crearEntrada($arraySalida){
        $this->db->trans_start();
     	$this->db->insert('movimientos', $arraySalida);
        $ids = $this->db->insert_id();
     	$this->db->trans_complete();
     	return $ids;
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