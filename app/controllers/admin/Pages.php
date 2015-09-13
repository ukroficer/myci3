<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class Pages extends Admin_Controller
{
  public function __construct()
  {
    parent::__construct(); 
  }

  function index()
  {
    $this->breadcrumbs['admin/pages'] = lang('pages');
    $this->current_section = lang('pages');
    $this->table_bd = 'pages';
    $this->filter_fields['text'] = array('encode_php_tags');
     
    $this->crud
         ->columns('name','uri','status')
         ->add_fields('keywords','description','name','text','uri')
         ->edit_fields('keywords','description','name','text')
         ->callback_before_insert(array($this, '_callback_filter'))
         ->callback_before_update(array($this, '_callback_filter'))
         ->required_fields('name','keywords','description','text','status')
         ->display_as('name', lang('name'));
    $this->_example_output();
  }














}
