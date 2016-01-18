<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

//heredamso la clase ci_controller

class Reportes_movimientos extends CI_Controller{

	function __construct(){
		parent::__construct();

		//cargamos la base de datos
		$this->load->database();
		//cargamos las librerias
		$this->load->model('grocery_crud_model');
		$this->load->library('grocery_crud');
		$this->load->library('form_validation');
		//añadomos el helper del controlador
		$this->load->helper('url');
	}

	public function informe_mov($output = null) {
		$this->load->view('plantillas/front_end/header');
		$this->load->view('informe_movimientos',$output);
		$this->load->view('plantillas/front_end/footer');
	}

	public function informe_movimiento(){
		try{
			//creamos el objeto
			$crud = new grocery_CRUD();
			//seleccionamos el tema
			$crud->set_theme('flexigrid');
			//seleccionamos el nombre de la tabla de la base de datos
			$crud->set_table('movimientos');
			//creamos las respectivas relaciones
			$crud->set_relation('quien_recibe', 'directorio', '{APELLIDOS} {NOMBRE}');
			$crud->set_relation('quien_entrega', 'directorio', '{APELLIDOS} {NOMBRE}');

			$crud->set_subject("Informe de Movimientos");
			$crud->set_lang_string('list_add','Nuevo Reporte de');

			/* Asignamos el idioma español */
			$crud->set_language('spanish');

			/* Aqui le indicamos que campos deseamos mostrar */
				$crud->required_fields(
				'id',
				'fecha_movimiento',
				 'tipo',
				'quien_entrega',
				'quien_recibe',  
				'estado',
				'requisicion',  
				'usuario'
			);




			$crud->columns(
				'id',
				'fecha_movimiento',
				 'tipo',
				'quien_entrega',
				'quien_recibe',  
				'estado',
				'requisicion',  
				'usuario'
				
			);


			//generamos la tabla

			$output = $crud->render();
			//lo cargamos a la vista situada en views/informe_movimientos
			$this->informe_mov($output);

		}catch(Exception $e){
			/* Si algo sale mal cachamos el error y lo mostramos */
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	} //cierre de la funcion (metodo) informe de movimientos

	public function index(){
		$this->load->library('form_validation');
		//redirijimos toda la informacion con los css de la tabla
		$this->informe_mov((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));

	}






}