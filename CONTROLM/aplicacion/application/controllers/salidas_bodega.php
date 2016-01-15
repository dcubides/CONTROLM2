<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salidas_bodega extends CI_Controller{

	function __construct(){
		parent:: __construct();
	}

	public function index(){
		$this->load->view("plantillas/front_end/header");
		$this->load->view('reporte_salidas');
		$this->load->view('plantillas/front_end/footer');

	}
}