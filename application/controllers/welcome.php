<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
			//Default theme
			if($this->config->item('theme')==''){
				$this->config->set_item('theme', 'cxc');
			}

            $data['proyectos']= Doctrine_Query::create()
                    ->from('Proyecto p, p.Usuarios u')
                    ->select('p.*, COUNT(u.id) as nusuarios')
                    ->orderBy('id DESC')
                    ->groupBy('p.id')
                    ->execute();
            //var_dump($data['proyectos']->toArray());
		$this->load->view('template',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */