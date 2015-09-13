<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {
    public $group_id = null;
    public $patch_admin = 'admin/';
    protected $rules_auth = array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required|htmlspecialchars|encode_php_tags'),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|htmlspecialchars|encode_php_tags'),
    );
	function  __construct()
	{
		parent:: __construct();
		$this->load->helper('form');
        $this->group_id = $this->session->userdata('group_id');
	}
	

function index ()
 {

		if($this->ion_auth->logged_in()&&$this->group_id=='1')
			redirect(site_url($this->patch_admin));  //  редирект в начало, по скольку уже авторизован
        else
			redirect(site_url("{$this->patch_admin}auth/login"));  //  редирект на авторизацию
		
 }

function login ()
 {

		if($this->ion_auth->logged_in()&&$this->group_id=='1'){
			redirect(site_url($this->patch_admin));  //  редирект в начало, по скольку уже авторизован
		}
		
        $post = new StdClass();
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->rules_auth);
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
   
        if ($this->form_validation->run()) {
            
           $d =  $this->ion_auth->login($this->input->post('username'),$this->input->post('password'));
           
           if($d)
            {
               redirect(site_url($this->patch_admin)); 
            }
            
        }
     
        
        $this->tpl
             ->build("{$this->patch_admin}auth");
        
        
        
        
 
 }

function logout ()
 {
		$this->session->sess_destroy();
		redirect("{$this->patch_admin}/auth/login");  //  редирект на авторизацию
 }

}
?>
