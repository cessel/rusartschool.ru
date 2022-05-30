<?php
/**
 * Created by Cessel's WEBGate Studio.
 * User: Cessel
 * Date: 21.07.2020
 * Time: 17:15
 */

class Settings extends CriticalSettings {
	public $settings;
	public $links;
	public $options;
	public $contacts;
	public $messages;
	public $backgrounds;
	public $packages;
	public $mobile_menu_blocks;

	public function __construct() {
	    parent::__construct();
		try{
			if(function_exists('get_fields')){
				$this->setOptions();
				$this->setContacts();
				$this->setSettings();
				add_shortcode('contacts',[$this,'contactsShortcode']);
				add_shortcode('socials',[$this,'socialsShortcode']);
				add_shortcode('tariff_selector',[$this,'tariffSelectorHtml']);
				add_action('wp_footer',[$this,'callBackButton']);
			}
		}
		catch(Error $exception){
			echo '<pre>'.print_r($exception->getMessage(),true).'</pre>';
		}
	}


	public static function init() {
		return new static;
	}
	private function setContacts() {
		$this->contacts = [];
		$contacts = $this->getOptions('contacts');
		if(!empty($contacts)){
			foreach ( $contacts as $contact ) {
				$this->contacts[$contact['id']] = $contact;
			}
		}

	}
	private function setSettings() {
		$this->settings = [];
		$settings = $this->getOptions('settings');
        foreach ( $settings as $setting ) {
            $this->settings[$setting['name']] = $setting;
        }
	}
	private function setLinks() {
		$this->links = [];
		$links = $this->getOptions('links');
        foreach ( $links as $link ) {
            foreach ( $link as $key=>$value ) {
                $this->links[$link['name']]['%'.$key] = $value;
            }
        }
	}

	public function theLogo( $type = '' ) {
		echo $this->getLogo($type);
	}

	function getLogo($type,$with_link_force = false) {

		if($type === 'desktop'){
			$logo_id = get_theme_mod( 'custom_logo' );
		} else if($type === 'footer'){
			$logo_id = $this->getOptions('logo-footer','int');
		} else if($type === 'footer-mobile'){
			$logo_id = $this->getOptions('logo-footer-mobile','int');
		} else {
			$logo_id = $this->getOptions('logo-mobil','int');
		}
		$logoUrl = wp_get_attachment_image_url( $logo_id, 'full' );
		$logoHtml = '<img class="logo logo--'.$type.'" src="'. $logoUrl . '" alt="' . get_bloginfo( 'name' ) . ' - наш логотип">';

		return ($with_link_force || !( is_home() || is_front_page() ) ) ? "<a href='" . get_home_url() . "' title='" . get_bloginfo( 'name' ) . " - на главную'>".$logoHtml."</a>" : $logoHtml;
	}

	public function getSettings($selector,$image_size = 'large') {

		if(isset($this->settings[$selector])){
			$settings = $this->settings[$selector];
			switch ($settings['type']){
				case 'image':
					if(is_int($settings['value'])){
						return wp_get_attachment_image_url($settings['value'],$image_size);
					} else if(is_array($settings['value'])){
						return (isset($settings['value'][$image_size]))?$settings['value'][$image_size]:array_pop($settings['value']);
					} else{
						return $settings['value'];
					}
				case 'text':
				case 'number':
				default:
					return $settings['value'];
			}
		} else{
			return '';
		}

	}

	public function getContacts($selector = '',$raw = true,$with_desc = false) {
		if(empty($selector)){
			return $this->contacts;
		}
		if(isset($this->contacts[$selector])){
			$contacts = $this->contacts[$selector];
			switch ($contacts['type']){
				case 'phone':
					$contact_html = ($raw) ? $contacts['value'] : self::phoneConvertToLink($contacts['value'],'phone-link phone-link--'.$selector,false,false);
					break;
				case 'email':
					$contact_html = ($raw) ? $contacts['value'] : self::emailConvertToLink($contacts['value'],'email-link email-link--'.$selector,false);
					break;
				case 'address':
				case 'social':
				default:
					$contact_html = $contacts['value'];
				break;
			}
			if(!empty($contacts['icon'])){
				$contact_html = self::getContactsIconHtml($contacts['icon'],$contacts['name']).$contact_html;
			}

			return (!$with_desc) ? $contact_html : ['contact'=>$contact_html,'description'=>$this->contacts[$selector]['text']];
		} else{
			return '';
		}
	}

	public function contactsShortcode($attrs) {
		$selector = $attrs['selector'];
		$label    = ( isset( $attrs['label'] ) ) ? $attrs['label'] : false;
		if ( isset( $attrs['selector'] ) && ! empty( $attrs['selector'] ) ) {
			$html = '<span class="contact-shortcode">';
			if ( $label ) {
				$html .= '<span class="contact-shortcode-label">';
				$html .= $label;
				$html .= '</span>';
			}
			$html .= '<span class="contact-shortcode-value">';
			$html .= $this->getContacts( $selector, false );
			$html .= '</span>';
			$html .= '</span>';
			return $html;
		} else {
			return false;
		}
	}

	public function getSocials($place = 'all') {
		$socials = $this->getOptions('socials');

		if($place === 'all'){
			return $socials;
		} else {
			$return_socials = [];
			foreach ( $socials as $social ) {
				if(in_array($place,$social['place'])){
					$return_socials[] = $social;
				}
			}
			return $return_socials;
		}
	}

	public function socialsShortcode($attrs) {
		$place = $attrs['selector'];
		$socials_list = $this->getSocials($place);

		$html = '<div class="socials">';
		foreach ( $socials_list as $item ) {
			$social_logo = wp_get_attachment_image_url($item['icon'],'thumbnail');
			$html .= '<div class="socials-item">';
			$html .= '<div class="socials-item__inner">';
			$html .= '<a href="'.$item['link'].'" class="socials-item-link">';
			$html .= self::getSvgRaw($social_logo);
			$html .= '</a>';
			$html .= '</div>';
			$html .= '</div>';
		}
		$html .= '</div>';
		return $html;
	}

	public function getMessages($type = 'all',$selector = 'all') {
		if($type === 'all'){
			if($selector === 'all'){
				return $this->messages;
			} else if(isset($this->messages[$type][$selector])) {
				return $this->messages[$type][$selector];
			} else{
				return [];
			}
		}
		else if(isset($this->messages[$type])) {
			if($selector === 'all'){
				return $this->messages;
			} else if(isset($this->messages[$type][$selector])) {
				return $this->messages[$type][$selector];
			} else{
				return [];
			}
		}
		return [];
	}
	public function getJsMessages($selector = 'all') {
		return $this->getMessages('js',$selector);
	}


	public function getCarousel($id,$arrayItemsHtml,$nav = true) {
		$return = '<div id="'.$id.'-wrapper" class="'.$id.'-wrapper">';
		$return .= '<div id="'.$id.'" class="owl-carousel owl-theme">';

		foreach ($arrayItemsHtml as $item){
			$return .= $item;
		}

		$return .= '</div>';
		if($nav){
			$return .= '<div class="arrow arrow-left">';
			$return .= self::getIcon('right-angle');
			$return .= '</div>';
			$return .= '<div class="arrow arrow-right">';
			$return .= self::getIcon('right-angle');
			$return .= '</div>';
		}
		$return .= '</div>';

		return $return;
	}

	public function getWiki($short = true) {
		$wiki_category = $this->getOptions('wiki_category','int');
		if($wiki_category == 0){return '';}

        $wiki_category = get_term($wiki_category);
		$html = '<section class="section section--baza-znanij">';
		$html .= $this->getCategoryHeader($wiki_category,$short);
		$html .= $this->getCategoryItems($wiki_category,$short);
		$html .= '</section>';
		return $html;
	}


	public function getCategoryItems( WP_Term $wiki_category, $short ) {

		$numberposts = $short ? 6 : - 1;
		$posts       = get_posts( [
			'category'    => $wiki_category->term_id,
			'numberposts' => $numberposts,
			'order'       => 'ASC'
		] );

		if($this->isMobile()){
			$html = '<div id="wiki-block-wrapper" class="wiki-block-wrapper">';
			$add_class = 'owl-carousel owl-theme';

			$arrows = '<div class="arrow arrow-left js--owl-left">';
			$arrows .= self::getIcon('right-angle');
			$arrows .= '</div>';
			$arrows .= '<div class="arrow arrow-right js--owl-right">';
			$arrows .= self::getIcon('right-angle');
			$arrows .= '</div>';

		} else {
			$html = '';
			$arrows = '';
		}

		$html        .= '<div id="wiki-block" class="category-items '.$add_class.'">';
		foreach ( $posts as $post ) {
			$html .= $this->getCategoryItem( $post, $wiki_category->term_id);
		}
		$html .= '</div>';

		$html .= $arrows;

		$html .= '</div>';

		return $html;
	}

	public function getCategoryItem(WP_Post $post, $term_id) {
	    if($term_id == 0){return '';}

		$wiki_category = $this->getOptions('wiki_category','int');
		$video_category = $this->getOptions('video_category','int');
		$sale_category = $this->getOptions('sale_category','int');
		$news_category = $this->getOptions('news_category','int');
		switch($term_id){
			case $wiki_category:
				$html = $this->getWikiCategoryItem( $post );
				break;
			case $video_category:
				$html = $this->getVideoCategoryItem( $post );
				break;
			case $sale_category:
				$html = $this->theSalePage( $post, false );
				break;
			default:
				$html = $this->getDefaultCategoryItem( $post );
				break;
		}
		return $html;
	}
	public function getWikiCategoryItem(WP_Post $post) {
		$html = '';

		$post_thumbnail = get_the_post_thumbnail_url($post->ID,'large');
		$post_link = get_permalink($post->ID);

		$html = '<div class="category-item">';
		$html .= '<div class="category-item__inner" style="background-image:url('.$post_thumbnail.')">';

		$html .= '<a class="category-item__link" href="'.$post_link.'"></a>';
		$html .= '<div class="category-item__title">';
		$html .= $post->post_title;
		$html .= '</div>';

		$html .= '<div class="category-item__overlay">';

		$html .= '<div class="category-item-overlay-content">';

		$html .= '<div class="category-item-overlay-title">';
		$html .= '<span>'.$post->post_title.'</span>';
		$html .= '</div>';// end overlay-title

		$html .= '<div class="category-item-overlay-description">';
		$html .= '<p>'.self::generateExcerpt($post).'</p>';
		$html .= '</div>';// end overlay-description

		$html .= '</div>'; // end overlay-content

		$html .= '<div class="category-item-overlay-button">';
		$html .= '<a class="category-item-overlay-button__link" href="'.$post_link.'">Подробнее...</a>';
		$html .= '</div>'; // end overlay-button

		$html .= '</div>'; // end overlay

		$html .= '</div>'; // end inner
		$html .= '</div>'; // end item


		return $html;
	}
	public function getVideoCategoryItem(WP_Post $post) {
		$html = '';

		$post_thumbnail = get_the_post_thumbnail_url($post->ID,'large');
		$post_link = get_permalink($post->ID);

		$html = '<div class="category-item">';
		$html .= '<div class="category-item__inner">';

		$html .= '<div class="category-item__title">';
		$html .= '<h4>'.$post->post_title.'</h4>';
		$html .= '</div>';

		$html .= '<div class="category-item__content">';
		$html .= apply_filters('the_content',$post->post_content);
		$html .= '</div>'; // end content

		$html .= '</div>'; // end inner
		$html .= '</div>'; // end item
		$html .= self::theLines(false);


		return $html;
	}

	public function getDefaultCategoryItem( WP_Post $post ) {
		$html = '';

		$post_link = get_permalink($post->ID);

		$cats = get_the_category($post->ID);
		$html = '';
		$post_cat_ids = [];
		$html_header = '';
		foreach ( $cats as $post_cat ) {
			$post_cat_ids[] = $post_cat->term_id;
			$html_header .= '<li>'.$post_cat->name.'</li>';
		}
		$data_post_cat_ids = json_encode($post_cat_ids);
		$html .= '<div class="category-item" data-post_cat_ids="'.$data_post_cat_ids.'">';
		$html .= '<div class="category__itemContent">';
		$html .= '<div class="category__itemMeta">';
		$html .= '<div class="category__itemData">';
		$html .= '<span>Дата:</span>';
		$html .= '<span>'. get_the_date( '', $post ).'</span>';
		$html .= '</div>';
		$html .= '<div class="category__itemCats">';
		$html .= '<ul>'.$html_header.'</ul>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="category__itemTitle">';
		$html .= '<h2><a href="'. $post_link.'">'.get_the_title($post).'</a></h2>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	public function getCategoryHeader( WP_Term $category, $short ) {
		$category_description = $short ? get_field( 'short_description', 'category_' . $category->term_id ) : $category->description;
		$count_html = '';
		$html_header = '';
		if($this->isNewsCaterory($category->term_id)) {

			$count_html = (!empty($category->count)) ? '<span class="category__count"> найдено '.$category->count.'</span>' : '';
			$args_child_terms = ['taxonomy'=>'category','hide_empty'=>false,'parent'=>$category->term_id];
			$child_terms_list = get_terms($args_child_terms);
			$html_header = '<div class="category-selector">';
			$html_header .= '<ul class="category-selector__list">';
			foreach ( $child_terms_list as $item ) {
				$html_header .= '<li data-category_id="'.$item->term_id.'"><a href="'.get_term_link($item->term_id).'">'.$item->name.'</a></li>';
			}
			$html_header .= '</ul>';
			$html_header .= '</ul>';

		}


		$class = 'category-header category-header--'.$category->slug;
		$class .= ($short) ?  :'category-header--short';

		$html = '<div class="'.$class.'">';
		$html .= '<h1 class="category-header-h1">';
		$html .= $category->name;
		$html .= $count_html;
		$html .= '</h1>';
		$html .= $html_header;
		$html .= self::theLines(false);

		$html .= '<div class="category-header-description">';
		$html .= $category_description;
		$html .= '</div>';
		$html .= '</div>';


		return $html;
	}
	public function getPromoSection($promo_id, $is_promo_video = false) {
		$promoData = $this->getPromoData( $promo_id,$is_promo_video );
		$addClass = ($is_promo_video)?'promo--video':'';
		$html = '<section class="promo promo--' . $promo_id . ' '.$addClass.'">';
		$html .= '<div class="container">';
		$html .= '<div class="promo__block">';
		if ( ! empty( $promoData['title'] )) {
			$html .= '<div class="promo__title">';
			$html .= $promoData['title'];
			$html .= '</div>';

		}
		if ( ! empty( $promoData['text'] )) {
			$html .= '<div class="promo__text">';
			$html .= $promoData['text'];
			$html .= '</div>';

		}
		$html .= '</div>';
		if ( $is_promo_video && ! empty( $promoData['video_id'] ) )  {
			$html .= '<div class="promo__video">';
			$html .= self::getYoutubeVideoBlock($promoData['video_id']);
			$html .= '</div>';
		}

		if ( ! empty( $promoData['button_text'] ) && ! empty( $promoData['button_link'] ) ) {
			$html .= '<div class="promo__block">';
			$html .= '<div class="promo__button">';
			$html .= '<a class="promo-button" href="' . $promoData['button_link'] . '">';
			$html .= $promoData['button_text'];
			$html .= '</a>';
			$html .= '</div>';
			$html .= '</div>';
		}

		$html .= '</div>';
		$html .= '</section>';

		return $html;
	}

	public function getPromoData($promo_id) {
	    $promos = $this->getOptions('promos');
		foreach ( $promos as $promo ) {
			if ( $promo['id'] == $promo_id ) {
				return $promo;
			}
		}
	}

	public function getTestimonialsSection() {
		$testimonials = $this->getOptions('testimonials');

		$html = '<div class="container">';
		$html .= '<section class="section section--testimonials">';

		if ( ! empty( $testimonials['title'] )) {
			$html .= '<div class="testimonials__title">';
			$html .= '<h2 class="section-title">'.$testimonials['title'].'</h2>';
			$html .= '</div>';
		}
		if ( ! empty( $testimonials['text'] )) {
			$html .= '<div class="testimonials__text">';
			$html .= '<p class="section-test">'.$testimonials['text'].'</p>';
			$html .= '</div>';
		}
		if(! empty($testimonials['list'])) {
			foreach ( $testimonials['list'] as $testimonial ) {
				if ( $testimonial['name'] ) {
					$arrayItemsHtml[] = $this->getTestimonial( $testimonial );
				}
			}

            $html .= "<div class='testimonials__list'>";
            $html .= $this->getCarousel('homepage-testimonials',$arrayItemsHtml);
            $html .= "</div>";
	    }
		$html .= '</section>';
		$html .= "</div>";


		return $html;
	}


	public function tariffSelectorHtml() {
		$tariffs = $this->getOptions('tariffs');
		$html = '<div id="select-tariff" class="content-body-tariff">';
		$html .= '<div class="container">';
		$html .= '<section class="section section--tariffs">';
		if ( ! empty( $tariffs['title'] )) {
			$html .= '<div class="tariffs_title">';
			$html .= '<h2 class="section-title">'.$tariffs['title'].'</h2>';
			$html .= '</div>';
		}
		if ( ! empty( $tariffs['text'] )) {
			$html .= '<div class="tariffs__text">';
			$html .= '<p class="section-test">'.$tariffs['text'].'</p>';
			$html .= '</div>';
		}

		$html .= '<div id="tariff-list-wrapper" class="tariffs-list">';
		$html .= '<div id="tariff-list" class="tariffs-list__inner owl-carousel owl-theme">';
		if(! empty($tariffs['list'])) {
			foreach ( $tariffs['list'] as $tariff ) {
				$html .= $this->tariffCardHtml( $tariff );
			}

			$html .= '</div>';
			$html .= '<div class="tariffs-list-arrow tariffs-list-arrow--left js--owl-left">' . icon( 'right-angle', false ) . '</div>';
			$html .= '<div class="tariffs-list-arrow tariffs-list-arrow--right js--owl-right">' . icon( 'right-angle', false ) . '</div>';
		}
		$html .= '</section>';
		$html .= '</div>';
		$html .= '</div>';

		return $html;

	}

	public function tariffCardHtml($tariff) {
		$html = '<div class="tariff-item tariff-item-id-'.$tariff['id'].'" data-tariff_id="'.$tariff['id'].'" >';
		$html .= '<div class="tariff-item__inner">';
		foreach ( $tariff as $field => $value ) {
			$html .= $this->tariffCardLineHtml($field,$value);
		}
		$html .= '<div class="tariff-item-button">';
		$html .= '<button class="site-btn site-btn--tariff-add" data-toggle="modal" data-target="#select-tariff-modal">Подключить</button>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<style>.tariff-item-id-'.$tariff['id'].' .tariff-item-line--price{color:'.$tariff['czvet_czeny_straniczy'].'}</style>';

		$html .= '</div>';

		return $html;
	}
	public function tariffCardLineHtml($field,$value) {

		switch ( $field ) {
			case 'id':
			case 'czvet_czeny_straniczy':
				$value = '';
				break;
			case 'value':
				$value = number_format($value,'0','',' ').' страниц';
				break;
			case 'explanation':
				if(!empty($value)||$value!='---') {
					$label = '<p>Это аналогично нагрузке:</p>';
					$value = $label . $value;
				} else {
					$value = '';
				}
				break;
			case 'features':
				$value = str_replace('[ICON]',icon_image('check_icon','svg',false),$value);
				break;
			case 'add':
				$value = str_replace('[ICON]',icon_image('round_plus_icon','svg',false),$value);
				break;
			case 'price':
				$value = $value.'<span><i class="fa fa-ruble"></i> /стр</span>';
				break;
			case 'description':
			case 'name':
			default:
				break;
		}




		if(!empty($value)){
			$html = '<div class="tariff-item-line tariff-item-line--'.$field.'" data-field="'.$field.'">';
			$html .= $value;
			$html .= '</div>';
		}
		else{
			$html = '';
		}
		return $html;
	}


	public function getTestimonial($testimonial){
		$text = self::generateDescriptionBySymbols($testimonial['text'],200);
		$name = $testimonial['name'];
		$image_url = wp_get_attachment_image_url($testimonial['image']);
		$rating    = $testimonial['rating'];

		$html      = "<div class='testimonial-item'>";
		$html      .= "<div class='testimonial-item__text'>";
		$html      .= "<a href='".get_the_permalink(134)."'>";
		$html      .= $text;
		$html      .= "</a>";
		$html      .= "</div>";
		$html      .= "<div class='testimonial-item-user'>";
		$html      .= "<div class='testimonial-item-user__foto' style='background-image:url(".$image_url.")'></div>";
		$html      .= "<div class='testimonial-item-user__info'>";
		$html      .= "<div class='testimonial-item-user__name'>";
		$html      .= $name;
		$html      .= "</div>";
		$html      .= "<div class='testimonial-item-user__rating'>";
		$html      .= self::getStarRating($rating);
		$html      .= "</div>";
		$html      .= "</div>";
		$html      .= "</div>";
		$html      .= "</div>";
		return $html;
	}

	public function partnersSection() {
		$partners = $this->getOptions('partners');
		$html = '<div class="container">';
		$html .= '<section class="section section--partners">';

		if ( ! empty( $partners['title'] )) {
			$html .= '<div class="partners_title">';
			$html .= '<h2 class="section-title">'.$partners['title'].'</h2>';
			$html .= '</div>';
		}
		if ( ! empty( $partners['text'] )) {
			$html .= '<div class="partners__text">';
			$html .= '<p class="section-test">'.$partners['text'].'</p>';
			$html .= '</div>';
		}
		if(!empty($partners['list'])) {
			$html .= "<div class='partners__list'>";
			foreach ( $partners['list'] as $partner ) {
				$partner_logo = wp_get_attachment_image_url( $partner['image'], 'medium' );
				$html         .= '<div class="partner">';
				$html         .= '<div class="partner__inner">';
				$html         .= '<img src="' . $partner_logo . '" alt="Логотип партнера">';
				$html         .= "</div>";
				$html         .= "</div>";
			}
			$html .= "</div>";
		}

		$html .= '</section>';
		$html .= "</div>";


		return $html;
	}
	function theSaleSection($echo = true) {
		$saleCatId = 7;
		$args      = [ 'category' => $saleCatId, 'numberposts' => - 1 ];
		$posts     = get_posts( $args );
		$html      = '<section class="section section--akczii">';
		foreach ( $posts as $post ) {
			$html .= $this->theSalePage( $post, false );
		}
		$html .= '</section>';
		if ( $echo == true ) {
			echo $html;
			return $html;
		} else {
			return $html;
		}

	}
	function theSalePage($post,$echo = true) {

		$datetime = get_field('data_okonchaniya_akczii',$post->ID);
		$action_label = get_field('dopolnitelnoe_opisanie_akczii',$post->ID);
		$html = '';

		if(time()<$datetime) :

			$html .= '<div class="category-item">';
			$html .= '<h2>'.get_the_title($post->ID).'</h2>';
			$html .= '<div class="post_type-sale__desc">'.$post->post_content.'</div>';
			$html .= '<p class="h4">До окончания акции <span class="post_type-sale__label">'.$action_label.'</span> осталось:</p>';
			$html .= '<div class="flipper-wrapper">';
			$html .= '<div class="flipper-wrapper__inner">';
			$html .= '<div class="flipper"
			     data-datetime="'.date('Y-m-d H:i:s',$datetime).'"
			     data-template="dd|HH|ii|ss"
			     data-labels="Дней|Часов|Минут|Секунд"
			     data-reverse="true"
			     id="fliptimer_'.$post->ID.'">';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		endif;

		$html .= '</div>';

		if($echo) {echo $html;}
		else {return $html;}
	}

	public function isNewsCaterory($term_id = '') {
		if(empty($term_id)){
			$cat = get_queried_object();
			$term_id = $cat->term_id;
		}
		return ($term_id == $this->getOptions('news_category','int'));
	}

	public function theMobileMenuPhone($echo = true) {

		$html = '<div class="mobile-menu-phone">';
		$html .= '<div class="mobile-menu-phone__title">';
		$html .= $this->getOptions('phone_title','string');
		$html .= '</div>';
		$html .= '<div class="mobile-menu-phone__number">';
		$html .= $this->getContacts( 'mobile-phone' );
		$html .= '</div>';
		$html .= '</div>';
		if ( $echo == true ) {
			echo $html;
			return $html;
		} else {
			return $html;
		}

	}
	public function getAvatar() {
	    $default_avatar = $this->getOptions('default_avatar','int');
		if($default_avatar){
			$avatar_url = wp_get_attachment_image_url($default_avatar);
			$avatar = $this->getSvgRaw($avatar_url);

		} else{
			$user_data = get_userdata(get_current_user_id());
			$avatar = get_avatar($user_data);
		}

		return $avatar;
	}
	public function theMobileMenuLogin($echo = true) {
		$html = '<div class="mobile-menu-login">';
		$html .= '<div class="mobile-menu-login__avatar">';
		$html .= $this->getAvatar();
		$html .= '</div>';
		$html .= $this->getLinks('login-mobile');
		$html .= $this->getLinks('register-mobile');
		$html .= '</div>';
		if ( $echo == true ) {
			echo $html;
			return $html;
		} else {
			return $html;
		}

	}
	public function theMobileMenuBlocks() {
		dynamic_sidebar('mobile-menu-blocks');
	}

	public function callBackButton() {
	    $callback_icon_id = $this->getOptions('callback_icon','int');
		$callback_icon = wp_get_attachment_image_url($callback_icon_id);
		if($callback_icon) {
			$html = '<div class="email-bt">';
			$html .= '<a href="#select-tariff-modal" class="text-call" data-target="#select-tariff-modal" data-toggle="modal" >';
			$html .= Settings::getSvgRaw($callback_icon);
			$html .= '<span>Оставь<br>заявку</span>';
			$html .= '</a>';
			$html .= '</div>';
		} else{
			$html = '';
		}

		echo $html;

	}

	public function theBottomMenu() {
		$mobile_phone_data = $this->getContacts('mobile-phone',false,true);

		?>
        <div class="bottom-menu">
            <?php self::theLines(); ?>
            <div class="bottom-menu__inner">
                <button class="site-btn botom-menu__order" data-toggle="modal" data-target="#select-tariff-modal">Оставить заявку</button>
	            <?php
                $bottom_menu_logo = $this->getOptions('bottom_menu_logo','int');
                if($bottom_menu_logo){
		            ?>
                    <div class="bottom-menu__logo">
			            <?
			            $bottom_menu_logo = wp_get_attachment_image($bottom_menu_logo,'full');
			            if(!empty($bottom_menu_logo)){
				            echo $bottom_menu_logo;
			            }
			            ?>
                    </div>
		            <?
	            } ?>
                <div class="bottom-menu__contacts">
                    <p><?php echo $mobile_phone_data['description']; ?></p>
		            <?php echo $mobile_phone_data['contact']; ?>
                </div>
            </div>
        </div>
		<?
	}

	public function theMobileMenuBlock($selector = 'menu') {
	    $title = __('Menu',CWG_TEXT_DOMAIN);
	    $content = $this->theMobileMenuBlockContent($selector);
		$close_icon_id = $this->getOptions('mobile_menu_close_icon','int');
		$close_icon_url = wp_get_attachment_image_url($close_icon_id,'full');
        $close_icon = (!empty($close_icon_url)) ? self::getSvgRaw($close_icon_url) : '&times;';
        ?>
        <div class="mobile-menu-wrapper js--mobile-menu" data-menu_type="<?php echo $selector; ?>">
            <div class="mobile-menu-wrapper__header">
                <div class="mobile-menu-wrapper__close js--mobile-menu-close">
	                <?php echo $close_icon; ?>
                </div>
                <p class="mobile-menu-wrapper__title"><?php echo $title; ?></p>
            </div>
            <div class="mobile-menu-wrapper__content">
	            <?php echo $content; ?>
            </div>
        </div>
        <?php
	}

	public function theMobileMenuBlockContent($selector) {
        $content['menu'] =  wp_nav_menu(['theme_location'=>'main-menu','menu_class'=>'nav nav-pills mobile-menu','echo'=>false]);
//		$content['menu'] = '<nav><ul>';
//		for ($i=0;$i<20;$i++){
//			$content['menu'] .= '<li>menu item '.$i.'</li>';
//		}
//		$content['menu'] .= '</ul></nav>';
        return (isset($content[$selector])) ? $content[$selector] : '';
    }

	public function MaintenanceMode() {
		if($this->isMaintenanceMode() && !is_user_logged_in() && (!(isset($_GET['test']))) ){
			$this->theMaintenanceModeHtml();
			get_footer();
			exit;
		}
	}
	public function isMaintenanceMode() {
		return $this->getOptions('is_maintenance');
    }
	public function theMaintenanceModeHtml() {
	    $html = '<div class="maintenance-mode-message">';
		$html .= $this->getOptions('maintenance_html');
	    $html .= '</div>';
		echo $html;
    }

	public function getAddBodyClass() {
        $add_class[] = ($this->isDesktop()) ? 'desktop' : '';
        $add_class[] = ($this->isMobile()&&!$this->isTablet()) ? 'mobile' : '';
        $add_class[] = ($this->isTablet()) ? 'tablet' : '';
		$add_class = array_filter($add_class);
		return implode(' ',$add_class);
    }

	public function getFooterBackground() {
			if($this->isMobile()){
				$bg_selector = 'footer-mobile';
			} else if($this->isTablet()){
//				$bg_selector = 'footer-tablet';
				$bg_selector = 'footer-desktop';
			} else {
				$bg_selector = 'footer-desktop';
			}
		return $this->getBackground($bg_selector);
    }

	public function getPriceListLink() {
        return $this->getOptions('price_list_link');
    }
	public static function getIcon($iconname,$echo = false) {
		$html = "<i class='icon-" . $iconname . "'></i>";
		if ( $echo == true ) {
			echo $html;
			return $html;
		} else {
			return $html;
		}
	}

	public function getContactLink($contact_type,$add_class = '') {
		$socials = get_field( 'socials', 'options' );
		$html    = '';
		if ( is_array( $socials ) ) {
			foreach ( $socials as $social ) {
				if ( mb_strtolower( $social['name'] ) == $contact_type ) {
					$icon_url = wp_get_attachment_image_url( $social['icon'], 'thumbnail' );
					$html     = '<div class="contact-link ' . $add_class . '"><a href="' . $social['link'] . '"><img src="' . $icon_url . '" alt="' . get_bloginfo( 'name' ) . '- ' . $contact_type . __( 'icon', CWG_TEXT_DOMAIN ) . '"></a></div>';

					return $html;
				}
			}
		}

		$contacts = get_field( 'contacts', 'options' );

		if ( is_array( $socials ) ) {
			foreach ( $contacts as $contact ) {
				if ( mb_strtolower( $contact['name'] ) == $contact_type ) {
					$icon_url = wp_get_attachment_image_url( $contact['icon'], 'thumbnail' );

					$html     = '<div class="contact-link ' . $add_class . '"><a href="' . $contact['contact_value'] . '"><img src="' . $icon_url . '" alt="' . get_bloginfo( 'name' ) . '- ' . $contact_type . __( 'icon', CWG_TEXT_DOMAIN ) . '"></a></div>';

					return $html;
				}

			}
		}
	}
	public static function phoneConvertToLink($tel,$class = '', $ancor = false,$echo = true) {
		$ancor = $ancor ? $ancor : $tel;
		$html = "<a href='tel:".preg_replace('/[ \-()]/','',$tel)."' class='".$class."'>".$ancor."</a>";
		if($echo == true){
			echo $html;
			return $html;
		}
		else{
			return $html;
		}
	}
	public static function emailConvertToLink($email,$class = '',$echo = true) {
		$html = "<a href='mailto:".$email."' class='".$class."'>".$email."</a>";
		if($echo == true){
			echo $html;
			return $html;
		}
		else{
			return $html;
		}
	}

	public static function getContactsIconHtml($icon_url,$contact_name,$echo = false) {
		$html = '<span class="contacts-icon contacts-icon--top-phone"><img  src="'.$icon_url.'" alt="Иконка"></span>';
		if($echo == true){
			echo $html;
			return $html;
		}
		else{
			return $html;
		}
	}
	public static function getLines( $number = 3, $add_class = '',$echo = false) {
	    if(!$number) { return ''; }

		$html = '<div class="lines '.$add_class.'">';

		$html .= ($number == 3) ? '<div class="line line--top"></div>':'';
		$html .= '<div class="line line--center"></div>';
		$html .= ($number == 3) ? '<div class="line line--bottom"></div>':'';
		$html .= '</div>';

		if ( $echo == true ) {
			echo $html;
			return $html;
		} else {
			return $html;
		}
	}

	public static function getStarRating($rating,$label = '',$is_comment = false,$nodigit = true) {
		$max_stars = 5;
		$rating_int = (int) floor($rating);
		$not_empty_stars = (float) ($rating-$rating_int);
		$empty_stars = (int) floor($max_stars-$rating);
		$star = array
		(
			'full'  => "<i class='fa fa-star'></i>",
			'half'  => "<i class='fa fa-star-half-o'></i>",
			'empty'  => "<i class='fa fa-star-o'></i>",

		);

		if($rating == 0){

			$stars = ($is_comment) ? "<div class='rating'>Без оценки</div>" : '';
		}
		else {

			$stars = "<div class='rating'><span>" . $label . "</span>";
			for ( $i = 0; $i < $rating_int; $i ++ ) {
				$stars .= $star['full'];
			}
			$half_stars = ( $not_empty_stars > 0.5 ) ? $star['full'] : $star['half'];
			$half_stars = ( $not_empty_stars == 0 ) ? '' : $half_stars;

			$stars .= $half_stars;


			for ( $i = 0; $i < $empty_stars; $i ++ ) {
				$stars .= $star['empty'];
			}

			$stars .= ($nodigit) ? "" : "<span class='rating_digit'>" . round($rating ,2). "</span>";

			$stars .= "</div>";
		}
		return $stars;

	}
	public static function generateDescriptionBySymbols($text,$numsymbols = 10){
		$experpt = ($text) ? mb_substr(self::shortcodeRemover($text),0,$numsymbols-3).'...' : '' ;
		return $experpt;
	}

	public static function generateExcerpt($post,$numwords = 10) {
		return (has_excerpt($post->ID)) ? wp_trim_words(self::shortcodeRemover(get_the_excerpt($post->ID))) : wp_trim_words(self::shortcodeRemover($post->post_content),$numwords) ;
	}
	public static function shortcodeRemover($content) {
		return strip_shortcodes(preg_replace( '~\[[^\]]+\]~', '', strip_tags($content)));
	}

	public static function getYoutubeVideoBlock($video_id, $echo = false) {
//		$videoblock = '<div class="youtube" id="' . wp_generate_uuid4() . '" data-embed="' . $video_id . '"></div>';
		$videoblock = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$video_id.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
		if ( $echo ) {
			echo $videoblock;
		} else {
			return $videoblock;
		}
	}

	public static function getSvgRaw($fileUrl) {
	    if(!empty($fileUrl)){
		    return file_get_contents($fileUrl);
        } else {
	        return 'Empty Url';
	    }

	}

	public static function socialShare($type = 'product') {
		if ( $type == 'single-blog' ) {
			global $post;
			$image_url = get_the_post_thumbnail_url( $post->ID, 'thumbnail' );
			echo '<div class="ya-share2" data-services="facebook,vkontakte,twitter,telegram" data-image="' . $image_url . '"></div>';
		} else {
			return false;
		}
	}

	public static function theWcagContainer() {
		if(WCAG_ENABLE){
			echo '<div class="wcag-version js--wcag-container"></div>';
		}

    }

	public static function getSiteTitles( $title,$level = 2, $lines = 3, $position = 'center', $brightness = 'white', $add_text = false,$add_link = false) {

	    $class[] = ($brightness === 'white')? 'site-title--white':'';
	    $class[] = ($lines) ? 'site-title--lines-'.$lines : '';
	    $class[] = ($position) ? 'site-title--position-'.$position : '';
	    $class[] = ($add_text) ? 'site-title--add-text' : '';
	    $class[] = (is_rtl()) ? 'site-title--rtl' : '';

        $class = implode(' ',$class);


        $html = '<div class="site-title '.$class.'">';
        $html .= '<div class="site-title__content">';
		$html .= self::getLines($lines,$brightness.' left');
		$html .= '<div class="site-title__title">';
		$html .= '<h'.$level.' class="site-title-title">';
		$html .= $title;
		$html .= '</h'.$level.'>';
		$html .= '</div>';
		$html .= self::getLines($lines,$brightness.' right');
		if($add_text){
			$html .= '<div class="site-title__add">';
			$html .= icon( 'right-angle',false );
			$html .= ($add_link)
				? sprintf('<a href="%s" class="site-title__add-link" >%s</a>',$add_link,$add_text)
				: sprintf('<span class="site-title__add-text">%s</span>',$add_text);

			$html .= '</div>';
		}

		$html .= '</div>';
		$html .= '<div class="site-title__bottom--yellow-line"></div>';
		$html .= '</div>';

        return $html;
    }

	public static function inString($haystack,$needle) {
        if(function_exists('str_contains')){
	        if (str_contains($haystack, $needle)) {
		        return true;
	        }
        } else{
	        if (strpos($haystack, $needle) !== false) {
		        return true;
	        }
        }
        return false;
    }
	public static function arraySortByKey(array $array,  $sort_key,  $direction = SORT_ASC) {
		$sortArray = array();

		foreach($array as $item){
			foreach($item as $key=>$value){
				if(!isset($sortArray[$key])){
					$sortArray[$key] = array();
				}
				$sortArray[$key][] = $value;
			}
		}
		array_multisort($sortArray[$sort_key],$direction,$array);
		return $array;
	}

	public static function showYoutubeVideoBlock($video_id, $echo = true) {
		$videoblock = '<div class="youtube" id="'.wp_generate_uuid4().'" data-embed="' . $video_id . '"></div>';
		if ( $echo ) {
			echo $videoblock;
		} else {
			return $videoblock;
		}
	}

	public static function pluck($items, $key) {
		return array_map( function($item) use ($key) {
		return is_object($item) ? $item->$key : $item[$key];
		}, $items);
	}
}