<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class Auth extends MY_Controller
{
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
  protected $rules_reset_password = array(
  'new_password' => array(
      'field' => 'new_password',
      'label' => 'lang:new_password',
     
        ),
  'new_password_confirm' => array(
      'field' => 'new_password_confirm',
      'label' => 'lang:new_password_confirm',
      'rules' => 'trim|required'),
    );
  function __construct()
  {
    parent::__construct();
    $this->load->helper('form');
    $this->group_id = $this->session->userdata('group_id');
  }
  function index()
  {
    if ($this->ion_auth->logged_in() && $this->group_id == '1')
      redirect(site_url($this->patch_admin)); //  редирект в начало, по скольку уже авторизован
    else
      redirect(site_url("{$this->patch_admin}auth/login")); //  редирект на авторизацию
  }
  function login()
  {
    if ($this->ion_auth->logged_in() && $this->group_id == '1')
    {
      redirect(site_url($this->patch_admin)); //  редирект в начало, по скольку уже авторизован
    }
    $post = new StdClass();
    $this->load->library('form_validation');
    $this->form_validation->set_rules($this->rules_auth);
    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
    $this->ion_auth_model->set_error_delimiters('<p class="error">', '</p>');
    $this->ion_auth_model->set_message_delimiters('<p class="successful">', '</p>');
 
    if ($this->form_validation->run())
    {
      $login = $this->ion_auth->login($this->input->post('username'), $this->input->post('password'));
      if ($login)
      {
        redirect(site_url($this->patch_admin));
      }
      else
      {
        $this->session->set_flashdata('message', $this->ion_auth->errors());
        redirect(site_url($this->patch_admin.'/auth/login'));
      }
    }
    $this->tpl
         ->set('message', $this->session->flashdata('message'))
         ->set_view('content', "{$this->patch_admin}auth")
         ->build('admin/main_no_auth');
  }
  function logout()
  {
    $this->session->sess_destroy();
    redirect("{$this->patch_admin}auth/login"); //  редирект на авторизацию
  }
  function reset_password($code)
  {
    if (!$code)
    {
      show_404();
    }
    $user = $this->ion_auth->forgotten_password_check($code);
    if ($user)
    {
      $post = new StdClass();
      $this->load->library('form_validation');
      $this->rules_reset_password['new_password']['rules'] =  'trim|required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']|matches[new_password_confirm]';
  
      $this->form_validation->set_rules($this->rules_reset_password);
      $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
      $this->ion_auth_model->set_error_delimiters('<p class="error">', '</p>');
      $this->ion_auth_model->set_message_delimiters('<p class="successful">', '</p>');
      
      if ($this->form_validation->run())
      {
        $identity = $user->{$this->config->item('identity', 'ion_auth')};
        $change = $this->ion_auth->reset_password($identity, $this->input->post('new_password'));
        if ($change)
        {
          $this->session->set_flashdata('message', $this->ion_auth->messages());
          $this->logout();
        } else
        {
          $this->session->set_flashdata('message', $this->ion_auth->errors());
          redirect('admin/auth/reset_password/' . $code, 'refresh');
        }
      }
    } else
    {
      $this->session->set_flashdata('message', $this->ion_auth->errors());
      redirect("admin/forgot_password", 'refresh');
    }
    $this->tpl
         ->set('code', $code)
         ->set('min_password_length', $this->config->item('min_password_length', 'ion_auth'))
         ->set('message', $this->session->flashdata('message'))
         ->set_view('content',"admin/reset_password")
         ->build('admin/main_no_auth');
  }
}
?>
