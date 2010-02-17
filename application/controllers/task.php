<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Task controller for the work queue 
 *
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Task_Controller extends Main_Controller {
	
	/*public function __construct()
	{
		parent::__construct();
	}*/

	public function index()
	{
	
		$this->template->content = new View('task');
		
		$this->template->title = 'SMS Task Queue';
		
		$this->template->content->message = Message_Model::get_oldest_available_message();
		
		// If there are no messages, pass "null"
		if(count($this->template->content->message) == 0) $this->template->content->message = NULL;
		
	}

} // End Task Controller