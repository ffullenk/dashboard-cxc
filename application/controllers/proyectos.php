<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proyectos extends CI_Controller {

    public function crear_form() {
        if(!UsuarioSesion::usuario()){
            echo 'No tiene permisos';
            exit;
        }


        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
        $this->form_validation->set_rules('url','URL','prep_url');

        if ($this->form_validation->run() == TRUE) {
            $proyecto=new Proyecto();
            $proyecto->nombre=$this->input->post('nombre');
            $proyecto->descripcion=$this->input->post('descripcion');
            $proyecto->url=$this->input->post('url');
            $proyecto->usuario_id=UsuarioSesion::usuario()->id;
            $proyecto->save();
            

            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url();
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors();
        }
        
        echo json_encode($respuesta);
    }
    
    function unirse($proyecto_id){
        $data['proyecto']=Doctrine::getTable('Proyecto')->find($proyecto_id);
        
        $this->load->view('proyectos/unirse',$data);
    }
    
    public function unirse_form($proyecto_id) {
        $proyecto=Doctrine::getTable('Proyecto')->find($proyecto_id);
        
        if(!UsuarioSesion::usuario()){
            echo 'No tiene permisos';
            exit;
        }
        
        if (UsuarioSesion::usuario()->perteneceAProyecto($proyecto)){
            echo 'Usuario ya pertenece a este proyecto';
            exit;
        }

        $this->form_validation->set_rules('unirse', 'Unirse', 'required');

        if ($this->form_validation->run() == TRUE) {
            UsuarioSesion::usuario()->proyecto_id=$proyecto->id;
            UsuarioSesion::usuario()->save();

            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url();
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors();
        }
        
        echo json_encode($respuesta);
    }
    
    function editar($proyecto_id){
        $data['proyecto']=Doctrine::getTable('Proyecto')->find($proyecto_id);
        
        $this->load->view('proyectos/editar',$data);
    }
    
    public function editar_form($proyecto_id) {
        $proyecto=Doctrine::getTable('Proyecto')->find($proyecto_id);
        
        if(!UsuarioSesion::usuario()){
            echo 'No tiene permisos';
            exit;
        }
        
        if (UsuarioSesion::usuario()->id!=$proyecto->usuario_id){
            echo 'Usuario no es dueño de este proyecto.';
            exit;
        }

        $this->form_validation->set_rules('nombre', 'Nombre', 'required');
        $this->form_validation->set_rules('descripcion', 'Descripcion', 'required');
        $this->form_validation->set_rules('url','URL','prep_url');

        if ($this->form_validation->run() == TRUE) {
            $proyecto->nombre=$this->input->post('nombre');
            $proyecto->descripcion=$this->input->post('descripcion');
            $proyecto->url=$this->input->post('url');
            $proyecto->save();
            

            $respuesta->validacion = TRUE;
            $respuesta->redirect = site_url();
        } else {
            $respuesta->validacion = FALSE;
            $respuesta->errores = validation_errors();
        }
        
        echo json_encode($respuesta);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */