<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class Forgot_password extends MY_Controller
{
  protected $rules_forgot_password = array('name' => array(
      'field' => 'email',
      'label' => 'lang:email',
      'rules' => 'trim|htmlspecialchars|required|min_length[2]|valid_email|max_length[255]|encode_php_tags'), );
  function index()
  {
    $post = new StdClass();
    $this->load->library('form_validation');
    $this->form_validation->set_rules($this->rules_forgot_password);
    $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
    $this->ion_auth_model->set_error_delimiters('<p class="error">', '</p>');
    $this->ion_auth_model->set_message_delimiters('<p class="successful">', '</p>');
  
    if ($this->form_validation->run())
    {
      
      $identity = $this->ion_auth->where('email', strtolower($this->input->post('email')))->users()->row();
      
      if (empty($identity))
      {
       
        $this->ion_auth->set_error('forgot_password_email_not_found');
        $this->session->set_flashdata('message', $this->ion_auth->errors());
        redirect("admin/forgot_password", 'refresh');
      }
      $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});
            if ($forgotten)
            {
              $this->session->set_flashdata('message', $this->ion_auth->messages());
              redirect("admin/forgot_password", 'refresh'); 
            } 
            else
            {
              $this->session->set_flashdata('message', $this->ion_auth->errors());
              redirect("admin/forgot_password", 'refresh');
            }
  
    }         
    $this->tpl->set('message', $this->session->flashdata('message'))->set_view('content', 'admin/forgot_password')->build('admin/main_no_auth');
   
  }
}
