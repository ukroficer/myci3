<?php
/**
 * @author Roman
 * @copyright 2013
 * @email ukroficer#mail.ru
 */
if (!function_exists('image_thumb')) {
    function image_thumb($file, $width = 100, $height = 100, $crop = false, $pad = false,$text='No image')
    {
        $file = trim($file,'/');
        $pathinfo = pathinfo($file);
       
        if (!isset($pathinfo['extension'])) {
            return "http://placehold.it/$width&text=".$text;
        }
        $dir  = $pathinfo['dirname'].DIRECTORY_SEPARATOR.'thumb';
        if(!file_exists($dir))
        {
            @mkdir($dir);
        }
        
        $namefile = $pathinfo['filename'].'-'.(int)$crop.'-'.(int)$pad.'-'.$width.'-'.$height.'.'.$pathinfo['extension'];
        
       

       
        $filepath = $dir.DIRECTORY_SEPARATOR.$namefile;
        if (file_exists($filepath)) {
            return site_url($filepath);
        } else {
                $CI = &get_instance();
                $CI->load->library('image_moo');
                $CI->image_moo->jpeg_quality = 100;
                $CI->image_moo->background_colour = "#000000";
                
                
                if ($crop === false) {
                    $CI->image_moo
                    ->load($file)
                    ->resize($width, $height, $pad)
                    ->save($filepath, true);
                } else {
                    $CI->image_moo
                    ->load($file)
                    ->resize_crop($width, $height)
                    ->save($filepath, true);
                }
           
        }
        if(file_exists($filepath))
        {
          return site_url($filepath);  
        }
        else
        {
          return "http://placehold.it/$width x $height&text=".$text;  
        }
    
    }
}




?>