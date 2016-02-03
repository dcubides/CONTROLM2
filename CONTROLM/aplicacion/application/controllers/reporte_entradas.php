<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set("America/Bogota");
class Reporte_entradas extends CI_Controller{

	function __construct(){
		parent:: __construct();
        $this->load->model('kardex_model');
        $this->load->model('entradas_model');
        $this->load->model('catalogo_model');
	}

	public function index(){
		$this->load->view("plantillas/front_end/header");
		$this->load->view('movimiento_entradas');
		$this->load->view('plantillas/front_end/footer');
	}

	 public function EncargadoBodega(){
	   // obtenemos el array de profesiones y lo preparamos para enviar
       $filtro = $this->input->get("term");
	   $datos = $this->entradas_model->buscarencargado($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}
    
	public function ListarTecnicos(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->entradas_model->buscartecnico($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}
    
    public function Tickets(){
        $filtro = $this->input->get("term");
        // obtenemos el array de profesiones y lo preparamos para enviar
        $datos = $this->entradas_model->buscartickets($filtro);
        
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
        session_start();
        
        $entrega = $_SESSION['quien_entrega'];
        $filtro = $this->input->get("term");
        // obtenemos el array de profesiones y lo preparamos para enviar
        $datos = $this->entradas_model->obtenerElementos($entrega, $filtro);
        
        // cargamos  la interfaz y le enviamos los datos
        echo json_encode($datos);
    }
    
    public function nuevaEntrada(){
        session_start();
        $fecha = date('Y-m-d');
        
        $Entrada = json_decode($this->input->post('MiEntrada'));        
        $arrayResponse = array("id"=>"0","Msg"=>"Error: Ocurrio Un Error Intente de Nuevo", "TipoMsg"=>"Error");
        
        $entrega = $this->entradas_model->obternerCedulas($Entrada->quien_entrega);
        $recibe = $this->entradas_model->obternerCedulas($Entrada->quien_recibe);
        
        $_SESSION['quien_entrega'] = $entrega;
        
        $arrayEntrada = array(
                         "fecha_movimiento"   => date('Y-m-d H:i:s'),
                         "tipo"               => $Entrada->tipo,
                         "quien_entrega"      => $entrega,
                         "quien_recibe"       => $recibe,
                         "estado"             => $Entrada->estado,
                         //"requisicion"        => $Entrada->requisicion,
                         "usuario"            => $this->session->userdata('idusuario')
        );
        
        $crearEntrada = $this->entradas_model->crearEntrada($arrayEntrada);
        if($crearEntrada!=0){
            $arrayResponse = array("id"=>$crearEntrada,"Msg"=>"<strong>Salida: ".$crearEntrada."</strong>, El movimiento de Entrada se Guardado Correctamente", "TipoMsg"=>"Sucefull");
        }
        
        echo json_encode($arrayResponse);
    }
    
    public function agregarCarrito(){
        session_start();
        
        $carritoEntrada = json_decode($this->input->post('MiCarrito'));
        if(isset($_SESSION['CarritoEntrada'.$carritoEntrada->IdSession])){
            $carrito_entrada=$_SESSION['CarritoEntrada'.$carritoEntrada->IdSession];
            
            if(isset($carritoEntrada->Codigo)){
                $txtCodigo = $carritoEntrada->Codigo;
                $elemento = $carritoEntrada->Elemento;
                $unidad  = $carritoEntrada->Unidad;
                $cantidad = $carritoEntrada->Cantidad;
                $Costo     = $carritoEntrada->Valor;
                $donde     = -1;
                
                for($i=0;$i<=count($carrito_entrada)-1;$i ++){
                    if($txtCodigo==$carrito_entrada[$i]['txtCodigo']){
                        $donde=$i;
                    }
                }
                
                if($donde != -1){
                    $cuanto=$carrito_entrada[$donde]['cantidad'] + $cantidad;
                    $carrito_entrada[$donde]=array("txtCodigo"=>$txtCodigo,"elemento"=>$elemento,"unidad"=>$unidad,"cantidad"=>$cuanto,"valor"=>$Costo);
                }else{
                    $carrito_entrada[]=array("txtCodigo"=>$txtCodigo,"elemento"=>$elemento,"unidad"=>$unidad,"cantidad"=>$cantidad,"valor"=>$Costo);
                }
            }
        }else{
            $txtCodigo = $carritoEntrada->Codigo;
            $elemento = $carritoEntrada->Elemento;
            $unidad  = $carritoEntrada->Unidad;
            $cantidad = $carritoEntrada->Cantidad;
            $Costo     = $carritoEntrada->Valor;
            
            $carrito_entrada[]=array("txtCodigo"=>$txtCodigo,"elemento"=>$elemento,"unidad"=>$unidad,"cantidad"=>$cantidad,"valor"=>$Costo);
        }
        
        $_SESSION['CarritoEntrada'.$carritoEntrada->IdSession]=$carrito_entrada;
        echo json_encode($_SESSION['CarritoEntrada'.$carritoEntrada->IdSession]);
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
                         "pendiente"      => 0,
                         "tipo"           => $tipo,
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
            
            $arrayResponse = array("id"=>$Salida->id,"Msg"=>"<strong>Salida: ".$Salida->id."</strong>, La salida de repuestos se realizo Correctamente", "TipoMsg"=>"Sucefull");
            echo json_encode($arrayResponse);
        }
    }

}
?>