<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class Lang_cache
{
  private $default_expires;
  private $cache;
  private $switch_cache = true;
    
  function __construct()
  {
    $this->_ci = &get_instance();
    $this->_ci->load->database();
    $this->default_expires = 600;
    $this->_ci->load->driver('cache');
    //$this->cache = $this->_ci->cache->memcached;
    $this->cache = $this->_ci->cache->file;
      
  }
  public function get_lang($idiom, $group,$expires=null)
  {
    if ($expires == null) {
            $expires = $this->default_expires;
    }

    $cache_key =  md5($idiom.$group);
    
    
    $cached_response = $this->cache->get($cache_key);
    
    
    
    if ($cached_response == true && $this->switch_cache) {
            return $cached_response;
    }
    
    
    $lang = array();
    
    $data = $this->_ci->db
                      ->select('lk.key,lv.value')
                      ->from('lang l')
                      ->join('lang_value lv', 'l.id=lv.lang_id')
                      ->join('lang_key lk', 'lk.id=lv.key_id')
                      ->join('lang_groups lg', 'lg.id=lk.group_id')
                      ->where('l.name', $idiom)
                      ->where('lg.name', $group)
                      ->get()
                      ->result();
                      
    foreach ($data as $k => $v)
    {
      $lang[$v->key] = $v->value;
    }
    $this->cache->save($cache_key, $lang, $expires);
    return $lang; 
  }
  
  public function delete_all()
	{
	   $this->cache->clean();  
	}
}
