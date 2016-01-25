<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kardex_model extends CI_Model {
    function __construct(){
		parent::__construct();
	}
    
    public function guardarKardex($arraykardex){
        $this->db->trans_start();
     	$this->db->insert('kardex', $arraykardex);
        $ids = $this->db->insert_id();
     	$this->db->trans_complete();
     	return $ids;
    }
    
    public function tecnicos($filtro){
        //armamos la consulta
        $query = $this->db->query('SELECT distinct CEDULA, concat(NOMBRE, " ", APELLIDOS) AS label FROM nesitelco.DIRECTORIO
        inner join controlm.movimientos
        on directorio.cedula=movimientos.quien_recibe
        inner join controlm.detalle_movimiento
        on movimientos.id=detalle_movimiento.id_movimiento
        where concat(NOMBRE, " ", APELLIDOS) like "%'.$filtro.'%"
        and CEDULA>0
        and DIRECTORIO.ESTADO="ALTA"
        ORDER BY concat(NOMBRE, " ", APELLIDOS) ASC');
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
    
    public function saldos($tecnico){
        $query = $this->db->query('SELECT c.CODIGO, c.DESCRIPCION, c.UNIDAD, sum(dm.PENDIENTE) AS CANTIDAD, sum(dm.VALOR) as VALOR,
        (sum(dm.PENDIENTE) * sum(dm.VALOR)) AS TOTAL
        FROM nesitelco.CATALOGO_BODEGA c
        inner join controlm.detalle_movimiento dm
        on c.id=dm.id_elemento
        inner join controlm.movimientos m
        on dm.id_movimiento=m.id
        where m.tipo="Salida"
        and dm.pendiente>0
        and m.quien_recibe="'.$tecnico.'"
        group by CODIGO');
        return $query->result_array();
    }
}
?>