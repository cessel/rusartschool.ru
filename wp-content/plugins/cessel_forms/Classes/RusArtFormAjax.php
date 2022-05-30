<?php
namespace Classes;
use Classes\Messages\RusArtMessageDB;
use Classes\Messages\RusArtMessageMail;
class RusArtFormAjax {
	public function sendForm() {
		$successUserMessage = 'Спасибо за ваше сообщение! Мы свяжемся с вами как можно быстрее!';

		check_ajax_referer('rus-art-school-Forms');
		$data             = wp_slash(wp_parse_args($_POST['data']));
		$return['status'] = 0;
		$return['error']  = '';
		$return['html']   = '<p>'.$successUserMessage.'</p>';

		$newMessage = new RusArtMessageDB();
		$newMessage->createMessage($data);

		$newMessage = new RusArtMessageMail();
		$newMessage->createMessage($data);

		$return['debug'] = $data;

		wp_send_json($return);


	}
}