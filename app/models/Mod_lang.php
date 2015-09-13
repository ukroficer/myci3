<?php
class Mod_lang extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }   
    function save_parser($vl,$key_id,$lang_id)
    {
        $data = $this->db
                     ->where('key_id',$key_id)
                     ->where('lang_id',$lang_id)
                     ->from('lang_value')
                     ->get()
                     ->row();  
       if($data == null)
       {
                $this->db
                     ->set('key_id',$key_id)
                     ->set('lang_id',$lang_id)
                     ->set('value',$vl)
                     ->insert('lang_value');
            
       } 
       else
       {
                $this->db
                     ->where('key_id',$key_id)
                     ->where('lang_id',$lang_id)
                     ->set('value',$vl)
                     ->update('lang_value');
       }
    }
    
    
    
    function get_key_id($key,$group_id)
    {
       $data = $this->db
                         ->from('lang_key')
                         ->where('group_id',$group_id)
                         ->where('key',$key)
                         ->get()
                         ->row();
       if($data == null)
       {
        $this->db
             ->set('key',$key)
             ->set('group_id',$group_id)
             ->insert('lang_key');
        return $this->db->insert_id();     
       } 
       
       return $data->id;           
    }   
    function get_group_id($group)
    {
        $data = $this->db
                         ->from('lang_groups')
                         ->where('name',$group)
                         ->get()
                         ->row();
       if($data == null)
       {
        $this->db
             ->set('name',$group)
             ->insert('lang_groups');
        return $this->db->insert_id();     
       } 
       
       return $data->id;                 
    }
    function get_lang_id($lang)
    {
        $data = $this->db
                         ->from('lang')
                         ->where('name',$lang)
                         ->get()
                         ->row();
       if($data == null)
       {
        $this->db
             ->set('name',$lang)
             ->insert('lang');
        return $this->db->insert_id();     
       } 
       
       return $data->id;                 
    }
    public function get_lang_key_values($id)
    {
       return       $this->db
                         ->select('l.name,lv.value')
                         ->from('lang l')
                         ->join('lang_value lv','lv.lang_id = l.id')
                         ->where('lv.key_id',$id)
                         ->get()
                         ->result();   
    }
    public function get_lang()
    {
        return  $this->db
                         ->from('lang')
                         ->get()
                         ->result();
                        
    }
    public function get_fields()
    {
     $data[] = 'key';
     $data[] = 'group_id';
     $lang = $this->get_lang();
     foreach ($lang as $k=>$v) {
     $data[] = "name[$v->id]";
     }
    
    return $data;
     
    }
    public function save($data,$id)
    {
        $this->db
             ->where('key_id',$id)
             ->delete('lang_value');
        foreach ($data['name'] as $k=>$v) {
          $this->db
               ->set('value',$v)
               ->set('key_id',$id)
               ->set('lang_id',$k)
               ->insert('lang_value');
        }
    }
    public function get_value($id,$value)
    {
      
        $lang =  preg_replace("|\D|", '', $value);
        $data = $this->db
                     ->where('key_id',$id)
                     ->where('lang_id',$lang)
                     ->from('lang_value')
                     ->get()
                     ->row();
                    
        return is_object($data)?$data->value:null;             
        
    }
    
}