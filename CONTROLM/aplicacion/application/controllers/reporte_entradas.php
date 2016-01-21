<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("America/Bogota");
class Reporte_entradas extends CI_Controller{

	function __construct(){
		parent:: __construct();
	}

	public function index(){
		$this->load->view("plantillas/front_end/header");
		$this->load->view('movimiento_entradas');
		$this->load->view('plantillas/front_end/footer');
	}



	public function BuscarTecnico(){
		
		$this->load->model('salidas_model');

		// obtenemos el array de profesiones y lo preparamos para enviar
		$datos['arrTecnicos'] = $this->salidas_model->get_tecnicos();
    
		// cargamos  la interfaz y le enviamos los datos
			$this->load->view('reporte_salidas', $datos);


	}
    
    public function nuevaSalida(){
        session_start();
        $fecha = date('Y-m-d');
        
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $this->seguridad_model->SessionActivo($url);
    }
}
?>