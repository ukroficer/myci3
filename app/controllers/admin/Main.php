<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
/**
 * @author roman(ukroficer@mail.ru)
 * @copyright 2013
 */
class Main extends Admin_Controller
{
   public function index()
  {

     $this->tpl
          ->js_files('assets/grocery_crud/js/jquery-1.11.2.min')
          ->set('current_section',lang('admin panel'))
          ->set('breadcrumbs',$this->breadcrumbs)
          ->set('menu',$this->menu)
          ->set('user',$this->user)
          ->set('group_id',$this->group_id)
          ->set('output','')
          ->build('admin/main');

  }

}
