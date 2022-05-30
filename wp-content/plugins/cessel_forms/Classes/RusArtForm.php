<?php
namespace Classes;

abstract class RusArtForm {
	const handleName = 'ccf_';
	protected $messagesCustomPostName = self::handleName . 'messages';
	protected $formsCustomPostName = self::handleName . 'forms';
	protected $version;
	protected $assetsDir;
	protected $adminEmail;

	public function __construct() {
		global $wp_version;
		$this->version = (CCF_DEBUG) ? time() : $wp_version;
		$this->assetsDir = plugin_dir_url( __FILE__ ).'../assets';
		$this->adminEmail = (CCF_DEBUG) ? 'cessel@yandex.ru' : get_option('admin_email');
	}
}