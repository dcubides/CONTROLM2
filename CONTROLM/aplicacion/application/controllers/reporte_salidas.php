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
    
    public function EncargadoBodega(){
	   // obtenemos el array de profesiones y lo preparamos para enviar
       $filtro = $this->input->get("term");
	   $datos = $this->salidas_model->buscarencargado($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}
    
	public function ListarTecnicos(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->salidas_model->buscartecnico($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}
    
    public function Requisiciones(){
        $filtro = $this->input->get("term");
        // obtenemos el array de profesiones y lo preparamos para enviar
        $datos = $this->salidas_model->buscarrequisiones($filtro);
        
        // cargamos  la interfaz y le enviamos los datos
        echo json_encode($datos);
    }
    
    public function nuevaSalida(){
        session_start();
        $fecha = date('Y-m-d');
        
        $Salida = json_decode($this->input->post('MiSalida'));        
        
        $entrega = $this->salidas_model->obternerCedulas($Salida->quien_recibe);
        $recibe = $this->salidas_model->obternerCedulas($Salida->quien_entrega);
        
        $arraySalida = array(
                         "fecha_movimiento"   => date('Y-m-d H:i:s'),
                         "tipo"               => $Salida->tipo,
                         "quien_entrega"      => $entrega,
                         "quien_recibe"       => $recibe,
                         "estado"             => $Salida->estado,
                         "requisicion"        => $Salida->requisicion,
                         "usuario"            => $this->session->userdata('idusuario')
        );
        
        $crearSalida = $this->salidas_model->crearSalida($arraySalida);
    }
}
?>