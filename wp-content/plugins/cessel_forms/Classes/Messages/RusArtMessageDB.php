<?php

namespace Classes\Messages;
class RusArtMessageDB extends RusArtMessage {
	public function __construct() {
		parent::__construct();
	}
	public function createMessage($messageData) {
		$this->setMessageData($messageData);

		$post_data = array(
			'post_type'     => $this->messagesCustomPostName,
			'post_title'    => sanitize_text_field( $this->getRawTitle() ),
			'post_content'  => $this->getContent(),
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_data'     => $this->getDate(),
		);

		$post_id = wp_insert_post( $post_data );



	}
}