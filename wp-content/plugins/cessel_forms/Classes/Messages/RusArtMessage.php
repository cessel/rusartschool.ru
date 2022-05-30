<?php

namespace Classes\Messages;
use Classes\Forms\RusArtMainForm;
use Classes\RusArtForm;
class RusArtMessage extends RusArtForm {
	const DEFAULT_MESSAGE_TITLE = 'На сайте новое сообщение';

	protected $messageData;

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

// Вставляем запись в базу данных
		$post_id = wp_insert_post( $post_data );



	}
	protected function setMessageData($messageData) {
		$this->messageData = $this->convertMessageData($messageData);
		$this->messageData['timestamp'] = time();
	}

	protected function convertMessageData(array $messageData): array {
		$newData = [];
		foreach ( $messageData as $data ) {
			if(isset($data['name']) && $data['value'] ){
				$newData[$data['name']] = $data['value'];
			}
		}
		return $newData;
	}
	protected function getRawTitle(): string {

		$title[] = ($this->messageData['timestamp']) ? '['.date('d.m.Y H:i:s',$this->messageData['timestamp']).']' : false;

		$title[] = self::DEFAULT_MESSAGE_TITLE;
		$title[] = ($this->messageData['fam_parent']) ?: false;
		$title[] = ($this->messageData['imya_parent']) ?: false;
		$title[] = ($this->messageData['otch_parent']) ?: false;
		$title = array_filter($title);

		return (!empty($title)) ? implode(' ', $title) : self::DEFAULT_MESSAGE_TITLE;
	}
	protected function getContent(): string {
		$formClass = new RusArtMainForm();
		return $formClass->getMessage($this->messageData);

	}

	protected function getDate() {
		return (!empty($this->messageData['timestamp'])) ? date('Y-m-d H:i:s', $this->messageData['timestamp']) : '';
	}
}