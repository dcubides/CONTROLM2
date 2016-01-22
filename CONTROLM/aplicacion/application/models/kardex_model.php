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
}
?>