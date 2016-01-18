<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("America/Bogota");
class Salidas_bodega extends CI_Controller{

	function __construct(){
		parent:: __construct();
	}

	public function index(){
		$this->load->view("plantillas/front_end/header");
		$this->load->view('reporte_salidas');
		$this->load->view('plantillas/front_end/footer');
	}
    
    public function nuevaSalida(){
        session_start();
        $fecha = date('Y-m-d');
        
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $this->seguridad_model->SessionActivo($url);
    }
}
?>