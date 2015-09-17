<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class Lang extends Admin_Controller
{
  protected $rules_lang = array( 
   'key'=>
    array(
            'field' => 'key',
            'label' => 'lang:key',
            'rules' => 'trim|is_unique[users.username.id.%s]|htmlspecialchars|required|min_length[1]|max_length[255]|encode_php_tags'),
  'group_id'=>
   array(
            'field' => 'group_id',
            'label' => 'lang:group',
            'rules' => 'trim|required|integer|callback__check_lang'),
       
  ); 
  public $primary_key  = null;    
      
   
  public function __construct()
  {
    parent::__construct(); 
    $this->load->model('mod_lang');
    $this->load->library('lang_cache');
    $this->lang_cache->delete_all();
    
   
  }
  
  function index()
  {
    $this->breadcrumbs['admin/lang'] = lang('lang');
    $this->current_section = lang('lang');
    $this->table_bd = 'lang_key';
    $this->filter_fields['text'] = array('encode_php_tags');
    $this->filed_url_generation = 'name';
    $this->get_lang_field();
   
    $state = $this->crud->getState();
    $state_info = $this->crud->getStateInfo();
    
   
    $this->primary_key = isset($state_info->primary_key)?$state_info->primary_key:null;
         
    
    
    //$this->rules_key['key']['rules'] = sprintf($this->rules_key['key']['rules'],$primary_key);
  
    

    
    
    $this->crud
         ->columns('id','values','key','group_id')
         ->fields($this->mod_lang->get_fields())
         ->set_relation('group_id','lang_groups','name')
         ->callback_after_insert(array($this, '_callback_insert'))
         ->callback_after_update(array($this, '_callback_insert'))
         ->callback_column("values",array($this,'_values_callback'))
         ->set_rules($this->rules_lang)
         ->required_fields($this->mod_lang->get_fields())
         ->display_as('group_id', lang('group'))
         ->display_as('key', lang('key'));
    $this->_example_output();
   }


 function _callback_insert($data,$id)
 {
    $this->mod_lang->save($data,$id);  
 }
 function _check_lang($str)
 {

    $name  = $this->input->post('name');
    $key   = $this->input->post('key');
    $group = $this->input->post('group_id');
    
    $data =  $this->mod_lang->get_value_is($name,$key,$group,$this->primary_key);
    
    
    foreach ($data as $k=>$v) {
     if($v['group'])
     {
      $this->form_validation->set_message('_check_lang', sprintf(lang('key exists'),$key,$v['group']));
      return false;
     }
    }
   return true; 
 }
 protected function get_lang_field()
 {
    $lang = $this->mod_lang->get_lang();
    foreach ($lang as $k=>$v) {
    $this->crud
         ->callback_field("name[$v->id]",array($this,'_field_callback'))
         ->display_as("name[$v->id]",sprintf("%s (%s)",lang('name'),$v->name));
  
    }
 }
 function _field_callback($val,$key_id,$value)
 {
    
    
    $data = $this->mod_lang->get_value($key_id,$value->name);
   
    
    return form_input($value->name,$data);
    
  }
 function _values_callback($value,$row)
 {
    $result = '';
    
    $data = $this->mod_lang->get_lang_key_values($row->id);
    foreach ($data as $k=>$v) {
    
        $result .=sprintf('<p>%s  (%s)</p>',$v->value,$v->name);
         
    
    }
    
    return $result;
   
   
 }
 function parser()
 {
    
    $this->load->helper('directory');
    $dir[] = APPPATH.'language/';
    $dir[] = BASEPATH.'language/';
    foreach ($dir as $k=>$v) {
         $map =directory_map($v);
         $this->to_parser($map,$v);
     }
 }
 protected function to_parser($map,$path)
 {
        
        foreach ($map as $ke=>$va) {
            
             $lang_id = $this->mod_lang->get_lang_id($ke);
             if (is_array($va)) {
             foreach ($va as $key=>$val) {
                 $lang = array();
                 $file =  pathinfo($path.$ke.'/'.$val);
                 $group_id = $this->mod_lang->get_group_id($file['filename']);
                 
                 if (array_search('lang', explode('_',$file['filename']))) {
                   @require($path.$ke.'/'.$val);
                   foreach ($lang as $kl=>$vl) {
                     $key_id = $this->mod_lang->get_key_id($kl,$group_id);
                     $this->mod_lang->save_parser($vl,$key_id,$lang_id);
                   }
                 }
               
             }
         }
   
    
    
    }
 }






}
 