<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mi_modelo extends CI_Model {

  


  public function obtenerUsuario($email,$password)
  {
      $email = $this->input->post('email');
      $password  = md5($this->input->post('password'));

        $this->db->select('id_usuario,nombre_usuario,contrasena,email');
        $this->db->from('usuarios');
        $this->db->where('email', $email);
        $this->db->where('contrasena', $password);

        $consulta = $this->db->get();
        $resultado = $consulta->row();

        if($resultado != null) //si hay filas
        {
          //retornar el resultado de la consulta
          return $resultado;
        }
        else //si no hay resultados distintos de cero
        {
          //retorne null
          return null;
        }


      } 

}


 ?>
