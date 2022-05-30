<?php
/**
 * Created by Cessel's WEBGate Studio.
 * User: Cessel
 * Date: 08.08.2021
 * Time: 16:58
 */
/*
Plugin Name: Cessel Theme Switcher
Plugin URI: https://cessel.ru
Description: Automatic switch to default theme
Author: Cessel's WEBGate Studio
Version: 0.1.0
Author URI:  https://cessel.ru
*/
if(!defined('DEFAULT_THEME_NAME')){
	define('DEFAULT_THEME_NAME','cesselWebgate studio WP Theme');

}
$theme_list = array();

add_filter('stylesheet', 'load_style');
add_filter('template', 'load_theme');

function load_style() {
	foreach (get_theme_list() as $theme) {
		if ($theme['Name'] == DEFAULT_THEME_NAME) {
			return $theme['Stylesheet'];
		}
	}
}

function load_theme() {
	foreach (get_theme_list() as $theme) {
		if ($theme['Name'] == DEFAULT_THEME_NAME) {
			return $theme['Template'];
		}
	}

}

function get_theme_list() {
	$wp_themes = array();

	foreach (wp_get_themes() as $theme) {
		$name = $theme->get('Name');
		if ( isset( $wp_themes[ $name ] ) )
			$wp_themes[ $name . '/' . $theme->get_stylesheet() ] = $theme;
		else
			$wp_themes[ $name ] = $theme;
	}

	return $wp_themes;
}
