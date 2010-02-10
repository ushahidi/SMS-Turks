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
class Main_Feed_Controller extends Template_Controller {

	public $template = 'template_feed';
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// keep it here for good measure
	}

}