<?php  if (! define('BASEPATH')) exit('No direct script access allowed');

class Salidas_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function buscartecnico($filtro){

	//armamos la consulta
		$query = $this->db->query('SELECT CEDULA, concat(NOMBRE, ' ', APELLIDOS) AS label FROM nesitelco.directorio');

		//SI HAY RESULTADOS
		if ($query->num_rows() > 0) {
			//almacenamos en matriz bidimencional
			foreach ($query->result() as $row) {

				$arrDatos[htmlspecialchars($row->CEDULA, ENT_QUOTES)] = htmlspecialchars($row->label);

					$query->free_result();
					return $arrDatos;
			}
		}
	}


}
