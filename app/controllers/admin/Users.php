<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


  


class Users extends Admin_Controller
{

   protected $rules_users = array(
   'name'=>   array(
                   'field' => 'name',
                   'label' => 'lang:name',
                   'rules' => 'trim|htmlspecialchars|required|min_length[2]|max_length[45]|encode_php_tags'),
   'surname'=>   array(
                   'field' => 'surname',
                   'label' => 'lang:surname',
                   'rules' => 'trim|htmlspecialchars|min_length[2]|max_length[45]|encode_php_tags'),
   'username'=>  array(
                   'field' => 'username',
                   'label' => 'lang:login',
                   'rules' => 'trim|required|is_unique[users.username.id.%s]|htmlspecialchars|min_length[3]|max_length[45]|encode_php_tags'),
   'email'=>  array(
                   'field' => 'email',
                   'label' => 'lang:email',
                   'rules' => 'trim|required|is_unique[users.email.id.%s]|min_length[6]|max_length[45]|htmlspecialchars|encode_php_tags|valid_email'),  
   'group_id'=>  array(
                   'field' => 'group_id',
                   'label' => 'lang:group',
                   'rules' => 'trim|required'),  
   'skype'=>   array(
                   'field' => 'skype',
                   'label' => 'lang:skype',
                   'rules' => 'trim|htmlspecialchars|min_length[2]|max_length[45]|encode_php_tags'),
     );
     
     protected $rules_password = array(
    'pass'=>   array(
                   'field' => 'pass',
                   'label' => 'lang:password',
                   'rules' => 'trim|required|htmlspecialchars|min_length[2]|max_length[45]|encode_php_tags'),
    'pass_confirm'=>   array(
                   'field' => 'pass_confirm',
                   'label' => 'lang:password',
                   'rules' => 'trim|htmlspecialchars|min_length[2]|max_length[45]|encode_php_tags|matches[pass]'),
    );   
 
    protected $identity;
    
    public function __construct()
    {
        parent::__construct();
        $this->identity =  $this->config->item('identity', 'ion_auth');
    }
    public function index()
    {
            $this->breadcrumbs['admin/users'] = lang('users');
            $this->current_section = lang('users');
            $this->table_bd = 'users';
            $state =$this->crud->getState();
            
            $this->firephp->log($state); 
            switch ($state) {
                case 'add':
                case 'insert_validation':
                $this->crud->set_rules($this->rules_users+$this->rules_password);
                break;
                case 'edit':
                $this->firephp->log('edit?');
                $state_info = $this->crud->getStateInfo();
                $this->rules_users['username']['rules'] = sprintf($this->rules_users['username']['rules'],$state_info->primary_key);
                $this->rules_users['email']['rules'] = sprintf($this->rules_users['email']['rules'],$state_info->primary_key);
                $this->crud
                     
                     ->field_type('username','readonly')
                     ->field_type('email','readonly');
                break;
                default:
                $this->crud
                     ->set_rules($this->rules_users);
                     
                    
            } 
              
                    
            $this->crud
                 ->columns('name','surname','username','email','group_id','skype')
                 ->fields('name','surname','username','email','group_id','skype','pass','pass_confirm')
                 ->set_relation('group_id','users_groups','description')
                 //->set_rules($this->rules_users)
                 ->field_type('pass','password')
                 ->callback_insert(array($this, '_db_insert_users'))
                 ->callback_before_update(array($this, '_db_update_users'))   
                 ->field_type('pass_confirm','password')
                 ->display_as('pass_confirm', lang('pass_confirm'))
                 ->display_as('pass', lang('password'))
                 ->display_as('group_id', lang('group'))
                 ->display_as('username', lang('login'))
                 ->display_as('surname', lang('surname'))
                 ->display_as('name', lang('name'));
            $this->_example_output();
            
     
        
    }
   
    function _db_insert_users($post, $id = null)
   {
             $username = $post[$this->identity];
             $password = trim($post['pass']);
             $id =  $this->ion_auth->register($username, $password, $post['email'], $post);
             return ($id)?true:false;  
   } 
   function _db_update_users($post, $id = null)
   {
        $username = $this->ion_auth
                         ->select('username,email')
                         ->user($id)->row();
        $password = trim($post['pass']);
        if ($password != null) {
            $result = $this->ion_auth->reset_password($username->{$this->identity}, $password);
            if (!$result) {
                return false;
            }
        }
        unset($post['pass']);
        unset($post['pass_confirm']);
        return $post;
   }
}
