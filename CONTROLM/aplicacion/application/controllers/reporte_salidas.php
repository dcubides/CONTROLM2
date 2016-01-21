<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("America/Bogota");
class Reporte_salidas extends CI_Controller{

	function __construct(){
		parent:: __construct();
        $this->load->model('salidas_model');
	}

	public function index(){
	    $this->load->view("plantillas/front_end/header");
		$this->load->view('movimiento_salidas');
		$this->load->view('plantillas/front_end/footer');        
	}

	public function index2(){
		$this->load->view("plantillas/front_end/header");
		$this->load->view('reporte_salidas');
		$this->load->view('plantillas/front_end/footer');
	}

	public function BuscarTecnico(){
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->salidas_model->buscartecnico();
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}
    
    public function nuevaSalida(){
        session_start();
        $fecha = date('Y-m-d');
        
        $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $this->seguridad_model->SessionActivo($url);
    }
}
?>