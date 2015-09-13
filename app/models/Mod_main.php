<?php
class Mod_main extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    } 
    public function get_categories()
    {
        return  $this->db
                     ->order_by('order_id')
                     ->get('categories')
                     ->result();  
    }
    public function get_types()
    {
        return  $this->db
                     ->order_by('name')
                     ->get('types')
                     ->result();  
    }
    public function get_list_pages()
    {
        return   $this->db
                     ->select("p.*")
                     ->from('pages p')
                     ->where('status','1')
                     ->get()
                     ->result(); 
    }
    public function get_page($uri)
    {
        return $this->db
                    ->select('p.*')
                    ->where('uri',$uri)
                    ->from('pages p')
                    ->get()
                    ->row();
              
    }
    public function settings()
    {
       $data = (object)array();
       $result =  $this->db
                       ->select("field,value,end")
                       ->where('autoload','1') 
                       ->get('settings')
                       ->result();
       foreach($result as $k=>$v)
       {
         $data->{$v->field} = $v->value.$v->end;
       }
       return $data;
    }

 
}
