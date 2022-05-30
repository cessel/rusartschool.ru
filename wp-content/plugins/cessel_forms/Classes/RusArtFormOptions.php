<?php

namespace Classes;

final class RusArtFormOptions extends RusArtForm {

	public function __construct() {
		parent::__construct();
		add_action('init',[$this,'createCustomPosts']);
		add_action('wp_enqueue_scripts',[$this,'enqueueScripts']);
//		add_action('add_meta_boxes',[$this,'addCustomPostsMetaboxes']);
//		add_action('save_post',[$this,'saveMetaboxes']);
	}

	public function enqueueScripts() : void {
		wp_enqueue_style($this::handleName.'style_main', $this->assetsDir . '/css/styles.css','',$this->version);
		wp_enqueue_script($this::handleName.'script_main',$this->assetsDir . '/js/misc.js', ['jquery'],$this->version,true );
		$vars = [
			'myajaxurl' => admin_url('admin-ajax.php'),
		];

		wp_localize_script($this::handleName.'script_main',$this::handleName.'vars',$vars);
	}

	public function createCustomPosts() : void {
		/*register_post_type( $this->formsCustomPostName, [
			'label'  => null,
			'labels' => [
				'name'               => 'Контактные Формы', // основное название для типа записи
				'singular_name'      => 'Контактная Форма', // название для одной записи этого типа
				'add_new'            => 'Добавить Форму', // для добавления новой записи
				'add_new_item'       => 'Добавление Формы', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактирование Формы', // для редактирования типа записи
				'new_item'           => 'Новая Форма', // текст новой записи
				'view_item'          => 'Смотреть Форму', // для просмотра записи этого типа.
				'search_items'       => 'Искать в Формах', // для поиска по этим типам записи
				'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Контактные Формы', // название меню
			],
			'description'         => '',
			'public'              => true,
			// 'publicly_queryable'  => null, // зависит от public
			// 'exclude_from_search' => null, // зависит от public
			// 'show_ui'             => null, // зависит от public
			// 'show_in_nav_menus'   => null, // зависит от public
			'show_in_menu'        => true, // показывать ли в меню адмнки
			// 'show_in_admin_bar'   => null, // зависит от show_in_menu
			'show_in_rest'        => null, // добавить в REST API. C WP 4.7
			'rest_base'           => null, // $post_type. C WP 4.7
			'menu_position'       => null,
			'menu_icon'           => null,
			//'capability_type'   => 'post',
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'        => false,
			'supports'            => [ 'title', 'custom-fields' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => [],
			'has_archive'         => false,
			'rewrite'             => true,
			'query_var'           => true,
		] );*/

		register_post_type( $this->messagesCustomPostName, [
			'label'  => null,
			'labels' => [
				'name'               => 'Сообщения', // основное название для типа записи
				'singular_name'      => 'Сообщение', // название для одной записи этого типа
				'add_new'            => 'Добавить Сообщение', // для добавления новой записи
				'add_new_item'       => 'Добавление Сообщения', // заголовка у вновь создаваемой записи в админ-панели.
				'edit_item'          => 'Редактирование Сообщения', // для редактирования типа записи
				'new_item'           => 'Новое Сообщение', // текст новой записи
				'view_item'          => 'Смотреть Сообщение', // для просмотра записи этого типа.
				'search_items'       => 'Искать в Сообщениях', // для поиска по этим типам записи
				'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
				'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
				'parent_item_colon'  => '', // для родителей (у древовидных типов)
				'menu_name'          => 'Сообщения', // название меню
			],
			'description'         => '',
			'public'              => true,
			// 'publicly_queryable'  => null, // зависит от public
			// 'exclude_from_search' => null, // зависит от public
			// 'show_ui'             => null, // зависит от public
			// 'show_in_nav_menus'   => null, // зависит от public
			'show_in_menu'        => true, // показывать ли в меню адмнки
			// 'show_in_admin_bar'   => null, // зависит от show_in_menu
			'show_in_rest'        => null, // добавить в REST API. C WP 4.7
			'rest_base'           => null, // $post_type. C WP 4.7
			'menu_position'       => null,
			'menu_icon'           => null,
			//'capability_type'   => 'post',
			//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
			//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
			'hierarchical'        => false,
			'supports'            => [ 'title', 'editor', 'custom-fields' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
			'taxonomies'          => [],
			'has_archive'         => false,
			'rewrite'             => true,
			'query_var'           => true,
		] );
	}

	public function addCustomPostsMetaboxes() {
		$this->addMetabox('Код формы', $this->formsCustomPostName, self::handleName.'form_html');
		$this->addMetabox('Шаблон сообщения', $this->formsCustomPostName, self::handleName.'message_template');

	}

	public function saveMetaboxes($post_id) {
		$this->saveMetabox($post_id,self::handleName.'form_html');
		$this->saveMetabox($post_id,self::handleName.'message_template');
	}

	protected function addMetabox($title, $postType, $metaKey ) {
		$screens = array( $postType );
		add_meta_box(
			$metaKey,
			$title,
			function ( $post, $meta ) use ($metaKey) {
			$screens = $meta['args'];

			// Используем nonce для верификации
			wp_nonce_field( plugin_basename(__FILE__), self::handleName.'metaboxes_nonce' );

			// значение поля
			$value = get_post_meta( $post->ID, $metaKey, true );
			// Поля формы для введения данных
			echo '<label for="'.$metaKey.'"></label> ';
			echo '<textarea id="'.$metaKey.'" name="'.$metaKey.'" cols="100" rows="20">'. $value .'</textarea>';
			},
			$screens );

	}
	protected function saveMetabox($post_id,$metaKey) {
		// Убедимся что поле установлено.


		if ( ! isset( $_POST[$metaKey] ) )
			return;

//		// проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
//		if ( ! wp_verify_nonce( self::handleName.'metaboxes_nonce', plugin_basename(__FILE__) ) )
//			return;

		// если это автосохранение ничего не делаем
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return;

		// проверяем права юзера
		if( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Все ОК. Теперь, нужно найти и сохранить данные
		// Очищаем значение поля input.
		$my_data = wp_kses( $_POST[$metaKey], 'p,div,input,form,strong,b' );

		// Обновляем данные в базе данных.
		update_post_meta( $post_id, $metaKey, $my_data );

	}
}