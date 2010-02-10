<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Model for reported Incidents
 *
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Incident Model
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */

class Message_Model extends ORM
{
	
	// Database table name
	protected $table_name = 'messages';
	
	public function get_oldest_available_message($lock=1)
	{
		// Get all active categories
		$messages = array();
		foreach (ORM::factory('message')
			->where('status', '0')
			->orderby('received','ASC')
			->limit(1)
			->find_all() as $msg)
		{
			// Create a list of all categories
			$messages[$msg->id] = array('number'=>$msg->number, 
										'sms'=>$msg->sms,
										'translation'=>$msg->translation,
										'notes'=>$msg->notes,
										'received'=>$msg->received,
										'updated'=>$msg->updated);
										
			if($lock == 1) Message_Model::lock_message($msg->id);
		}
		return $messages;
	}
	
	static function get_translated_messages($limit='0,20')
	{
		// Set up limit
		$start = 0;
		if(strpos($limit,',')) {
			$limit = explode(',',$limit);
			$rows = $limit[0];
			$start = $limit[1];
		}

		// Get all active categories
		$messages = array();
		foreach (ORM::factory('message')
			->where('status', '2')
			->orderby('received','DESC')
			->limit($start,$rows)
			->find_all() as $msg)
		{
			// Create a list of all categories
			$messages[$msg->id] = array('number'=>$msg->number, 
										'sms'=>$msg->sms,
										'translation'=>$msg->translation,
										'notes'=>$msg->notes,
										'received'=>$msg->received,
										'updated'=>$msg->updated);
		}
		return $messages;	
	}
	
	static function update_translation($id,$translation)
	{
		$time = time::db_timestamp();
		$message = ORM::factory('message',$id);
		$message->translation = $translation;
		$message->updated = $time;
		$message->status = 2;
		return $message->save();
	}
	
	private function lock_message($id)
	{
		$time = time::db_timestamp();
		$message = ORM::factory('message',$id);
		$message->status = 1;
		$message->updated = $time;
		return $message->save();
	}
	
	static function unlock_message($id)
	{
		$time = time::db_timestamp();
		$message = ORM::factory('message',$id);
		$message->status = 0;
		$message->updated = $time;
		return $message->save();
	}
	
	static function get_queue_count()
	{
		return ORM::factory('message')
			->where('status', '0')
			->count_all();
	}
	
	static function add_message($number,$sms){
		$time = time::db_timestamp();
		$message = ORM::factory('message');
		$message->number = $number;
		$message->sms = $sms;
		$message->received = $time;
		$message->updated = $time;
		return $message->save();
	}

}
