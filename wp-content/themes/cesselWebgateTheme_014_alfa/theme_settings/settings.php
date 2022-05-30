<?php
if(!defined('CLASS_DIR')){
	define('CLASS_DIR',get_template_directory()."/includes/Classes");
}
require_once(CLASS_DIR.'/CriticalSettings.php');
require_once(CLASS_DIR.'/Settings.php');

add_action('wp_head','settings_init',1);
function settings_init() {
	$GLOBALS['S'] = Settings::init();
}