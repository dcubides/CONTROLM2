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
    
    public function Entradas(){
        $filtro = $this->input->get("term");
        // obtenemos el array de profesiones y lo preparamos para enviar
        $datos = $this->entradas_model->obtenerEntradas($filtro);
        
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
                $ticket = $carritoEntrada->Ticket;
                $factura = $carritoEntrada->Factura;
                $unidad  = $carritoEntrada->Unidad;
                $asignado = $carritoEntrada->Asignado;
                $legalizado = $carritoEntrada->Legalizado;
                $pendiente = $asignado - $legalizado;
                $tipo = $carritoEntrada->Tipo;
                $Costo     = $carritoEntrada->Valor;
                $donde     = -1;
                
                if($pendiente<0)
                  $pendiente = 0;
                
                for($i=0;$i<=count($carrito_entrada)-1;$i ++){
                    if($txtCodigo==$carrito_entrada[$i]['txtCodigo'] && $tipo==$carrito_entrada[$i]['tipo'] && $ticket==$carrito_entrada[$i]['ticket']){
                        $donde=$i;
                    }
                }
                
                if($donde != -1){
                    $cuanto = $carrito_entrada[$donde]['legalizado'] + $legalizado;
                    $pendiente = $asignado - $cuanto; 
                    if($pendiente>=0){
                        $carrito_entrada[$donde]=array("txtCodigo"=>$txtCodigo,"elemento"=>$elemento,"ticket"=>$ticket,"factura"=>$factura,"unidad"=>$unidad,"asignado"=>$asignado,"legalizado"=>$cuanto,"pendiente"=>$pendiente,"tipo"=>$tipo,"valor"=>$Costo);
                    }
                }else{
                    $carrito_entrada[]=array("txtCodigo"=>$txtCodigo,"elemento"=>$elemento,"ticket"=>$ticket,"factura"=>$factura,"unidad"=>$unidad,"asignado"=>$asignado,"legalizado"=>$legalizado,"pendiente"=>$pendiente,"tipo"=>$tipo,"valor"=>$Costo);
                }
            }
        }else{
            $txtCodigo = $carritoEntrada->Codigo;
            $elemento = $carritoEntrada->Elemento;
            $ticket = $carritoEntrada->Ticket;
            $factura = $carritoEntrada->Factura;
            $unidad  = $carritoEntrada->Unidad;
            $asignado = $carritoEntrada->Asignado;
            $legalizado = $carritoEntrada->Legalizado;
            $pendiente = $asignado - $legalizado;
            $tipo = $carritoEntrada->Tipo;
            $Costo     = $carritoEntrada->Valor;
            
            if($pendiente<0)
              $pendiente = 0;
            
            $carrito_entrada[]=array("txtCodigo"=>$txtCodigo,"elemento"=>$elemento,"ticket"=>$ticket,"factura"=>$factura,"unidad"=>$unidad,"asignado"=>$asignado,"legalizado"=>$legalizado,"pendiente"=>$pendiente,"tipo"=>$tipo,"valor"=>$Costo);
        }
        
        $_SESSION['CarritoEntrada'.$carritoEntrada->IdSession]=$carrito_entrada;
        echo json_encode($_SESSION['CarritoEntrada'.$carritoEntrada->IdSession]);
    }
    
    public function entrar(){
        session_start();
        $fecha = date('Y-m-d');
        
        $Entrada = json_decode($this->input->post('MiEntrada'));
        $arrayResponse = array("id"=>$Entrada->id,"Msg"=>"Error: Ocurrio Un Error Intente de Nuevo", "TipoMsg"=>"Error");
                
        $carritoEntrada = $_SESSION["CarritoEntrada".$Entrada->IdSession];
        
        if($Entrada->id!=0){
            foreach ($carritoEntrada as $key => $value) {
                $elemento = $this->catalogo_model->obtenerid($value["txtCodigo"]);
                $tipo = $this->catalogo_model->obtenertipo($elemento);
                $estado = $this->catalogo_model->obtenerestado($elemento);
                
                $entrega = $_SESSION['quien_entrega'];
                $detalle = $this->entradas_model->obtenerDetalleSalida($entrega, $elemento, $value['tipo']);
                
                //$id => obtiene el id, del detalle, de la primera salida
                $id = 0;
                //$idL => concatena todas las requisiciones necesarias para legalizar un elemento
                $idL = "";
                //$pendientes => almacena la suma del pendiente de las salidas
                $pendientes = 0;
                
                //Obtener la cantidad asignada
                $legalizado = $value['legalizado'];
                $pendiente = 0; 
                foreach($detalle as $llave => $val){
                    //Obtener la cantidad del pendiente
                    $pendiente = $pendiente + $val['pendiente'];
                    $idL .= $val['id'].',';
                        
                    if($legalizado>0 && $pendiente>0){
                        if($legalizado>$pendiente){
                            //si lo legalizado es mayor a lo pendiente se se siguen sumando los registros
                            //se actualiza los pendientes
                            if($value['tipo']!="Compra Sitio"){echo 194;
                              $this->entradas_model->actualizarPendientes(0, $val['id']);
                            }
                        }else{
                            //si lo legalizado es menor o igual a lo pendiente
                            $p = $pendiente - $legalizado;
                            //actualiza los pendientes de las salidas
                            if($value['tipo']!="Compra Sitio"){
                              $this->entradas_model->actualizarPendientes($p, $val['id']);
                            }
                            else
                              $value['pendiente'] = $value['legalizado'];
                            //Se crea el detalle de la salida

                            $arrayDetalle = array(
                                "id_movimiento"  => $Entrada->id,
                                "id_elemento"    => $elemento, 
                                "cantidad"       => $value['legalizado'],
                                "pendiente"      => 0,
                                "tipo"           => $tipo,
                                "estado"         => $estado,
                                "ticket"         => $value['ticket'],
                                "factura"        => $value['factura'],
                                "catalogo"       => "Bodega",
                                "valor"          => str_replace('.', '', $value['valor']),
                                "observaciones"  => ''
                            );
                            
                            $idDetalle = $this->entradas_model->guardarDetalle($arrayDetalle);
                            
                            $arrayKardex = array(
                                "fecha_movimiento"  => $fecha,
                                "id_detalle_mov"    => trim($idL, ','), 
                                "id_detalle"        => $idDetalle,
                                "cantidad_anterior" => $value['asignado'],
                                "cantidad_actual"   => $value['pendiente'],
                                "tipo"              => $value['tipo']
                            );
                            
                            $this->kardex_model->guardarKardex($arrayKardex);
                            
                            $pendiente = 0;
                            $legalizado = 0;
                            $idL = "";
                        }
                    }
                }
            }
            
            $arrayResponse = array("id"=>$Entrada->id,"Msg"=>"<strong>Entrada: ".$Entrada->id."</strong>, La entrada de repuestos se realizo Correctamente", "TipoMsg"=>"Sucefull");
            echo json_encode($arrayResponse);
        }
    }

}
?>