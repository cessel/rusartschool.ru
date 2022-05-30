<?php
/**
 * Created by Cessel's WEBGate Studio.
 * User: Cessel
 * Date: 08.08.2021
 * Time: 16:58
 */
/*
Plugin Name: Cessel Custom Forms
Plugin URI: https://cessel.ru
Description: Custom Forms for multisite
Author: Cessel's WEBGate Studio
Version: 0.1.0
Author URI:  https://cessel.ru
*/
namespace Classes;
require __DIR__ . '/vendor/autoload.php';
if(!defined('CCF_DEBUG')){
	define('CCF_DEBUG',false);
}

new RusArtFormOptions();

if( wp_doing_ajax() ){
	add_action('wp_ajax_send_rus_art_forms', [new RusArtFormAjax,'sendForm']);
	add_action('wp_ajax_nopriv_send_rus_art_forms', [new RusArtFormAjax,'sendForm']);
}
