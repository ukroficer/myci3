<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class News extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct(); 
  }

  function index()
  {
    $this->breadcrumbs['admin/news'] = lang('news');
    $this->current_section = lang('news');
    $this->table_bd = 'news';
    $this->crud
         ->columns('name','cat_id','text','date','status')
         ->fields('name','keywords','description','cat_id','shorttext','text','uri','date','useful','status')
         ->set_relation('cat_id','news_cat','name')
         
         ->required_fields('name','text','shorttext','date','status')
         ->callback_before_insert(array($this, '_callback_filter'))
         ->callback_before_update(array($this, '_callback_filter'))
         ->display_as('img', lang('img'))
         ->field_type('useful', 'true_false')
         ->display_as('useful', lang('useful'))
         ->display_as('date', lang('date'))
         ->display_as('name', lang('name'));
    $this->_example_output();
  }


}
