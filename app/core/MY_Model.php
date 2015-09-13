<?php
class MY_Model extends CI_Model
{
    public $time_online = 90;

    public function __construct()
    {
        parent::__construct();
    }  
    public function get_list_fields($table,$field = 'name', $first_null = true,$key = 'id')
    {
         $result = $this->db
                        ->get($table)
                        ->result();
         return $this->get_list($result,'name');
    }
    public function get_setting($field)
    {
       $result =  $this->db
       ->select('id,value,field,end')
       ->where('field',$field) 
       ->get('settings')
       ->row();
       return $result; 
    }
    public function get_setting_value($field)
    {
       $result =  $this->db
       ->select("id,value,field,end")
       ->where('field',$field) 
       ->get('settings')
       ->row();
      if($result == null)
      {
        return null;
      }
       return $result->value; 
    } 
    function get_list($obj, $field = 'name', $first_null = true,$key = 'id')
    {
        $data = array();
        if ($first_null) {
            $data[null] = null;
        }

        foreach ($obj as $k => $v) {
            $data[$v->{$key}] = $v->{$field};
        }
        asort($data);

        return $data;
    }
    public function check_fields_bd($array, $table)
    {
        $fields = $this->db->list_fields($table);
        $data = array();
        foreach ($array as $k => $v) {
            if (in_array($k, $fields)) {
                $data[$k] = $v;
            }
        }
        return $data;
    }
    function get_is_uri($name, $uri, $tb, $id = 'null')
    {
        $uri = trim($uri);
        $uri = ltrim($uri,'page');
        if (empty($uri)) {
             $uri = url_title(mb_strtolower(convert_accented_characters(trim($name))));
        } else {
            $uri = url_title(mb_strtolower(convert_accented_characters($uri)));
        }
        $i = 0;
        $uris = $uri;
        $unuri = $this->uri_is($uri, $tb, $id);
        while ($unuri > 0) {
            $i++;
            $uris = $uri . '_' . $i;
            $unuri = $this->uri_is($uris, $tb, $id);
        }
        return $uris;
    }

    private function uri_is($uri, $tb, $id = 'null')
    {
        return $this->db->where('id !=', $id)->where('uri', $uri)->get($tb)->num_rows();
    }


}
