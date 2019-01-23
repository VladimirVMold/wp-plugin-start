<?php
/**
 * Create: Vladimir
 */

namespace WPPluginStart;

use WPPluginStart\Plugin\Admin\Page as AdminPage;
use WPPluginStart\Plugin\Route;
use WPPluginStart\Plugin\Settings;
use WPPluginStart\Plugin\Control;

class Plugin
{

	public function __construct($main_file)
	{
		new Settings($main_file);
		new Control();

		$this->init();
	}

	public function init()
	{
		$routers = Settings::get('routers');

		if (is_array($routers)) {
			new Route($routers);
		}
		
	}
	
	public function initAdmin ()
	{
		AdminPage::init();

		$this->action_links();
	}
	
	public function initFront ()
	{
	    
	}
	

	static function outJSON($data, $die = true)
	{
		header('Content-Type: application/json');
		echo json_encode($data);
		if ($die) {
			die;
		}
	}

	static function template($names, $find_in_theme = true)
	{
		$template = false;
		if ($find_in_theme) {
			$_names = [];
			foreach ((array)$names as $name) {
				$_names[] = Settings::$plugin_key . '/' . $name;
			}
			$template = locate_template($_names);
		}

		if ($template) {
			foreach ((array)$names as $name) {
				$file = Settings::$plugin_template . '/' . $name;
				if (is_file($file)) {
					$template = $file;
					break;
				}
			}
		}

		return $template;
	}

	function action_links()
	{
		add_filter('plugin_action_links_' . Settings::$plugin_basename, function ($links) {
			$items = Settings::get('action_links');
			
			if (empty($items)) {
				return $links;
			}

			foreach ((array)$items as $key => $item) {
				if (is_numeric($key)) {
					$key = Settings::$plugin_key . '-' . $key;
				}
				if (is_scalar($item)) {
					$links[$key] = $item;
				} else {
					$item = (array)$item;
					if (isset($item['link']) && isset($item['title'])) {
						$target = '';
						if (!empty($item['target'])) {
							$target = ' target="_blank" ';
						}
						$links[$key] = '<a href="' . esc_url($item['link']) . '" ' . $target . '>' . esc_html($item['title']) . '</a>';
					}
				}
			}

			return $links;
		});
	}


}
