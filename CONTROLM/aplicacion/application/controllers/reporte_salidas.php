<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("America/Bogota");
class Reporte_salidas extends CI_Controller{

	function __construct(){
		parent:: __construct();
        $this->load->model('catalogo_model');
        $this->load->model('salidas_model');
        $this->load->model('kardex_model');
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
    
    public function Salidas(){
        $filtro = $this->input->get("term");
        // obtenemos el array de profesiones y lo preparamos para enviar
        $datos = $this->salidas_model->obtenerSalidas($filtro);
        
        // cargamos  la interfaz y le enviamos los datos
        echo json_encode($datos);
    }
    
    public function Elementos(){
        $filtro = $this->input->get("term");
        // obtenemos el array de profesiones y lo preparamos para enviar
        $datos = $this->salidas_model->obtenerElementos($filtro);
        
        // cargamos  la interfaz y le enviamos los datos
        echo json_encode($datos);
    }
    
    public function nuevaSalida(){
        session_start();
        $fecha = date('Y-m-d');
        
        $Salida = json_decode($this->input->post('MiSalida'));        
        $arrayResponse = array("id"=>"0","Msg"=>"Error: Ocurrio Un Error Intente de Nuevo", "TipoMsg"=>"Error");
        
        $entrega = $this->salidas_model->obternerCedulas($Salida->quien_entrega);
        $recibe = $this->salidas_model->obternerCedulas($Salida->quien_recibe);
        
        $arraySalida = array(
                         "fecha_movimiento"   => date('Y-m-d H:i:s'),
                         "tipo"               => $Salida->tipo,
                         "quien_entrega"      => $entrega,
                         "quien_recibe"       => $recibe,
                         "estado"             => $Salida->estado,
                        // "requisicion"        => $Salida->requisicion,
                         "usuario"            => $this->session->userdata('idusuario')
        );
        
        $crearSalida = $this->salidas_model->crearSalida($arraySalida);
        if($crearSalida!=0){
            $arrayResponse = array("id"=>$crearSalida,"Msg"=>"<strong>Salida: ".$crearSalida."</strong>, El movimiento de salida se Guardado Correctamente", "TipoMsg"=>"Sucefull");
        }
        
        echo json_encode($arrayResponse);
    }
    
    public function agregarCarrito(){
        session_start();
        
        $carritoSalida = json_decode($this->input->post('MiCarrito'));
        if(isset($_SESSION['CarritoSalida'.$carritoSalida->IdSession])){
            $carrito_salida=$_SESSION['CarritoSalida'.$carritoSalida->IdSession];
            
            if(isset($carritoSalida->Codigo)){
                $tipod = $carritoSalida->Tipod;
                $factura = $carritoSalida->Factura;
                $requisicion = $carritoSalida->Requisicion;


                $txtCodigo = $carritoSalida->Codigo;
                $elemento = $carritoSalida->Elemento;
                $unidad  = $carritoSalida->Unidad;
                $cantidad = $carritoSalida->Cantidad;
                $Costo     = $carritoSalida->Valor;
                $donde     = -1;
                
                for($i=0;$i<=count($carrito_salida)-1;$i ++){
                    if($txtCodigo==$carrito_salida[$i]['txtCodigo']){
                        $donde=$i;
                    }
                }
                
                if($donde != -1){
                    $cuanto=$carrito_salida[$donde]['cantidad'] + $cantidad;
                    $carrito_salida[$donde]=array("tipod"=>$tipod,"factura"=>$factura,"requisicion"=>$requisicion,"txtCodigo"=>$txtCodigo,"elemento"=>$elemento,"unidad"=>$unidad,"cantidad"=>$cuanto,"valor"=>$Costo);
                }else{
                    $carrito_salida[]=array("tipod"=>$tipod,"factura"=>$factura,"requisicion"=>$requisicion,"txtCodigo"=>$txtCodigo,"elemento"=>$elemento,"unidad"=>$unidad,"cantidad"=>$cantidad,"valor"=>$Costo);
                }
            }
        }else{
            $tipod = $carritoSalida->tipod;
            $factura = $carritoSalida->factura;
            $requisicion = $carritoSalida->requisicion;
            $txtCodigo = $carritoSalida->Codigo;
            $elemento = $carritoSalida->Elemento;
            $unidad  = $carritoSalida->Unidad;
            $cantidad = $carritoSalida->Cantidad;
            $Costo     = $carritoSalida->Valor;
            
            $carrito_salida[]=array("tipod"=>$tipod,"factura"=>$factura,"requisicion"=>$requisicion,"txtCodigo"=>$txtCodigo,"elemento"=>$elemento,"unidad"=>$unidad,"cantidad"=>$cantidad,"valor"=>$Costo);
        }
        
        $_SESSION['CarritoSalida'.$carritoSalida->IdSession]=$carrito_salida;
		echo json_encode($_SESSION['CarritoSalida'.$carritoSalida->IdSession]);
    }
    
    public function sacar(){
        session_start();
        $fecha = date('Y-m-d');
        
        $Salida = json_decode($this->input->post('MiSalida'));
        $arrayResponse = array("id"=>$Salida->id,"Msg"=>"Error: Ocurrio Un Error Intente de Nuevo", "TipoMsg"=>"Error");
                
        $carritoSalida = $_SESSION["CarritoSalida".$Salida->IdSession];
		
        if($Salida->id!=0){
            foreach ($carritoSalida as $key => $value) {
                $elemento = $this->catalogo_model->obtenerid($value["txtCodigo"]);
                $tipo = $this->catalogo_model->obtenertipo($elemento);
                $estado = $this->catalogo_model->obtenerestado($elemento);
                
                $arrayDetalle = array(
                         "id_movimiento"  => $Salida->id,

                         "id_elemento"    => $elemento, 
                         "cantidad"       => $value['cantidad'],
                         "pendiente"      => $value['cantidad'],
                         "tipo"           => $tipo,
                         "tipod"         => $tipod, 
                         "estado"         => $estado,
                         "ticket"         => 0,
                         "catalogo"       => "Bodega",
                         "valor"          => str_replace('.', '', $value['valor']),
                         "observaciones"  => ''
                         
                );
                
                $idDetalle = $this->salidas_model->guardarDetalle($arrayDetalle);
                
                $arrayKardex = array(
                         "fecha_movimiento"  => $fecha,
                         "id_detalle_mov"    => 0, 
                         "id_detalle"        => $idDetalle,
                         "cantidad_anterior" => 0,
                         "cantidad_actual"   => $value['cantidad']
                         
                );
                
                $this->kardex_model->guardarKardex($arrayKardex);
            }
            
            $this->salidas_model->actualizarEstadoMov("Terminado", $Salida->id);
            
            $arrayResponse = array("id"=>$Salida->id,"Msg"=>"<strong>Salida: ".$Salida->id."</strong>, La salida de repuestos se realizo Correctamente", "TipoMsg"=>"Sucefull");
            echo json_encode($arrayResponse);
        }
    }
 }
?>