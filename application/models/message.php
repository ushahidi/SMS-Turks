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
	
	

	static function get_available_messages($limit='1')
	{
		// Get all active categories
		$messages = array();
		foreach (ORM::factory('message')
			->where('status', '0')
			->orderby('received','ASC')
			->limit($limit)
			->find_all() as $msg)
		{
			// Create a list of all categories
			$messages[$msg->id] = array('number'=>$msg->number, 
										'sms'=>$msg->sms, 
										'received'=>$msg->received);
		}
		return $messages;
	}

}
