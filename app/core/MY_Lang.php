<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Lang extends CI_Lang {
	var $language	= array();
	var $is_loaded	= array();

	function __construct()
	{
	    
		log_message('debug', "Language Class Initialized");
	}

	function load($langfile = '', $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '')
	{
	    $this->CI =& get_instance();
        $this->CI->load->library('lang_cache'); 
           
           
        if (is_array($langfile))
		{
			foreach ($langfile as $value)
			{
				$this->load($value, $idiom, $return, $add_suffix, $alt_path);
			}

			return;
		}
       
		$langfile = str_replace('.php', '', $langfile);

		if ($add_suffix == TRUE)
		{
			$langfile = str_replace('_lang.', '', $langfile).'_lang';
		}
        
    	

        
		if (in_array($langfile, $this->is_loaded, TRUE))
		{
			return;
		}

		$config =& get_config();

		if ($idiom == '')
		{
			$deft_lang = ( ! isset($config['language'])) ? 'english' : $config['language'];
			$idiom = ($deft_lang == '') ? 'english' : $deft_lang;
		}
        if($langfile == 'db_lang')
           $lang= parent::load($langfile,$idiom,true);
        else
           $lang = $this->CI->lang_cache->get_lang($idiom, $langfile);
        
               
	
        
        
        
 
      	if ( ! isset($lang))
		{
			log_message('error', 'Language file contains no data: language/'.$idiom.'/'.$langfile);
			return;
		}

		if ($return == TRUE)
		{
			return $lang;
		}
        
		$this->is_loaded[] = $langfile;
		$this->language = array_merge($this->language, $lang);
		unset($lang);

		log_message('debug', 'Language file loaded: language/'.$idiom.'/'.$langfile);
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch a single line of text from the language array
	 *
	 * @access	public
	 * @param	string	$line	the language line
	 * @return	string
	 */
	public function line($line, $log_errors = TRUE)
	{
		$value = isset($this->language[$line]) ? $this->language[$line] : FALSE;

		// Because killer robots like unicorns!
		if ($value === FALSE && $log_errors === TRUE)
		{
			log_message('error', 'Could not find the language line "'.$line.'"');
		}

		return $value;
	}






}
// END Language Class

/* End of file Lang.php */
/* Location: ./system/core/Lang.php */
