<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

//heredamso la clase ci_controller

class Reportes_movimientos extends CI_Controller{

	function __construct(){
		parent::__construct();

		//cargamos la base de datos
		$this->load->database();
		//cargamos las librerias
		
		//añadomos el helper del controlador
		$this->load->helper('url');
	}

	public function index() {
		$this->load->view('plantillas/front_end/header');
		$this->load->view('informe_movimientos');
		$this->load->view('plantillas/front_end/footer');
	}

	
}