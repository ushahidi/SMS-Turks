<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Feed controller for the output 
 *
 *
 * @package    Core
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Feed_Controller extends Main_Feed_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->template->content = new View('feed');
		
		$this->template->title = 'Feed';
		
		$limit='0,20';
		if(isset($_POST['limit'])) $limit = $_POST['limit'];
		
		$messages = Message_Model::get_translated_messages($limit);
		
		$info = array('notes' => 'This is an RSS feed of the translated SMS messages.');
		
		$items = array();
		foreach($messages as $id => $msg){
			$items[] = array(
				'title' => string_manipulation::xmlentities($msg['sms']),
		        'link' => 'http://localhost:8888/SMSTurks/feed/'.$id,
		        'description' => string_manipulation::xmlentities($msg['translation']),
		        'author' => $msg['number'],
		        'pubDate' => date('D, d M Y H:i:s O', strtotime($msg['received'])),
				);
		}
		
		$this->template->content->display = feed::create($info, $items);
	}

} // End Task Controller