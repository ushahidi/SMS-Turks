<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Main controller for the work queue 
 *
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Main_Controller extends Template_Controller {

	public $template = 'layout';
	
	public function __construct()
	{
		parent::__construct();
		
		// Process POST
		if($_POST) $this->process_post($_POST);
		
		// Set up queue box
		$this->template->queue_box = new View('queue_box');
		$this->template->queue_box->count = Message_Model::get_queue_count();
	}

	public function index()
	{
		// keep it here for good measure
		echo 'main index';
	}
	
	public function process_post($post)
	{		
		$post = new Validation($post);
		$post->add_rules('form', 'required');
		
		if($post->validate()){
			switch($post->form){
				case 'update_translation':
					$post->add_rules('id', 'numeric');
					if($post->validate()) Message_Model::update_translation($post->id,$post->translation);
					break;
			}
		}else{
			echo 'FAILED VALIDATION';
		}
	}

} // End Task Controller