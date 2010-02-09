<?php defined('SYSPATH') or die('No direct script access.');

if (Debug_Toolbar::is_enabled())
{
	// Allows the debug toolbar to inject itsself into the html
	Event::add('system.display', array('Debug_Toolbar', 'render'));
}