<?php
namespace Classes\Forms;
class RusArtMainForm extends RusArtBaseFormHtml {

	const DEFAULT_FIELDS = [
			'selected_filial' => '',
			'_url'            => '',
			'_current_site'   => '',
			'fio'             => '',
			'vozrast'         => '',
			'fam_parent'      => '',
			'imya_parent'     => '',
			'otch_parent'     => '',
			'tel'             => '',
			'email'           => '',
			'acceptance'      => '',
		];

	public function getForm(): string {
		$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$current_site = $_SERVER['HTTP_HOST'];
		$html = '<form class="newForm__Wrapper col-md-12 js--rusartform">';
		$html .= '<div class="newForm__line">';
		$html .= '<p class="h2 text-center">Онлайн заявка</p>';
		$html .= '</div>';
		$html .= '<div class="newForm__line align-self-fs">';
		$html .= '<input type="hidden" name="selected_filial" class="js--selected_filial">';
		$html .= '<input type="hidden" name="_url" value="'.$url.'">';
		$html .= '<input type="hidden" name="_current_site" value="'.$current_site.'">';

		$html .= '</div>';
		$html .= '<div class="newForm__line">';
		$html .= '<p class="h4">Персональные данные:</p>';
		$html .= '</div>';
		$html .= '<div class="newForm__line">';
		$html .= '<p>';
		$html .= '<input type="text" id="fio" name="fio" class="form-control" required placeholder="Ф. И. О. Ребенка*">';
		$html .= '</p>';
		$html .= '<p>';
		$html .= '<input type="number" id="vozrast" name="vozrast" min="1" max="100" class="form-control" required placeholder="Возраст*">';
		$html .= '</p>';
		$html .= '</div>';
		$html .= '<div class="newForm__line">';
		$html .= '<p class="h4">Контактная информация:</p>';
		$html .= '</div>';
		$html .= '<div class="newForm__line">';
		$html .= '<p>';
		$html .= '<input type="text" id="fam_parent" name="fam_parent" class="form-control" required placeholder="Ваша фамилия*">';
		$html .= '</p>';
		$html .= '<p>';
		$html .= '<input type="text" id="imya_parent" name="imya_parent" class="form-control" required placeholder="Ваше имя*">';
		$html .= '</p>';
		$html .= '<p>';
		$html .= '<input type="text" id="otch_parent" name="otch_parent" class="form-control" required placeholder="Ваше отчество*">';
		$html .= '</p>';
		$html .= '</div>';
		$html .= '<div class="newForm__line">';
		$html .= '<p>';
		$html .= '<input type="tel" id="tel" name="tel" class="form-control" required placeholder="Телефон для связи*">';
		$html .= '</p>';
		$html .= '<p>';
		$html .= '<input type="email" id="email" name="email" class="form-control" required placeholder="Ваш Email*">';
		$html .= '</p>';
		$html .= '</div>';
		$html .= '<div class="newForm__line">';
		$html .= '<input type="checkbox" name="acceptance" checked required>';
		$html .= '<span>я согласен с <a href="/politika-konfidencialnosti/">политикой конфиденциальности</a></span>';
		$html .= '</div>';
		$html .= '<div class="newForm__line capch">';
		$html .= '<input type="submit" class="form-control"	 value="Отправить">';
		$html .= '</div>';
		$html .= '<div class="newForm__line js-ccf-result" data-nonce="'.wp_create_nonce('rus-art-school-Forms').'">';
		$html .= '</div>';

		$html .= '</form>';

		return $html;
	}
	public function getMessageTemplate(): string {
		return '<h1>На сайте оставили заявку на обучение в изостудии. Филиал - [selected_filial]</h1>
			<h4>Персональные данные:</h4>
			<p>Ф.И.О. ребенка: <strong>[fio]</strong></p>
			<p>Возраст: <strong>[vozrast]</strong></p>
			<h4>Контактная информация:</h4>
			<p>Фамилия : <strong>[fam_parent]</strong></p>
			<p>Имя : <strong>[imya_parent]</strong></p>
			<p>Отчество: <strong>[otch_parent]</strong></p>
			<p>Телефон для связи: <strong>[tel]</strong></p>
			<p>Электронная почта: <strong>[email]</strong></p>	
			<p>Ссылка откуда отправлено сообщение: [_url]</p>
			<p>--</p>
			<p>Это сообщение отправлено с сайта [_current_site]</p>';
	}

}
