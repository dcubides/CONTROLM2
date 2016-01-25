<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

//heredamso la clase ci_controller

class Reportes_movimientos extends CI_Controller{

	function __construct(){
		parent::__construct();
        $this->load->model('kardex_model');
        $this->load->library('excel');
	}
    
	public function index() {
		$this->load->view('plantillas/front_end/header');
		$this->load->view('informe_movimientos');
		$this->load->view('plantillas/front_end/footer');
	}

	public function Tecnicos(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->kardex_model->tecnicos($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}

	public function Movimiento(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->kardex_model->movimiento($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}
    
    public function Tipo(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->kardex_model->tipo($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}
    
	public function Tickets(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->kardex_model->obtenerticket($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}
    
    public function Requisicion(){
        $filtro = $this->input->get("term");
        // obtenemos el array de profesiones y lo preparamos para enviar
        $datos = $this->kardex_model->obtenerrequisicion($filtro);
        
        // cargamos  la interfaz y le enviamos los datos
        echo json_encode($datos);
    }

	public function Elemento(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->kardex_model->obtenerElementos($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}
    
	public function Fecha(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->kardex_model->obtenerFecha($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}
    
    public function InformeKardex(){
        $Consulta = json_decode($this->input->post('MiConsulta'));
        $movimiento = $Consulta->movimiento;
        $tipo = $Consulta->tipo;
        $ticket = $Consulta->ticket;
        $requisicion = $Consulta->requisicion;
        $elemento = $Consulta->elemento;
        $fecha = $Consulta->fecha;
        $nombre = $Consulta->nombre;
        
        $filtro = "";
        
        if(!empty($movimiento)){
            $filtro = 'where m.id='.$movimiento;
        }
        if(!empty($tipo)){
            if(trim($filtro)!="")
              $filtro .= ' and m.tipo="'.$tipo.'"';
            else
              $filtro = 'where m.tipo="'.$tipo.'"';
        }
        if(!empty($ticket)){
            if(trim($filtro)!="")
              $filtro .= ' and dm.ticket="'.$ticket.'"';
            else
              $filtro = 'where dm.ticket="'.$ticket.'"';
        }
        if(!empty($requisicion)){
            if(trim($filtro)!="")
              $filtro .= ' and m.requisicion="'.$requisicion.'"';
            else
              $filtro = 'where m.requisicion="'.$requisicion.'"';
        }
        if(!empty($elemento)){
            if(trim($filtro)!="")
              $filtro .= ' and concat(c.CODIGO, " ", c.DESCRIPCION)="'.$elemento.'"';
            else
              $filtro = 'where concat(c.CODIGO, " ", c.DESCRIPCION)="'.$elemento.'"';
        }
        if(!empty($fecha)){
            if(trim($filtro)!="")
              $filtro .= ' and m.fecha_movimiento="'.$fecha.'"';
            else
              $filtro = 'where m.fecha_movimiento="'.$fecha.'"';
        }
        if(!empty($nombre)){
            if(trim($filtro)!=""){
                if(trim($tipo)=="" || strtolower(trim($tipo)=="salida")){
                    $filtro .= ' and (select concat(d.NOMBRE, " ", d.APELLIDOS) FROM nesitelco.DIRECTORIO d where CEDULA=m.quien_recibe)="'.$nombre.'"';
                }
                if(strtolower(trim($tipo)=="entrada")){
                    $filtro .= ' and (select concat(d.NOMBRE, " ", d.APELLIDOS) FROM nesitelco.DIRECTORIO d where CEDULA=m.quien_entrega)="'.$nombre.'"';
                }
            }
            else{
              if(trim($tipo)=="" || strtolower(trim($tipo)=="salida")){
                $filtro = ' where (select concat(d.NOMBRE, " ", d.APELLIDOS) FROM nesitelco.DIRECTORIO d where CEDULA=m.quien_recibe)="'.$nombre.'"';
              }
              if(strtolower(trim($tipo)=="entrada")){
                $filtro = ' where (select concat(d.NOMBRE, " ", d.APELLIDOS) FROM nesitelco.DIRECTORIO d where CEDULA=m.quien_entrega)="'.$nombre.'"';
              }
            }
        }
        
        $saldos = $this->kardex_model->Kardex($filtro);
        
        echo json_encode($saldos);
    }
    
    public function Exportar(){
        $movimiento = $_GET['movimiento'];
        $tipo = $_GET['tipo'];
        $ticket = $_GET['ticket'];
        $requisicion = $_GET['requisicion'];
        $elemento = $_GET['elemento'];
        $fecha = $_GET['fecha'];
        $nombre = $_GET['nombre'];
        
        $filtro = "";
        
        if(!empty($movimiento)){
            $filtro = 'where m.id='.$movimiento;
        }
        if(!empty($tipo)){
            if(trim($filtro)!="")
              $filtro .= ' and m.tipo="'.$tipo.'"';
            else
              $filtro = 'where m.tipo="'.$tipo.'"';
        }
        if(!empty($ticket)){
            if(trim($filtro)!="")
              $filtro .= ' and dm.ticket="'.$ticket.'"';
            else
              $filtro = 'where dm.ticket="'.$ticket.'"';
        }
        if(!empty($requisicion)){
            if(trim($filtro)!="")
              $filtro .= ' and m.requisicion="'.$requisicion.'"';
            else
              $filtro = 'where m.requisicion="'.$requisicion.'"';
        }
        if(!empty($elemento)){
            if(trim($filtro)!="")
              $filtro .= ' and concat(c.CODIGO, " ", c.DESCRIPCION)="'.$elemento.'"';
            else
              $filtro = 'where concat(c.CODIGO, " ", c.DESCRIPCION)="'.$elemento.'"';
        }
        if(!empty($fecha)){
            if(trim($filtro)!="")
              $filtro .= ' and m.fecha_movimiento="'.$fecha.'"';
            else
              $filtro = 'where m.fecha_movimiento="'.$fecha.'"';
        }
        if(!empty($nombre)){
            if(trim($filtro)!=""){
                if(trim($tipo)=="" || strtolower(trim($tipo)=="salida")){
                    $filtro .= ' and (select concat(d.NOMBRE, " ", d.APELLIDOS) FROM nesitelco.DIRECTORIO d where CEDULA=m.quien_recibe)="'.$nombre.'"';
                }
                if(strtolower(trim($tipo)=="entrada")){
                    $filtro .= ' and (select concat(d.NOMBRE, " ", d.APELLIDOS) FROM nesitelco.DIRECTORIO d where CEDULA=m.quien_entrega)="'.$nombre.'"';
                }
            }
            else{
              if(trim($tipo)=="" || strtolower(trim($tipo)=="salida")){
                $filtro = ' where (select concat(d.NOMBRE, " ", d.APELLIDOS) FROM nesitelco.DIRECTORIO d where CEDULA=m.quien_recibe)="'.$nombre.'"';
              }
              if(strtolower(trim($tipo)=="entrada")){
                $filtro = ' where (select concat(d.NOMBRE, " ", d.APELLIDOS) FROM nesitelco.DIRECTORIO d where CEDULA=m.quien_entrega)="'.$nombre.'"';
              }
            }
        }        
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Reporte Movimientos');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'MOVIMIENTOS KARDEX');
        $this->excel->getActiveSheet()->setCellValue('A4', 'MOVIMIENTO');
        $this->excel->getActiveSheet()->setCellValue('B4', 'FECHA');
        $this->excel->getActiveSheet()->setCellValue('C4', 'ENTREGA');
        $this->excel->getActiveSheet()->setCellValue('D4', 'RECIBE');
        $this->excel->getActiveSheet()->setCellValue('E4', 'ELEMENTO');
        $this->excel->getActiveSheet()->setCellValue('F4', 'TIPO MOVIMIENTO');
        $this->excel->getActiveSheet()->setCellValue('G4', 'REQUISICION');
        $this->excel->getActiveSheet()->setCellValue('H4', 'TICKET');
        $this->excel->getActiveSheet()->setCellValue('I4', 'ENTREGADO');
        $this->excel->getActiveSheet()->setCellValue('J4', 'LEGALIZADO');
        $this->excel->getActiveSheet()->setCellValue('K4', 'PENDIENTE');
        $this->excel->getActiveSheet()->setCellValue('L4', 'VALOR UNITARIO');
        $this->excel->getActiveSheet()->setCellValue('M4', 'TOTAL');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:M1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('M'); $col++){
            //set column dimension
            $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        
        //retrive contries table data
        $saldos = $this->kardex_model->Kardex($filtro);
        
        $exceldata="";
        
        foreach($saldos as $llave => $val){
            $exceldata[] = $val;
        }
        //Fill data
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A5');
        
        $this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('M4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $filename='Reporte Movimientos.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
}