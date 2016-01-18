<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Movimientos_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function nuevaSalida($arraySalida){
        $this->db->trans_start();
     	$this->db->insert('movimientos', $arraySalida);
     	$ids = $this->db->insert_id();
     	$this->db->trans_complete();
     	return $ids;
    }
}
?>