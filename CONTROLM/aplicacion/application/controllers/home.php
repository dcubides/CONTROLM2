<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();
	}


	public function index()
	{
		//$this->load->view('plantillas/front_end/header');
		$this->load->view('home');
		//$this->load->view('layout/footer');
	}
	public function login()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','trim|required');
		$this->form_validation->set_rules('password','Contraseña','trim|required');

		if($this->form_validation->run() == false)
		{
			$this->index();
		}
		else
		{
			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));
			//cargar el modelo invocar el metodo y hacer la consulta a la BDD
			$this->load->model('Mi_modelo');
		  $fila = $this->Mi_modelo->obtenerUsuario($email,$password);

			if($fila != null){
			$sesion_usuario = array(
																'usuario' => $fila->nombre_usuario,
																'email' => $this->input->post('email'),
																'password' => md5($this->input->post('password')),
																'conectado' => true,
			);

			$this->session->set_userdata($sesion_usuario);

			redirect('home/admin');
	}else{
		$mensaje= "usuario o contraseña invalido";
		redirect(base_url());
	}
	redirect(base_url());
}
}
	public function admin()
	{
		$this->load->view("plantillas/front_end/header");
		$this->load->view('admin');
		$this->load->view('plantillas/front_end/footer');
	}
	public function salir()
	{
	  $this->session->sess_destroy();
	  header("Location: ".base_url());
	}


}
