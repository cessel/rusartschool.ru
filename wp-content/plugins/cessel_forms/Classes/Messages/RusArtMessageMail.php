<?php

namespace Classes\Messages;

class RusArtMessageMail extends RusArtMessage {

	public function __construct() {
		parent::__construct();

	}
	public function createMessage($messageData) {
		$this->setMessageData($messageData);
		add_filter('wp_mail_content_type',[$this,'setHtmlContentType']);
		wp_mail($this->adminEmail,sanitize_text_field( $this->getRawTitle() ),$this->getContent());
		remove_filter('wp_mail_content_type',[$this,'setHtmlContentType']);
	}

	public function setHtmlContentType($content_type ): string {
		return 'text/html';
	}
}