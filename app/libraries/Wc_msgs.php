<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Wc_msgs {
    public $start_message_delimiter   = '<p class="message_successful_wc">';
    public $end_message_delimiter    = '</p>';
    public $start_error_delimiter   = '<p class="message_error_wc">';
    public $end_error_delimiter    = '</p>';
    
  
    
    public function __construct()
    {
       $this->ci = &get_instance(); 
    }
    public function get_error($error)
    {
        return $this->start_error_delimiter.$error.$this->end_error_delimiter;
    }
    public function get_message($message)
    {
 
        return $this->start_message_delimiter.$message.$this->end_message_delimiter;
    }
    public function set_message($message)
    {
        $this->ci->session->set_flashdata('messages', $this->get_message($message));
    }
    public function set_error($error)
    {
        $this->ci->session->set_flashdata('messages', $this->get_error($error));
    }

}



