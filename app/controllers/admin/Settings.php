<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * @author roman(ukroficer@mail.ru)
 * @copyright 2013
 */
class Settings extends Admin_Controller
{
     public function __construct()
  {
    parent::__construct(); 

  }
    
    
    public function index($uri = 'null', $id = 'null')
    {
        if ($uri === 'upload_file') {
            $this->crud
                 ->set_field_upload('value', 'upls/settings');
        }       
        $this->breadcrumbs['admin/settings'] = lang('settings');
        $this->current_section = lang('settinsg');
        $this->crud
        ->unset_add()
        ->unset_delete()
        ->field_type('name', 'readonly')
        ->columns('name', 'value')
        ->fields('name', 'value','end')
        ->display_as('name', lang('name setting'))
        ->display_as('value', lang('value'))
        ->display_as('end', lang('end'));
    
        
        $this->get_type_fields($this->crud->getStateInfo());
        
        $this->table_bd = 'settings';
        $this->_example_output();
    }

    function banners()
  {
    $this->breadcrumbs['admin/settings'] = lang('settings');
    $this->breadcrumbs['admin/banner'] = lang('banner');
    $this->current_section = lang('banner');
    $this->table_bd = 'banners';
    $this->filter_fields['text'] = array('encode_php_tags');
     
    $this->crud
    ->columns('file','link','date','status')
    ->fields('name','file','link','date','status')
    ->set_field_upload('file', 'upls/banners')
    ->required_fields('file','link','date','status')
    ->display_as('name', lang('name'));
    $this->_example_output();
  }
   function categories()
  {
    $this->breadcrumbs['admin/settings'] = lang('settings');
    $this->breadcrumbs['admin/settings/categories'] = lang('categories');
    $this->current_section = lang('categories');
    $this->table_bd = 'categories';
    $this->filter_fields['text'] = array('encode_php_tags');
     
    $this->crud
    ->columns('img','index_img','name','main','uri')
    ->fields('img','index_img','name','text','main','uri')
    ->field_type('main', 'true_false')
    ->set_field_upload('img', 'upls/categories')
    ->set_field_upload('index_img', 'upls/categories')
    ->required_fields('name','main','index_img')
    ->set_rules('main','main','callback__check_main')
    ->callback_before_insert(array($this, '_callback_filter'))
    ->callback_before_update(array($this, '_callback_filter'))
    ->display_as('index_img', lang('index_img'))
    ->display_as('name', lang('name'));
    $this->_example_output();
  } 
     function tags()
  {
    $this->breadcrumbs['admin/settings'] = lang('settings');
    $this->breadcrumbs['admin/settings/tags'] = lang('tags');
    $this->current_section = lang('tags');
    $this->table_bd = 'tags';
    $this->filter_fields['text'] = array('encode_php_tags');
     
    $this->crud
    ->columns('name','uri')
    ->fields('name','uri')
    ->required_fields('name')
    ->callback_before_insert(array($this, '_callback_filter'))
    ->callback_before_update(array($this, '_callback_filter'))
    ->display_as('name', lang('name'));
    $this->_example_output();
  }   
    protected function get_type_fields($obj)
    {//set_relation_n_n[favorite_jurist,users,setting_id,user_id,name,order_id]
        $id = isset($obj->primary_key) ? $obj->primary_key : 'null';
        $field = $this->db->where('id', $id)->get('settings')->row();
        if (!empty($field)) {
                 switch ($field->type) {
                   case 'file':
                   $this->crud
                        ->set_field_upload('value', 'upls/settings');
                    break;
                    case 'minitext':
                    $this->config->load('grocery_crud');
                    $this->config->set_item('grocery_crud_text_editor_type', 'minimal');
                    break;
                    case 'field':
                    $this->crud
                    ->field_type('value','string');
                    break;
                    case (bool)preg_match_all('|set_relation_n_n\[(.*),(.*),(.*),(.*),(.*),(.*)\]|', $field->type, $matches):
                    $this->crud
                    ->set_relation_n_n('value', $matches[1][0], $matches[2][0], $matches[3][0],$matches[4][0], $matches[5][0],$matches[6][0]);
                    break;
                    default:
                    $this->crud
                   ->field_type('value','text');
                }
               
            
            
            
          
        }
    }
    function _check_main($str = null)
    {
        $img = $this->input->post('img');
        
        
        
        
        if($str == '1'&&$img == null)
        {
            $this->form_validation->set_message('_check_main', lang('check_main_img'));
            return false;
        }
        return true;
    }
    

}
