<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Copyright (c) 2009 Aaron Forsander <aaron.forsander@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 * 
*/

/**
 * Icons taken from the wonderful work of Mark James.
 *
 * More information available at:
 * http://www.famfamfam.com/lab/icons/silk/
 */

/**
 * Displays a debug toolbar at the top of the rendered web page.
 * 
 * For more information see: http://projects.kohanaphp.com/projects/show/kohana-debug-toolbar
 * 
 * @copyright   Copyright (C) 2009 Aaron Forsander
 * @author      Aaron Forsander <aaron.forsander@gmail.com>
 * @package     Debug_Toolbar_Core
 */
class Debug_Toolbar_Core {

	// Stores system.log events
	public static $logs = array();
	
	// Name for debug toolbar's benchmark
	public static $benchmark_name = 'debug_toolbar';
	
	/**
	 * Renders the Debug Toolbar
	 *
	 * @param bool print rendered output
	 * @return string debug toolbar rendered output
	 */
	public static function render($print = false) 
	{
		Benchmark::start(self::$benchmark_name);
		
		$template = new View('toolbar');
		
		// Database panel
		if (Kohana::config('debug_toolbar.panels.database') === TRUE)
		{
			$template->set('queries', self::get_queries());
		}
		
		// Logs panel
		if (Kohana::config('debug_toolbar.panels.logs') === TRUE)
		{
			$template->set('logs', self::get_logs());
		}
		
		// Vars and Config panel
		if (Kohana::config('debug_toolbar.panels.vars_and_config') === TRUE)
		{
			$template->set('configs', self::get_configs());
		}
		
		// Files panel
		if (Kohana::config('debug_toolbar.panels.files') === TRUE)
		{
			$template->set('files', self::get_files());
		}
		
		// FirePHP
		if (Kohana::config('debug_toolbar.firephp_enabled') === TRUE)
		{
			self::firephp();
		}
		
		// Set alignment for toolbar
		switch (Kohana::config('debug_toolbar.align'))
		{
			case 'right':
			case 'center':
			case 'left':
				$template->set('align', Kohana::config('debug_toolbar.align'));
				break;
			default:
				$template->set('align', 'left');				
		}
		
		// Javascript for toolbar
		$template->set('scripts', file_get_contents(Kohana::find_file('views', 'toolbar', TRUE, 'js')));
		
		// CSS for toolbar
		$styles = file_get_contents(Kohana::find_file('views', 'toolbar', FALSE, 'css'));
		
		Benchmark::stop(self::$benchmark_name);
		
		// Benchmarks panel
		if (Kohana::config('debug_toolbar.panels.benchmarks') === TRUE)
		{
			$template->set('benchmarks', self::get_benchmarks());
		}
		
		if (Event::$data and self::is_enabled())
		{
			// Try to add css just before the </head> tag
			if (stripos(Event::$data, '</head>') !== FALSE)
			{
				Event::$data = str_ireplace('</head>', $styles.'</head>', Event::$data);
			}
			else
			{
				// No </head> tag found, append styles to output
				$template->set('styles', $styles);
			}
			
			// Try to add js and HTML just before the </body> tag
			if (stripos(Event::$data, '</body>') !== FALSE)
			{
				Event::$data = str_ireplace('</body>', $template->render().'</body>', Event::$data);
			}
			else
			{
				// Closing <body> tag not found, just append toolbar to output
				Event::$data .= $template->render();
			}
		}
		else
		{
			$template->set('styles', $styles);
			
			return $template->render($print);
		}
	}
	
	/**
	 * Hooks the system.log event to catch all log messages 
	 */
	public static function log() 
	{
		self::$logs[] = Event::$data;
	}
	
	/**
	 * Retrieves all Kohana logs captured by system.log
	 */
	public static function get_logs()
	{
		return self::$logs;
	}
	
	/**
	 * Retrieves query benchmarks from Database
	 */
	public static function get_queries()
	{
		return Database::$benchmarks;
	}
	
	/**
	 * Creates a formatted array of all Benchmarks
	 *
	 * @return array formatted benchmarks
	 */
	public static function get_benchmarks()
	{
		$benchmarks = array();
		foreach ((array)Benchmark::get(TRUE) as $name => $benchmark)
		{
			$benchmarks[$name] = array(
				'name'   => ucwords(str_replace(array('_', '-'), ' ', str_replace(SYSTEM_BENCHMARK.'_', '', $name))),
				'time'   => $benchmark['time'],
				'memory' => $benchmark['memory']
			);
		}
		$benchmarks = array_slice($benchmarks, 1) + array_slice($benchmarks, 0, 1);
		return $benchmarks;
	}
	
	/**
	 * Get config data
	 *
	 * @return array all configs included by Kohana
	 */
	private static function get_configs() 
	{	
		if (Kohana::config('debug_toolbar.skip_configs') === TRUE)
			return array();
		
		$inc_paths = Kohana::include_paths();
		$configs = array();
		
		foreach ((array)$inc_paths as $inc_path)
		{
			foreach ((array)glob($inc_path.'/config/*.php') as $filename) 
			{
				$filename = pathinfo($filename, PATHINFO_FILENAME);
				
				if (in_array($filename, (array)Kohana::config('debug_toolbar.skip_configs')))
					continue;
				
				if (!isset($configs[$filename]))
				{
					$configs[$filename] = Kohana::Config($filename);
				}
			}
		}
		return $configs;
	}
	
	/**
	 * Get list of included files
	 *
	 * @return array file currently included by php
	 */
	public static function get_files()
	{
		$files = (array)get_included_files();
		sort($files);
		return $files;
	}
	
	/**
	 * Add toolbar data to FirePHP console
	 */
	private static function firephp()
	{
		$firephp = FirePHP::getInstance(TRUE);
		$firephp->fb('KOHANA DEBUG TOOLBAR:');
		
		// Globals
		$globals = array(
			'Post'    => empty($_POST)    ? array() : $_POST,
			'Get'     => empty($_GET)     ? array() : $_GET,
			'Cookie'  => empty($_COOKIE)  ? array() : $_COOKIE,
			'Session' => empty($_SESSION) ? array() : $_SESSION
		);
		
		foreach ($globals as $name => $global)
		{
			$table = array();
			$table[] = array($name,'Value');
			
			foreach((array)$global as $key => $value)
			{
				if (is_object($value))
				{
					$value = get_class($value).' [object]';
				}
					
				$table[] = array($key, $value);
			}
			
			$message = "$name: ".count($global).' variables';
			
			$firephp->fb(array($message, $table), FirePHP::TABLE);
		}
		
		// Database
		$queries = self::get_queries();
		
		$total_time = $total_rows = 0;
		$table = array();
		$table[] = array('SQL Statement','Time','Rows');
		
		foreach ((array)$queries as $query)
		{
			$table[] = array(
				str_replace("\n",' ',$query['query']), 
				number_format($query['time'], 3), 
				$query['rows']
			);
			
			$total_time += $query['time'];
			$total_rows += $query['rows'];
		}
		
		$message = 'Queries: '.count($queries).' SQL queries took '.
			number_format($total_time, 3).' seconds and returned '.$total_rows.' rows';
		
		$firephp->fb(array($message, $table), FirePHP::TABLE);
		
		// Benchmarks
		$benchmarks = self::get_benchmarks();
		
		$table = array();
		$table[] = array('Benchmark', 'Time', 'Memory');
		
		foreach ((array)$benchmarks as $name => $benchmark)
		{			
			$table[] = array(
				ucwords(str_replace(array('_', '-'), ' ', str_replace(SYSTEM_BENCHMARK.'_', '', $name))), 
				number_format($benchmark['time'], 3). ' s', 
				text::bytes($benchmark['memory'])
			);
		}
		
		$message = 'Benchmarks: '.count($benchmarks).' benchmarks took '.
			number_format($benchmark['time'], 3).' seconds and used up '.
			text::bytes($benchmark['memory']).' memory';
		
		$firephp->fb(array($message, $table), FirePHP::TABLE); 
	}
	
	/**
	 * Determines if all the conditions are correct to display the toolbar
	 * (pretty kludgy, I know)
	 *
	 * @returns bool toolbar enabled
	 */
	public static function is_enabled()
	{
		// Don't auto render toolbar for ajax requests
		if (request::is_ajax())
			return FALSE;
		
		// Don't auto render toolbar if $_GET['debug'] = 'false'
		if (isset($_GET['debug']) and strtolower($_GET['debug']) == 'false')
			return FALSE;
		
		// Don't auto render if auto_render config is FALSE
		if (Kohana::config('debug_toolbar.auto_render') !== TRUE)
			return FALSE;
		
		// Auto render if secret key isset
		$secret_key = Kohana::config('debug_toolbar.secret_key');
		if ($secret_key !== FALSE and isset($_GET[$secret_key]))
			return TRUE;
		
		// Don't auto render when IN_PRODUCTION (this can obviously be 
		// overridden by the above secret key)
		if (IN_PRODUCTION)
			return FALSE;
		
		return TRUE;
	}
	
	/**
	 * Return a filename without extension
	 *
	 * @param string name of a file
	 * @return string name of file with extension removed
	 */
	private static function _strip_ext($file)
	{
		return (($pos = strrpos($file, '.')) !== FALSE) ? substr($file, 0, $pos) : $file;
	}

}