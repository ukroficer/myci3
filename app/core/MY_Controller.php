<?php defined('BASEPATH') or exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
    
    public $group_id = null;
    public $user = null;
    public $menu;
    public function __construct()
    {
        parent::__construct(); 
        if ($this->input->is_ajax_request()) 
            $this->output->enable_profiler(false);
        else 
            $this->output->enable_profiler(true);
        $this->user =  $this->ion_auth->user()->row();
        $this->group_id = $this->session ->userdata('group_id');
        $this->menu = array();
        $this->tpl
             ->set('messages',$this->session->flashdata('messages'));
    }

}


class Admin_Controller extends MY_Controller
{

    public $data; //Данные вида
    public $current_section; //Текущая страница
    public $breadcrumbs = array(); //Хлебный крошки
    
    public $filter_fields = array();
    public $js_files = array();
    public $css_files = array();
    public $table_bd;
    public $filed_url_generation = 'name';
    public $unset_field = array();
    

    function __construct()
    {
        parent::__construct();
        if ($this->ion_auth->logged_in()==false||$this->group_id!=1) {
            redirect('admin/auth'); 
        }           
        $this->load->model('mod_admin');
        $this->data =  new stdClass();
        $this->breadcrumbs['admin'] = lang('admin panel');
        $this->load->library('grocery_CRUD');        
        $this->crud = new grocery_CRUD(); //Подключаю CRUD
        $this->load->model('mod_admin', 'mod_admin', true);
        $this->crud->set_theme('datatables');
        $this->crud->display_as('description', lang('description'));
        $this->crud->display_as('keywords', lang('keywords'));
        $this->crud->display_as('status', lang('status'));
        $this->crud->field_type('status', 'true_false');
        $this->crud->display_as('date', lang('date'));
        $this->crud->display_as('text', lang('text'));
        $this->crud->display_as('announce', lang('announce'));
        $this->crud->display_as('uri', lang('uri'));
        $this->menu = array(
            ''=>lang('path site'), 
            'admin'=>lang('admin panel'),
            'admin/users'=>lang('users'),
            'admin/lang'=>lang('lang'),
            'admin/news'=>lang('news'),
            'admin/settings'=>lang('settings'),
            'admin/pages'=>lang('pages'),
        );
    }
    function _example_output()
    {
        $this->crud->set_table($this->table_bd);
        $this->data = $this->crud->render();
        $this->data->group_id = $this->group_id;
        $this->data->old_action = $this->crud->getState();
        $this->data->breadcrumbs = $this->breadcrumbs;
        $this->data->current_section = $this->current_section;
        $this->data->js_files = $this->data->js_files + $this->js_files;
        $this->data->css_files = $this->data->css_files + $this->css_files;
        $this->data->menu = $this->menu;
        $this->data->user = $this->user;
        $this->load->view('admin/main', $this->data); 
     }
    public function _callback_filter($data, $id = 'null')
    {
        
         if (isset($data['uri'])) {
         $data['uri'] = $this->mod_admin->get_is_uri($data[$this->filed_url_generation], $data['uri'], $this->
                table_bd, $id);
        }
                foreach ($data as $k => &$v) {
 if (array_key_exists($k, $this->filter_fields)) {
                $filters = $this->filter_fields[$k];
                foreach ($filters as $key => $val) {
                    if (function_exists($val) and $val != 'htmlspecialchars') {
                        eval("\$data[\$k]  = \$val(\$v);");
                                       } elseif (function_exists($val) and $val == 'htmlspecialchars') {
                 
                        $data[$k] = htmlspecialchars($v, ENT_QUOTES);
                        
                    }
                  
                }


            }
       
       if(!is_array($v))
       {
         $data[$k] = $this->encode_php_tags(trim($v));
       }     
       else
       {
        foreach ($v as $ks=>$vs) {
          $data[$k][$ks] = $this->encode_php_tags(trim($vs));
        }
       }
         } 
        foreach ($this->unset_field as $key=>$val) {
        unset($data[$val]);
       }
         
           return $data;
    }
  
    
   
    public function encode_php_tags($str)
	{
		return str_replace(array('<?php', '<?PHP', '<?', '?>'),  array('&lt;?php', '&lt;?PHP', '&lt;?', '?&gt;'), $str);
	}
}

class Public_Controller extends MY_Controller
 {

    public $offset = null;
    public $online = false; 
    function __construct()
    {
       parent::__construct();
       $this->online = $this->ion_auth->logged_in()&&$this->group_id == 2;
       $this->load->model('mod_main');
       $this->menu = array();
       $this->per = 16;
       $this->tpl
            ->set('menu',$this->menu)
            ->set('active',null)
            ->set_breadcrumbs(array())
            ->set('online',$this->online)
            ->set('content',null)
            ->set('settings',$this->mod_main->settings())
            ->set('title',$this->mod_main->get_setting_value('title'))
            ->set('keywords',$this->mod_main->get_setting_value('keywords'))
            ->set('description',$this->mod_main->get_setting_value('description'))
            ->set('messages',$this->session->flashdata('messages'))
            ->set('user',$this->user);
    
      }
 }   