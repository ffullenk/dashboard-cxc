<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Autenticacion extends CI_Controller {


	public function oauth_login(){
            UsuarioSesion::login_oauth(site_url('autenticacion/oauth_response'));      
            
		
	}
        
        function oauth_response(){
            UsuarioSesion::login_oauth_response();

            
            
            
        }
        
        function logout(){
            UsuarioSesion::logout();
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */