<?php
    
   function delete_dir_wc($dir)
    {
        $CI = &get_instance();
        $CI->load->helper('directory');
        $map = directory_map($dir);
        foreach ($map as $k => $v) {

            if (is_array($v)) {

                delete_dir_wc($dir . DIRECTORY_SEPARATOR . $k);
            } else {
                @unlink($dir . DIRECTORY_SEPARATOR . $v);
            }

        }
        @rmdir($dir);
    }  



if (!function_exists('mb_ucfirst') && extension_loaded('mbstring'))
{
    /**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
    function mb_ucfirst($str, $encoding='UTF-8')
    {
      $fc = mb_strtoupper(mb_substr($str, 0, 1));
      return $fc.mb_substr($str, 1);
    }
}










?>