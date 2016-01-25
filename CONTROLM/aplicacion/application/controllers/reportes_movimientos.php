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

	public function Tickets(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->kardex_model->obtenerticket($filtro);
       
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

	public function Elemento(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->kardex_model->obtenerElementos($filtro);
       
       // cargamos  la interfaz y le enviamos los datos
       echo json_encode($datos);
	}

	public function Requisicion(){
	   $filtro = $this->input->get("term");
	   // obtenemos el array de profesiones y lo preparamos para enviar
	   $datos = $this->kardex_model->requisicion($filtro);
       
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
        $tecnico = json_decode($this->input->post('MiTecnico'));
        $cedula = $this->kardex_model->obternerCedulas($tecnico->nombre);
        $saldos = $this->kardex_model->kardex($cedula);
        
        echo json_encode($saldos);
    }
    
    public function Exportar(){
        $nombre = explode(' ', $_GET['nombre']);
        $cedula = $this->kardex_model->obternerCedulas($_GET['nombre']);
        
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Informe Saldos '.$nombre[0]);
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'Informe Saldos '.$_GET['nombre']);
        $this->excel->getActiveSheet()->setCellValue('A4', 'CODIGO');
        $this->excel->getActiveSheet()->setCellValue('B4', 'DESCRIPCION');
        $this->excel->getActiveSheet()->setCellValue('C4', 'UNIDAD');
        $this->excel->getActiveSheet()->setCellValue('D4', 'CANTIDAD');
        $this->excel->getActiveSheet()->setCellValue('E4', 'VALOR');
        $this->excel->getActiveSheet()->setCellValue('F4', 'TOTAL');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A1:F1');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('C'); $col++){
            //set column dimension
            $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
            //change the font size
            $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        
        //retrive contries table data
        $saldos = $this->kardex_model->saldos($cedula);
        
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
        
        $filename='Informe Saldos '.$nombre[0].'.xls'; //save our workbook as this file name
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