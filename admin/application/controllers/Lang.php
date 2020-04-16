<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function _example_output($output = null)
	{
		$this->load->view('admin/blank',(array)$output);
	}

	public function detail()
	{
		try{
			$crud = new grocery_CRUD();

			$get_words = get_table('lang_name');
			$crud->set_table('lang_name');
			$crud->set_subject('Language');
			$crud->required_fields('name');
			$crud->field_type('rtl', 'dropdown',['0'=>'LTR','1'=>'RTL']);
			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function front()
	{
		try{
			$crud = new grocery_CRUD();

			$get_words = get_table('front_lang',['parent'=>'id']);
			$crud->set_table('front_lang');
			$crud->set_subject('Frontend Words');
			$crud->required_fields('text');
			$crud->field_type('lang', 'dropdown',['en'=>'en','ar'=>'ar']);
			$parents[0] = '-';
			foreach ( $get_words as $word ){ 
				$parents[$word->id] = $word->text; 
			}
			$crud->field_type('parent', 'dropdown',$parents);
			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	public function back()
	{
		try{
			$crud = new grocery_CRUD();

			$get_words = get_table('back_lang',['parent'=>'id']);
			$crud->set_table('back_lang');
			$crud->set_subject('Backend Words');
			$crud->required_fields('text');
			$crud->field_type('lang', 'dropdown',['en'=>'en','ar'=>'ar']);
			$parents[0] = '-';
			foreach ( $get_words as $word ){ 
				$parents[$word->id] = $word->text; 
			}
			$crud->field_type('parent', 'dropdown',$parents);
			$output = $crud->render();
			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

}