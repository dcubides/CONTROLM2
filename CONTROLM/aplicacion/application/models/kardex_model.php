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
        and movimientos.tipo="Salida"
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
    
    public function Kardex($filtros){
        $query = $this->db->query('select m.id as Movimiento, m.fecha_movimiento,
        (select concat(d.NOMBRE, " ", d.APELLIDOS) FROM nesitelco.DIRECTORIO d where CEDULA=m.quien_entrega) as Entrega,
        (select concat(d.NOMBRE, " ", d.APELLIDOS) FROM nesitelco.DIRECTORIO d where CEDULA=m.quien_recibe) as Recibe,
        concat(c.CODIGO, " ", c.DESCRIPCION) as Elemento,
        m.tipo as "Tipo Movimiento", if(m.tipo="Salida", m.requisicion, "") as Requisicion, if(m.tipo="Entrada", dm.ticket, "") as Ticket,
        if(m.tipo="Salida", dm.cantidad, "") as Entregado, if(m.tipo="Entrada", dm.cantidad, "") as Legalizado, dm.pendiente,
        format(dm.VALOR, 0) as "Valor Unitario", format((dm.pendiente * dm.VALOR), 0) as "Total" 
        from controlm.movimientos m
        inner join nesitelco.DIRECTORIO d
        on m.quien_recibe=d.CEDULA
        inner join detalle_movimiento dm
        on m.id=dm.id_movimiento
        inner join nesitelco.CATALOGO_BODEGA c
        on dm.id_elemento=c.id
        '.$filtros.'
        order by dm.id desc');
        return $query->result_array();
    }


    public function movimiento($filtro){
        $query = $this->db->query('select id as label FROM controlm.movimientos where id like "%'.$filtro.'%"  order by id desc');
        return $query->result();
    }

    public function obtenerticket($filtro){
        $query = $this->db->query('select ticket as label FROM controlm.detalle_movimiento where id like "%'.$filtro.'%"  order by id desc');
        return $query->result();
    }

     public function obtenerElementos($filtro){
        $query = $this->db->query('select concat(CODIGO, " ", DESCRIPCION) as label, DESCRIPCION, CODIGO, UNIDAD, replace(format(VALOR, 0), ",", ".") as VALOR FROM nesitelco.CATALOGO_BODEGA where concat(CODIGO, " ", DESCRIPCION) like "%'.$filtro.'%" order by id desc');
        return $query->result();
    }

    public function obtenerFecha($filtro){
        $query = $this->db->query('select fecha_movimiento as label FROM controlm.movimientos where id like "%'.$filtro.'%"  order by id desc');
        return $query->result();
    }
}
?>