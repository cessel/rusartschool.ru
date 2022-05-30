<?
require_once(get_template_directory().'/theme_settings/redirects.php');
require_once(get_template_directory().'/theme_settings/multisite_settings.php');
require_once(get_template_directory().'/theme_settings/settings.php');
require_once(get_template_directory().'/includes/Classes/IpGeoClass.php');
require_once(get_template_directory().'/theme_settings/coordinate_calc.php');

$self_link = str_replace("?".$_SERVER['QUERY_STRING'],'',$_SERVER['REQUEST_URI']);
define('SELF_LINK',$self_link);
define('MAIN_BLOG_ID',4);
define('MAIN_BLOG_MENU_NAME','top-menu-082019');

define('CES_IMG',get_template_directory_uri()."/img");

remove_action( 'wp_head',             'wp_enqueue_scripts');
remove_action( 'wp_head',             'feed_links');
remove_action( 'wp_head',             'feed_links_extra');
remove_action( 'wp_head',             'rsd_link');
remove_action( 'wp_head',             'wlwmanifest_link');
remove_action( 'wp_head',             'adjacent_posts_rel_link_wp_head');
remove_action( 'wp_head',             'locale_stylesheet');
remove_action( 'wp_head',             'noindex');
//remove_action( 'wp_head','wp_print_styles');
//remove_action( 'wp_head',             'wp_print_head_scripts');
remove_action( 'wp_head',             'wp_generator');
remove_action( 'wp_head',             'rel_canonical');
//remove_action( 'wp_footer',           'wp_print_footer_scripts' );
remove_action( 'wp_head',             'wp_shortlink_wp_head');
remove_action( 'template_redirect',   'wp_shortlink_header');
//remove_action( 'wp_print_footer_scripts', '_wp_footer_scripts');

/*
if ( ! is_admin() ) {
	remove_action( 'wp_head', 'wp_print_scripts' );
	remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
	remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
	add_action( 'wp_footer', 'wp_print_scripts', 5 );
	add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
	add_action( 'wp_footer', 'wp_print_head_scripts', 5 );
}
*/

/* Асинхронное подключение файлов - для включения в handle указать через дефис async или defer */
/**
 * Add async or defer attributes to script enqueues
 * @author Mike Kormendy
 * @param  String  $tag     The original enqueued <script src="...> tag
 * @param  String  $handle  The registered unique name of the script
 * @return String  $tag     The modified <script async|defer src="...> tag
 */
// only on the front-end
if(!is_admin()) {
	function add_asyncdefer_attribute($tag, $handle) {
		// if the unique handle/name of the registered script has 'async' in it
		if (strpos($handle, 'async') !== false) {
			// return the tag with the async attribute
			return str_replace( '<script ', '<script async ', $tag );
		}
		// if the unique handle/name of the registered script has 'defer' in it
		else if (strpos($handle, 'defer') !== false) {
			// return the tag with the defer attribute
			return str_replace( '<script ', '<script defer ', $tag );
		}
		// otherwise skip
		else {
			return $tag;
		}
	}
	add_filter('script_loader_tag', 'add_asyncdefer_attribute', 10, 2);
}


/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param    array  $plugins
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}

	return array();
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param  array  $urls          URLs to print for resource hints.
 * @param  string $relation_type The relation type the URLs are printed for.
 * @return array                 Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {

	if ( 'dns-prefetch' == $relation_type ) {

		// Strip out any URLs referencing the WordPress.org emoji location
		$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
		foreach ( $urls as $key => $url ) {
			if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
				unset( $urls[$key] );
			}
		}

	}

	return $urls;
}



/* АВТОМАТИЧЕСКОЕ ПОДКЛЮЧЕНИЕ JS И CSS ФАЙЛОВ ИЗ ПАПКИ /js/ и /css/ СООТВЕТСТВЕННО */

function CWG_scripts()
	{
	    $v = '09082019';
	    $v = microtime();
		$dir_js = get_template_directory().'/js/';
		$dir_css = get_template_directory().'/css/';
		$js_files=scandir($dir_js);
		$css_files=scandir($dir_css);

		if ( !is_admin() ) {
		    wp_deregister_script('jquery');
		    if(!is_user_logged_in())
                {
	                wp_deregister_style('dashicons');
                }

		}
		//wp_deregister_script('jquery');

		wp_enqueue_style('style_main', get_template_directory_uri() . '/style.css','',$v);

		if(get_page_template_slug() == 'contacts.php') {
			wp_enqueue_script('script_ymaps', 'https://api-maps.yandex.ru/2.1/?apikey=3fd25956-e412-424f-863e-4baa63ea3ba6&lang=ru_RU','',$v);
        }


		wp_enqueue_script('insta-w', 'https://apps.elfsight.com/p/platform.js'); // async
		wp_enqueue_script('testi-slider-js', get_template_directory_uri().'/lib/lightslider/dist/js/lightslider.min.js');
		wp_enqueue_script('pngfix', get_template_directory_uri() .'js/pngfix.js'); // async
		wp_script_add_data('pngfix', 'conditional', 'lt IE 9');
		$i=0;
		foreach ($js_files as $js) {
			$extension = explode( '.', $js );
			if ( $extension[ count( $extension ) - 1 ] == 'js' ) {
				if ( $extension[0] == 'zzmisc' ) {
					$script_id = 'script-main';
				} else {
					$script_id = ( $extension[0] == '!jquery' ) ? 'jquery' : 'script' . $i ++;
				}

				wp_enqueue_script( $script_id, get_template_directory_uri() . '/js/' . $js, '', $v );
			}
		}
		$blog_details = get_blog_details(auto_select_filial());
		$current_blog_id = get_current_blog_id();
		$current_blog_adress = get_current_single_contact('address');
		$vars = ['geo_target_filial_data'=>$blog_details,'current_blog_id'=>$current_blog_id,'current_blog_adress'=>$current_blog_adress];
		wp_localize_script('script-main','vars',$vars);
			$i=0;
		wp_enqueue_script('cookie-js', get_template_directory_uri().'/lib/js_cookie/js.cookie.min.js');

		wp_enqueue_style('testi-slider-css', get_template_directory_uri().'/lib/lightslider/dist/css/lightslider.min.css');

		foreach ($css_files as $css)
			{
				$extension = explode('.',$css);
				if($extension[count($extension)-1]=='css')
					{
						wp_enqueue_style('style'.$i++, get_template_directory_uri() . '/css/' . $css,'',$v);
					}
			}

	}
add_action( 'wp_enqueue_scripts', 'CWG_scripts' );
add_action( 'admin_enqueue_scripts', 'CWG_admin_scripts' );
function CWG_admin_scripts(){
	$v = microtime();
	$dir_js = get_template_directory().'/js/';
	wp_enqueue_style('adminstyle', '/wp-content/themes/cesselWebgateTheme_014_alfa/css/admin_classes.css','',$v);
}
	
	
function modal_toggle_link($link_text,$id_modal,$link_class='btn btn-default')
	{
		echo '<a href="'.$id_modal.'" data-toggle="modal" data-target="'.$id_modal.'" class="'.$link_class.'">'.$link_text.'</a>';
	}
function get_sitedata($varname, $pageID = false, $post_type = 'post') {
	$switched_blog = false;
	if ( ! $pageID || $pageID == '' ) {
		$page   = get_page_by_title( 'Контакты' );
		$pageID = $page->ID;
	}

	if(empty($pageID)){
		if ( is_multisite()  && get_current_blog_id() !== MAIN_BLOG_ID) {
			switch_to_blog( MAIN_BLOG_ID );
			$switched_blog = true;
		}
		$page   = get_page_by_title( 'Контакты' );
		$pageID = $page->ID;

	}
	$return_metadata = get_metadata( $post_type, $pageID, $varname, true );

	if ( $switched_blog ) {
		restore_current_blog();
	}

	return $return_metadata;
}

function remove_opensans_font()
	{
			
	}
function add_responsive_class($string,$class='')
	{
		if (($string!='')&&($class!=''))
			{
				$class=str_replace(' ','-',$class); 
				$dim = array('lg','md','sm','xs');
				$class_insert=$class;
				
				$string=trim($string);
				$string=str_replace("\"",'\'',$string);
				$classpos=strpos($string,'class');
				$taglenght=strpos($string,' ');
				if (!$classpos&&!$taglenght)
					{
						$endtaglenght=strpos($string,'>');
						$return_string = '';
						foreach($dim as $d)
							{
								$return_string .= substr_replace($string," class='".$class." ".$class."-".$d." visible-".$d."' >",$endtaglenght,1);
							}
					}
				else if ($classpos)
					{
						$return_string = '';
						foreach($dim as $d)
							{
								$return_string .= substr_replace($string,"'".$class." ".$class."-".$d." visible-".$d." ",$classpos+strlen('class="')-1,1)."\n";
							}
					}
				else if ($taglenght)
					{
						$return_string = '';
						foreach($dim as $d)
							{
								$return_string .= substr_replace($string," class='".$class." ".$class."-".$d." visible-".$d."' ",$taglenght,1);
							}

					}
					
				return $return_string;
			}
		else
			{
				return false;
			}
	}


function list_hooked_functions($tag=false){
 global $wp_filter;
 if ($tag) {
  $hook[$tag]=$wp_filter[$tag];
  if (!is_array($hook[$tag])) {
  trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
  return;
  }
 }
 else {
  $hook=$wp_filter;
  ksort($hook);
 }
 echo '<pre>';
 foreach($hook as $tag => $priority){
  echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
  ksort($priority);
  foreach($priority as $priority => $function){
  echo $priority;
  foreach($function as $name => $properties) echo "\t$name<br />";
  }
 }
 echo '</pre>';
 return;
}

register_nav_menus(array(
	'top'    => 'Верхнее меню',    //Название месторасположения меню в шаблоне
	'bottom' => 'Нижнее меню'      //Название другого месторасположения меню в шаблоне
));

function wp_kama_theme_setup(){
	// Поддержка миниатюр
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
}
add_action( 'after_setup_theme', 'wp_kama_theme_setup' );
register_sidebars(2);

add_action( 'widgets_init', 'register_my_widgets' );
function register_my_widgets() {
	register_sidebar( array(
		'name'          => 'Блок справа от формы контактов',
		'id'            => "contact-form-right-sidebar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div>',
		'after_widget'  => "</div>",
		'before_title'  => '<h4>',
		'after_title'   => "</h4>",
	) );
	register_sidebar( array(
		'name'          => 'Блок с видео в подвале',
		'id'            => "videoblock-in-footer",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<div>',
		'after_widget'  => "</div>",
		'before_title'  => '<h4>',
		'after_title'   => "</h4>",
	) );
}

function category_for_carousel($postID,$selector = 'owl-carousel')
	{	
		$media = get_attached_media('image',$postID);
		$video = get_attached_media('video',$postID);
		$video_url = get_sitedata('video',$postID);
		if ($media)
			{
				$category_html="<div class='".$selector."'>";
				foreach ($media as $m)
					{
						$image_url = $m->guid;
						if($image_url)
							{
								$category_html.=
									"<div class='".$selector."-item'>
										<img src='".$image_url."' class='img-responsive'>
									</div>";
							}			
					}
				$category_html.="</div>";
			}
		else if ($video||$video_url)
			{
				$video = array_shift( $video );
				if(isset($video))
					{
						$video_url->guid;
					}
				
				$category_html = do_shortcode('[video src="'.$video_url.'"][/video]');
			}
		else
			{
				$category_html="<div class='".$selector."'>";
				$category_html.=
					"<div class='".$selector."-item'>
						<img src='".CES_IMG."/img_for_latest_news_sqr.png' class='img-responsive'>
					</div>";
				$category_html.="</div>";
			}
		return $category_html;
	}


function last_news_gallery()
	{
		$posts = get_posts( array(
			'numberposts'     => 1, // тоже самое что posts_per_page
			'offset'          => 0,
			'category'        => 'news',
			'orderby'         => 'post_date',
			'order'           => 'DESC',
			'include'         => '',
			'exclude'         => '',
			'meta_key'        => '',
			'meta_value'      => '',
			'post_type'       => 'post',
			'post_mime_type'  => '', // image, video, video/mp4
			'post_parent'     => '',
			'post_status'     => 'publish'
		) );
		foreach($posts as $post){ setup_postdata($post);
			
			echo category_for_carousel($post->ID);
		}
		wp_reset_postdata();
	}
function get_latest_news($num = 3)
	{
		$posts = get_posts( array(
			'numberposts'     => $num, // тоже самое что posts_per_page
			'offset'          => 0,
			'category'        => 'news',
			'orderby'         => 'post_date',
			'order'           => 'DESC',
			'include'         => '',
			'exclude'         => '',
			'meta_key'        => '',
			'meta_value'      => '',
			'post_type'       => 'post',
			'post_mime_type'  => '', // image, video, video/mp4
			'post_parent'     => '',
			'post_status'     => 'publish'
		) );
		foreach($posts as $post){ setup_postdata($post);
			$news_block .= "
				<div class='row'>
					<div class='col-lg-2 col-md-3 col-sm-3 col-xs-12 latest-news-date-wrapper'>
						<p class='latest-news-date'>".get_post_time('j M Y',false,$post,true)."</p>
					</div>
					<div class='col-lg-10 col-md-9 col-sm-9 col-xs-12 latest-news-one-wrapper'>
						<p class='latest-news-title'><a href='".get_the_permalink($post->ID)."'>".$post->post_title."</a></p>
						<p class='latest-news-excerpt'>".get_the_excerpt( $post )."</p>
					</div>
				</div>";
			
			
			
		}
		wp_reset_postdata();
		
		echo $news_block;

	}
function new_excerpt_length($length) {

	return 8;

}

add_filter('excerpt_length', 'new_excerpt_length');

if (!function_exists('mb_ucfirst') && extension_loaded('mbstring'))
{
    /**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
	function mb_ucfirst($str, $encoding='UTF-8')
		{
			$str = mb_strtolower($str, $encoding);
			$str = mb_ereg_replace('^[\ ]+', '', $str);
			$str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
				   mb_substr($str, 1, mb_strlen($str), $encoding);
			return $str;
		}
}
function get_works()
	{
		$slug = 'portfolio';
		$idObj = get_category_by_slug($slug); 
		$id = $idObj->term_id;
		$args = array ('numberposts'=>99999,'post_status' => 'publish','post_type'=>'works');
		$data = get_posts( $args );
		$count_posts = count($data);
		
		
		global $wp_query;
		$posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
		$paged = (int) $wp_query->query_vars['page'];
		$max_page = round($count_posts/$posts_per_page);
		
		if(!isset($paged)||$paged == 0){$paged=1;}
		
		

		$start = $posts_per_page*($paged-1);
		$end = $posts_per_page*$paged;
		if ($end>$count_posts)
			{
				$end = $count_posts;
			}
		if(is_user_logged_in())
			{
				$logged_class = 'logged';
			}
		else
			{
				$logged_class = 'not_logged';
			}
		$user_id = get_current_user_id();
		
		//for ($i=$start;$i<$end;$i++)
		for ($i=0;$i<count($data);$i++)
			{
				$post_id =$data[$i]->ID;
				$group = get_the_terms($post_id,'age-group'); 
				$img_url = get_post_meta($post_id,'wpcf-work-img',true);
				$author_id = get_post_meta($post_id,'wpcf-work-author-id',true);
				$author = get_userdata( $author_id );
				$img = "<img src='".$img_url."' class='img-responsive'>";
				$rating = get_post_meta($post_id,'wpcf-work-votes',true);
				$work['post_id']=$post_id;
				$work['img_url']=$img_url;
				$work['rating']=$rating;
				$work['img']=$img;
				$works[$group[0]->term_id][]=$work;
			}
			$count = max(count($works['13']),count($works['14']),count($works['15']));
			echo "<div class='row works-groups-title'>";
			echo "<div class='col-xs-4'>";
			echo "<p class='group-title'>Дети 7-9 лет</p>";
			echo "</div>";
			echo "<div class='col-xs-4'>";
			echo "<p class='group-title'>Дети 10-11 лет</p>";
			echo "</div>";
			echo "<div class='col-xs-4'>";
			echo "<p class='group-title'>Дети 11-12 лет</p>";
			echo "</div>";
			echo "</div>";
			echo "<div class='row works-wrapper'>";
			
			echo "<div class='col-xs-4 col-responsive'>";
			for($j=0;$j<$count;$j++)
				{
					work_print($works['13'][$j]);
				}			
			echo "</div>";
			echo "<div class='col-xs-4 col-responsive'>";
			for($j=0;$j<$count;$j++)
				{
					work_print($works['14'][$j]);
				}			
			echo "</div>";
			echo "<div class='col-xs-4 col-responsive'>";
			for($j=0;$j<$count;$j++)
				{
					work_print($works['15'][$j]);
				}			
			echo "</div>";
					
			
		echo "</div>";
		wp_reset_postdata();
		
		
		$link = get_the_permalink();
		//echo cessel_corenavi($max_page,$paged,$link);
	}
function work_print($work)
	{
		if(isset($work))
			{
				echo "<div class='row work-row'>";
				echo "<div class='col-xs-12'>";
				echo "<div class='work-item' data-post_id='".$work['post_id']."'>";
				echo "<div class='work-img-wrapper'>";
				echo "<a href='".$work['img_url']."' rel='lightbox[".$work['post_id']."]'>".$work['img']."</a>";
				echo "<button class='btn btn-default btn-rating hidden-xs'>".$work['rating']."</button>";
				echo "<button class='btn btn-default btn-rating btn-xs visible-xs'>".$work['rating']."</button>";
				echo "</div>";
				echo "<span class='work vote-btn-span' data-post_id='".$work['post_id']."'>";
				echo "<button class='btn btn-default btn-vote btn-sm hidden-xs'>Проголосовать</button>";
				echo "<button class='btn btn-default btn-vote btn-xs visible-xs'><i class='fa fa-check' aria-hidden='true'></i></button>";
				echo "</span>";
				echo "<span class='zoom-icon-span'>";
				echo "<a href='".$work['img_url']."' rel='lightbox[".$work['post_id']."_z]'>";
				echo "<i class='fa fa-search-plus fa-2x hidden-xs' aria-hidden='true'></i>";
				echo "<i class='fa fa-search-plus visible-xs' aria-hidden='true'></i>";
				echo "</a>";
				echo "</span>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
			}
		else
			{
				echo "<div class='row'>";
				echo "<div class='col-xs-4'>";
				echo "</div>";
				echo "</div>";
				
			}
	}
function cessel_corenavi($max_p,$curr_p,$link,$format = '%s') 
	{
		$link_sep = '';
		$prev_p = $curr_p-1;
		$next_p = $curr_p+1;
		$link = $link.$link_sep;
		
		/* Блок кнопок НАЗАД */
		$prev_text = '<span aria-hidden="true">&laquo;</span>';
		if($curr_p==1)
			{
				$prev_block="<li class='disabled'><a href='#0'>".$prev_text."</a></li>";
			}
		else
			{
				
				$prev_block = "<li><a href='".$link.sprintf ($format,$prev_p)."/' title='".$prev_text."'>".$prev_text."</a></li>";
			}
		/* Блок кнопок начальной пагинации*/
		$max_s = $curr_p - 2;
		if($max_s>=3)
			{
				$max_s=2;
			}
		if(($max_s > 2) && ($max_s < 1))
			{
				$start_block = '';
			}
		else
			{
				for($i=1;$i<=$max_s;$i++)
					{
						$start_block .= "<li><a href='".$link.sprintf ($format,$i)."/' title='Страница ".$i."'>".$i."</a></li>";
					}
			}
		/* Блок кнопок слева от текущей страницы*/
		$l_cp = $curr_p-1;
		if($l_cp<1)
			{
				$left_cp_block='';
			}
		else
			{
				$left_cp_block = "<li><a href='".$link.sprintf ($format,$l_cp)."/' title='Страница ".$l_cp."'>".$l_cp."</a></li>";
			}
		/* Блок кнопки текущей страницы*/
		$curr_block = "<li class='active'><a href='#0' title='Страница ".$curr_p."'>".$curr_p."</a></li>";
			
		/* Блок кнопок справа от текущей страницы*/
		$r_cp =	$curr_p+1;
		if($r_cp>$max_p)
			{
				$right_cp_block='';
			}
		else
			{
				$right_cp_block = "<li><a href='".$link.sprintf ($format,$r_cp)."/' title='Страница ".$r_cp."'>".$r_cp."</a></li>";
			}
		/* Блок кнопок конечной пагинации*/
		$min_e = $curr_p + 2;
		if($min_e <= ($max_p - 2))
			{
				$min_e = $max_p - 1;
			}
		if(($min_e < ($max_p - 1)) && ($min_e > $max_p))
			{
				$end_block = '';
			}
		else
			{
				$end_block = '';
				for($i=$min_e;$i<=$max_p;$i++)
					{
						$end_block .= "<li><a href='".$link.sprintf ($format,$i)."/' title='Страница ".$i."'>".$i."</a></li>";
					}
			}

			/* Блок кнопок ДАЛЕЕ */
		$next_text = '<span aria-hidden="true">&raquo;</span>';
		if($next_p>=($max_p-1))
			{
				$next_block = "<li class='disabled'><a href='#0'>".$next_text."</a></li>";
			}
		else
			{
				$next_block = "<li><a href='".$link.sprintf ($format,$next_p)."/' title='".$next_text."'>".$next_text."</a></li>";
			}
		/* Блок троеточие между началом и блоком кнопок слева */
		if(($max_s<($l_cp-1)))
			{
				$spaces_l = "<li><a href='#...' title=''>...</a></li>";
			}
		/* Блок троеточие между концом и блоком кнопок справа */
		if(($min_e>($r_cp+1)))
			{
				$spaces_r = "<li><a href='#...' title=''>...</a></li>";
			}

		$pagination = "<div><ul class='pagination'>";
		$pagination .= $prev_block;
		$pagination .= $start_block;
		$pagination .= $spaces_l;
		$pagination .= $left_cp_block;
		$pagination .= $curr_block;
		$pagination .= $right_cp_block;
		$pagination .= $spaces_r;
		$pagination .= $end_block;
		$pagination .= $next_block;
		$pagination .= "</ul></div>";
		return $pagination;
	}

function set_votes($post_id)
	{
		$old_vote_data = (int)get_post_meta($post_id,'wpcf-work-votes',true);
		return update_metadata( 'works', $post_id, 'wpcf-work-votes', ($old_vote_data+1) );
		
	}
function get_votes($post_id)
	{
		return $vote_data = (int) get_post_meta($post_id,'wpcf-work-votes',true);
	}
function get_user_votes($user_id)
	{
		$vote_data = get_user_meta( $user_id, 'user-votes' );
		$vote_data_arr = explode('|',$vote_data[0]);
		return $vote_data_arr;
	}
function get_user_num_votes($user_id)
	{
		return (count(get_user_votes($user_id))-1);
	}
function vote($post_id,$user_id)
	{
		$user_votes_arr = get_user_votes($user_id);
		if($user_votes_arr=='')
			{
				$user_votes_arr = array();
			}
		
		if (is_user_work($post_id,$user_id))
			{
				exit('Вы не можете голосовать за свою работу');
			}
		else if (!is_user_logged_in())
			{
				exit('Для голосования нужно зарегистроваться');
			}
		elseif (in_array($post_id,$user_votes_arr))
			{
				exit('Вы уже проголосовали за эту работу');
			}
		else
			{
				add_vote($user_id,$post_id);
				exit('Ваш голос учтен');
			}
	}
function add_vote($user_id,$post_id)
	{
		post_add_vote($post_id);
		user_add_vote($user_id,$post_id);
	}
function post_add_vote($post_id)
	{
		$old_vote_data = (int)get_post_meta($post_id,'wpcf-work-votes',true);
		return update_post_meta( $post_id, 'wpcf-work-votes', ($old_vote_data+1) );
	}
function user_add_vote($user_id,$post_id)
	{
		$user_votes_arr = get_user_votes($user_id);
		$user_votes_arr[] = $post_id;
		//var_dump($user_votes_arr);
		$new_user_votes = implode('|',$user_votes_arr);
		update_user_meta( $user_id, 'user-votes', $new_user_votes );
		return true;
	}
function is_user_work($post_id,$user_id)
	{
		
		$author_id = get_post_meta($post_id,'wpcf-work-author-id',true);
		
		if( $user_id == $author_id )
			{
				return true;
			}
		else
			{
				return false;
			}
	}

function user_id_shortcode() {
	$user_id = get_current_user_id();
    return $user_id;
}
add_shortcode('cf_user_id', 'user_id_shortcode');


function header_conacts_block($type = 'adress')
    {

	   // $select_fil_ancor = 'Выбрать другой филиал';
       /* if (get_current_blog_id() == 3)
            {
	            $contacts['tel'] = get_sitedata('tel',15);
	            $contacts['tel1'] = get_sitedata('tel1',15);
	            $contacts['email'] = get_sitedata('email',15);
	            $contacts['adress'] = get_sitedata('adress',15);
	            $contacts['adress1'] = get_sitedata('adress1',15);
	            $contacts['adress2'] = get_sitedata('adress2',15);
	            $contacts['adress_shown'] = get_sitedata('adress_shown',15);
	            $contacts['adress_1_shown'] = get_sitedata('adress_1_shown',15);
                if ($type == 'adress')
                    {
	                    $return = "<p class='header-adress'>".$contacts['adress_shown']."</p>";
                    }
                else if ($type == 'phones')
                    {
	                    $return = "<p class='header-adress'>".$contacts['tel']."</p>";
                    }
            }
        else if (get_current_blog_id() == 4)
            {
	            $contacts['tel'] = get_sitedata('tel',15);
	            $contacts['tel1'] = get_sitedata('tel1',15);
	            $contacts['email'] = get_sitedata('email',15);
	            $contacts['adress'] = get_sitedata('adress',15);
	            $contacts['adress1'] = get_sitedata('adress1',15);
	            $contacts['adress2'] = get_sitedata('adress2',15);
	            $contacts['adress_shown'] = get_sitedata('adress_shown',15);
	            $contacts['adress_1_shown'] = get_sitedata('adress_1_shown',15);

	            if ($type == 'adress')
	            {
		            $return = "<p class='header-adress'>".$contacts['adress_1_shown']."</p>";
	            }
	            else if ($type == 'phones')
	            {
		            $return = "<p class='header-adress'>".$contacts['tel1']."</p>";
	            }

            }
        else
            {*/
	            $contacts['tel'] = get_sitedata('tel');
	            $contacts['tel1'] = get_sitedata('tel1');
	            $contacts['email'] = get_sitedata('email');
	            $contacts['adress'] = get_sitedata('adress');
	            $contacts['adress1'] = get_sitedata('adress1');
	            $contacts['adress2'] = get_sitedata('adress2');
	            $contacts['adress_shown'] = get_sitedata('adress_shown');
	            $contacts['adress_1_shown'] = get_sitedata('adress_1_shown');

		    if (get_current_blog_id() == 3)
	            {
		            $filial_1_class = 'header-adress-bold';
		            $filial_2_class = '';


	            }
		    else if (get_current_blog_id() == 4)
			    {
				    $filial_1_class = '';
				    $filial_2_class = 'header-adress-bold';
			    }
		    else
			    {
				    $filial_1_class = '';
				    $filial_2_class = '';
			    }
	            //$select_fil_ancor = "Выберите филиал";
        global $post;
	    $self_link = ($post->ID == 141) ? '' : SELF_LINK;

	            if ($type == 'adress')
	            {
		            $return = "<p class='header-adress $filial_1_class'>";
					$return .= "<a href='http://rechnoy.rusartschool.ru".$self_link."'>".$contacts['adress_shown']."</a>";
		            $return .= "</p>";
		            $return .= "<p class='header-adress $filial_2_class'>";
		            $return .= "<a href='http://vodniy.rusartschool.ru".$self_link."'>".$contacts['adress_1_shown']."</a>";
		            $return .= "</p>";
	            }
	            else if ($type == 'phones')
	            {
		            $return = "<p class='header-adress'>".$contacts['tel']."</p>";
		            $return .= "<p class='header-adress'>".$contacts['tel1']."</p>";
	            }
	            else if($type == 'filial1')
	                {
		                $return = "<p class='header-phone'>".$contacts['tel1']."</p>";
		                $return .= "<p class='header-adress $filial_1_class'>";
		                $return .= "<a href='http://rechnoy.rusartschool.ru".$self_link."'>".$contacts['adress_shown']."</a>";
		                $return .= "</p>";

	                }
	            else if($type == 'filial2')
	                {
		                $return = "<p class='header-phone'>".$contacts['tel']."</p>";

		                $return .= "<p class='header-adress $filial_2_class'>";
		                $return .= "<a href='https://vodniy.rusartschool.ru".$self_link."'>".$contacts['adress_1_shown']."</a>";
		                $return .= "</p>";

	                }



           /* }*/

	    if ($type == 'adress')
	    {
		   // $return .= "<a href='#fselect' class='select-filial' data-toggle='modal' data-target='#filial-select'>".$select_fil_ancor."</a>";
	    }



                echo $return;
	}



/* Для главной страницы*/
function get_main_banner_html(){
	$selector = 'баннеры';
	$data = get_data_network_items($selector);
	?>
	<div id='banner__carousel' class="banner__carousel owl-carousel">
        <?php
        foreach ( $data as $item ) {
	        the_banner_item( $item );
        }
        ?>
    </div>
    <?php
}
function get_main_banner(){
    global $post;
	$banners = get_network_field('баннеры');

	?>
    <div id='banner__carousel' class="banner__carousel owl-carousel">
	    <?
	    foreach ( $banners as $key=>$banner_item ) {
		    $banner['img'] = $banner_item['img'];
		    $banner['course_type'] = $banner_item['тип_курса'];
		    $banner['slogan'] = $banner_item['слоган_на_баннере'];
		    $banner['subtitle'] = $banner_item['подзаголовок_на_баннере'];
		    $banner['link'] = $banner_item['ссылка_с_кнопки'];

		    $update_banner_flag = false;
		    if(empty($banner['img'])){

		        switch_to_blog(MAIN_BLOG_ID);
			    $banners_default = get_network_field('баннеры');
			    restore_current_blog();
			    $banner['img'] = $banners_default[$key]['img'];
			    $update_banner_flag = true;
            }
		    if(!empty($banner['img'])) {
			    $banner_url = (is_int($banner['img'])) ? wp_get_attachment_image_url($banner['img'],'full') : $banner['img'];
			    $banners[$key]['img'] = (is_int($banner['img']))
                    ? $banner['img']
                    : attachment_url_to_postid($banner['img']);
			    if($update_banner_flag){
				    require_once ABSPATH . 'wp-admin/includes/media.php';
				    require_once ABSPATH . 'wp-admin/includes/file.php';
				    require_once ABSPATH . 'wp-admin/includes/image.php';
				    if(function_exists('media_sideload_image')){
					    $image_id = media_sideload_image( $banner_url, $post->ID, '', 'id' );
					    $banners[$key]['img'] = $image_id;
				    }
			    }
		    } else{
		        continue;
            }

		    if(get_current_blog_id() != MAIN_BLOG_ID && $update_banner_flag){
			    update_field('баннеры',$banners,$post->ID);
		    }
		    the_banner_items( $banner );
        }
	    ?>

	</div>

	    <?

}
function the_banner_item($banner) {
	$banner_url = (is_int($banner['img'])) ? wp_get_attachment_image_url($banner['img'],'full') : $banner['img'];

	?>
    <div class="banner__carouselItem" style="background-image:url('<? echo $banner_url; ?>')">
        <div class="banner__carouselTextBlock">
            <div class="banner__carouselCourseName"><? echo $banner['тип_курса']; ?></div>
            <div class="banner__carouselSlogan"><span><? echo $banner['слоган_на_баннере']; ?></span></div>
            <div class="banner__carouselSubtitle"><? echo $banner['подзаголовок_на_баннере']; ?></div>
            <div class="banner__carouselButtonBlock">
                <a href="<? echo $banner['ссылка_с_кнопки']; ?>" class="btn banner__carouselButton hvr-sweep-to-right">Узнать подробнее</a>
            </div>
        </div>
    </div>
	<?
}
function the_banner_items($banner) {
	$banner_url = (is_int($banner['img'])) ? wp_get_attachment_image_url($banner['img'],'full') : $banner['img'];

	?>
    <div class="banner__carouselItem" style="background-image:url('<? echo $banner_url; ?>')">
        <div class="banner__carouselTextBlock">
            <div class="banner__carouselCourseName"><? echo $banner['course_type']; ?></div>
            <div class="banner__carouselSlogan"><span><? echo $banner['slogan']; ?></span></div>
            <div class="banner__carouselSubtitle"><? echo $banner['subtitle']; ?></div>
            <div class="banner__carouselButtonBlock">
                <a href="<? echo $banner['link']; ?>" class="btn banner__carouselButton hvr-sweep-to-right">Узнать подробнее</a>
            </div>
        </div>
    </div>
	<?
}

function get_features_html(){
	$selector = 'преимущества';
	$data = get_data_network_items($selector);
	?>
    <div class='features__block'>
		<?php
		foreach ( $data as $item ) {
			the_feature_item( $item );
		}
		?>
    </div>
	<?php
}
function the_feature_item($features){

	$feature_url = (is_int($features['img'])) ? wp_get_attachment_image_url($features['img'],'full') : $features['img'];

	?>

    <div class="features__blockItem">
        <div class="features__blockItemInner">
            <div class="features__blockImage">
                <img src="<? echo $feature_url; ?>" alt="">
            </div>
            <div class="features__blockContent">
                <div class="features__blockTitle"><? echo $features['заголовок_преимущества'] ; ?></div>
                <div class="features__blockText"><? echo $features['описание_преимущества'] ; ?></div>
            </div>
        </div>
    </div>



	<?php
}


function get_features() {
	global $post;
	$features = get_network_field('преимущества');
    	?>
	    <div class="features__block">
	    <?

	    foreach ( $features as $key => $features_item ) {
		    $update_flag = false;
		    $features['img'] = $features_item['изображение_преимущества'];
		    $features['title'] = $features_item['заголовок_преимущества'];
		    $features['text'] = $features_item['описание_преимущества'];

		    if(empty($features['img'])){
			    switch_to_blog(MAIN_BLOG_ID);
			    $features_default = get_network_field('преимущества');
			    restore_current_blog();
			    $features['img'] = $features_default[$key]['изображение_преимущества'];
			    $update_flag = true;
		    }

		    if(!empty($features['img'])) {
			    $features['img'] = (is_int($features['img'])) ? wp_get_attachment_image_url($features['img'],'full') : $features['img'];
			    if($update_flag){
				    require_once ABSPATH . 'wp-admin/includes/media.php';
				    require_once ABSPATH . 'wp-admin/includes/file.php';
				    require_once ABSPATH . 'wp-admin/includes/image.php';
				    if(function_exists('media_sideload_image')){
					    $image_id = media_sideload_image( $features['img'], $post->ID, '', 'id' );
					    $features[$key]['изображение_преимущества'] = $image_id;
				    }
			    }



			    ?>

                    <div class="features__blockItem">
                        <div class="features__blockItemInner">
                            <div class="features__blockImage">
                                <img src="<? echo $features['img'] ; ?>" alt="">
                            </div>
                            <div class="features__blockContent">
                                <div class="features__blockTitle"><? echo $features['title'] ; ?></div>
                                <div class="features__blockText"><? echo $features['text'] ; ?></div>
                            </div>
                        </div>
                    </div>

			        <?
		    }
	    }
	    ?>
        </div>
	<?
	if(get_current_blog_id() != MAIN_BLOG_ID && $update_flag){
		update_field('преимущества',$features,$post->ID);
	}
}



function get_services_html(){
	$selector = 'услуги';
	$data = get_data_network_items($selector);
	?>
    <div class='services__block'>
		<?php
		foreach ( $data as $item ) {
			the_service_item( $item );
		}
		?>
    </div>
	<?php
}
function the_service_item($services){

	$service_url = (is_int($services['img'])) ? wp_get_attachment_image_url($services['img'],'full') : $services['img'];
    ?>

    <div class="services__blockItem">
        <div class="services__blockImage">
            <img src="<? echo $service_url ; ?>" alt="">
        </div>
        <div class="services__blockContent">
            <div class="features__blockTitle">
                <a href="<? echo $services['ссылка'] ; ?>">
                    <span><? echo $services['название_услуги'] ; ?></span>
                    <div class="services__more">
                        <a href="<? echo $services['ссылка'] ; ?>">
                            <span>Подробнее...</span>
                        </a>
                    </div>
                </a>
            </div>
        </div>
        <div class="overlay"></div>
    </div>


	<?php
}

function get_services()
    {

    	?>
	    <div class="services__block">
	    <?
	    $services_all = get_network_field('услуги');

	    foreach ( $services_all as $services_item ) {
		    $services['img'] = wp_get_attachment_image_url($services_item['img'],'large');
		    $services['name'] = $services_item['название_услуги'];
		    $services['link'] = $services_item['ссылка'];
		    if(empty($services['img'])){
			    switch_to_blog( MAIN_BLOG_ID );
			    $services['img'] = wp_get_attachment_image_url($services_item['img'],'large');
			    restore_current_blog();
            }
		    if(!empty($services['img']))
		        {
			        ?>

                    <div class="services__blockItem">
                        <div class="services__blockImage">
                            <img src="<? echo $services['img'] ; ?>" alt="">
                        </div>
                        <div class="services__blockContent">
                            <div class="features__blockTitle">
                                <a href="<? echo $services['link'] ; ?>">
                                    <span><? echo $services['name'] ; ?></span>
                                    <div class="services__more">
                                        <a href="<? echo $services['link'] ; ?>">
                                            <span>Подробнее...</span>
                                        </a>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="overlay"></div>
                    </div>

			        <?
		        }
        }
	    ?>

	    </div>

	    <?
    }

function get_page_content($args)
    {
        $post = get_post($args['id']);
        return apply_filters('the_content',$post->post_content);
    }

add_shortcode('get_page_content','get_page_content');


function get_post_media($postID)
    {
	    $media = get_attached_media('image',$postID);
	    $video = get_attached_media('video',$postID);
	    $video_url = get_sitedata('video',$postID);

        if(!empty($media))
            {
               // if($postID == 2738) {var_dump($media);}
	            $media = array_shift( $media );
    	        $image_url = wp_get_attachment_image_url($media->ID,'medium');
	           // return '<img src="'.$image_url.'" alt="">';
                return $image_url;
            }
        else if(!empty($video))
            {
	            $video = array_shift( $video );
	            //return do_shortcode('[video src="'.$video->guid.'"][/video]');
	            return "/wp-content/uploads/2017/12/depositphotos_5921529-Abstract-gray-texture-background.jpg";

            }
        else if(($video_url)&&(!empty($video_url))&&($video_url!=''))
            {
	            //return do_shortcode('[video src="'.$video_url.'"][/video]');
	            return "/wp-content/uploads/2017/12/depositphotos_5921529-Abstract-gray-texture-background.jpg";

            }
        else {
	        $image_thumb = get_the_post_thumbnail_url( $postID, 'large' );
	        if ( $image_thumb && $image_thumb != '' && ! empty( $image_thumb ) )
	            {
		           // return '<img src="'.$image_thumb.'" alt="">';
		            return $image_thumb;

	            }
            else
                {
	               // return '<img src="'.CES_IMG.'/img_for_latest_news_sqr.png" alt="">';
	                return "/wp-content/uploads/2017/12/depositphotos_5921529-Abstract-gray-texture-background.jpg";

                }

            }
    }
function news_carousel($cat_id)
    {
        $args = array
            (
                'category'      =>  $cat_id,
                'numberposts'   =>  10
            );

        $posts = get_posts($args);
        $return = '<div class="owl-carousel" id="news-carousel">';
	    foreach ( $posts as $post ) {
            $return .= '<div class="newscarousel__item">';

            $return .= '<div class="newscarousel__itemInner" style="background-image: url(\''.get_post_media($post->ID).'\');">';

		    $return .= '<div class="newscarousel__itemTitle">';
		    $return .= mb_substr( get_the_title($post->ID),0,30)."...";
		    $return .= '</div>';

		    $return .= '<div class="newscarousel__itemDate">';
		    $return .= get_the_date("d.m.Y",$post->ID);
		    $return .= '</div>';


		    $return .= '</div>';

		    $return .= '<a href="'.get_post_permalink($post).'"></a>';

		    $return .= '</div>';

        }
	    $return .= '</div>';

        return $return;
    }

function show_youtube_video($video_id, $echo = true) {

	$videoblock = '<div class="youtube" id="' . $video_id . '"></div>';
	if ( $echo ) {
		echo $videoblock;

		return true;
	} else {
		return $videoblock;
	}
}
function show_map($longtitude, $lattitude,$adress,$sitename = false)
{
	$sitename = ($sitename) ? $sitename : get_bloginfo('name');
	echo '<!-- MAP SECTION --><div class="ymap-container"><div class="loader loader-default"></div><div id="map-yandex" data-sitename="'.$sitename.'" data-adress="'.$adress.'" data-lat="'.$lattitude.'" data-long="'.$longtitude.'"></div></div><!-- .ymap-container --><!-- END MAP SECTION -->';
}
function show_multipoint_map($map_data)
{
    //$longtitude, $lattitude,$adress,$sitename = false
	foreach ( $map_data as $item ) {
		$sitenames[] = ($item['label']) ? $item['label'] : get_bloginfo('name');
		$addresses[] = $item['address_map'];
		$latitudes[] = $item['latitude'];
		$longitudes[] = $item['longitude'];
	}
	echo "<!-- MAP SECTION --><div class='ymap-container'><div class='loader loader-default'></div><div id='map-yandex-multipoints' data-sitename='".json_encode($sitenames,JSON_UNESCAPED_UNICODE)."' data-adress='".json_encode($addresses,JSON_UNESCAPED_UNICODE)."' data-lat='".json_encode($latitudes,JSON_UNESCAPED_UNICODE)."' data-long='".json_encode($longitudes,JSON_UNESCAPED_UNICODE)."'></div></div><!-- .ymap-container --><!-- END MAP SECTION -->";

}
function phone_convert_to_link($tel,$class = '', $ancor = false,$echo = true)
{
	$ancor = $ancor ? $ancor : $tel;

	$html = "<a href='tel:".preg_replace('/[ \-()]/','',$tel)."' class='".$class."'>".$ancor."</a>";
	if($echo == true){ echo $html;}
	else{return $html;}
}
function whatsapp_convert_to_link($tel, $class = '', $ancor = false, $echo = true) {
	$ancor = $ancor ? $ancor : $tel;

	$html = "<a href='tel:" . preg_replace( '/[ \-()]/', '', $tel ) . "' class='" . $class . "'>" . $ancor . "</a>";
	if ( $echo == true ) {
		echo $html;
	} else {
		return $html;
	}
}
function email_convert_to_link($email,$class = '',$echo = true,$ancor ='')
{
    $ancor = (empty($ancor)) ? $email : $ancor;
	$class = (!empty($class))? 'class="'.$class.'"':'';
	$html = '<a href="mailto:'.$email.'" '.$class.'>'.$ancor.'</a>';
	if($echo == true){ echo $html;}
	else{return $html;}
}

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Настройки сайта',
		'menu_title'	=> 'Настройки сайта',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

/**
 * Функция возвращает окончание для множественного числа слова на основании числа и массива окончаний
 * param  $number Integer Число на основе которого нужно сформировать окончание
 * param  $endingsArray  Array Массив слов или окончаний для чисел (1, 4, 5),
 *         например array('яблоко', 'яблока', 'яблок')
 * return String
 */
function getNumEnding($number, $endingArray)
{
	$number = $number % 100;
	if ($number>=11 && $number<=19) {
		$ending=$endingArray[2];
	}
	else {
		$i = $number % 10;
		switch ($i)
		{
			case (1): $ending = $endingArray[0]; break;
			case (2):
			case (3):
			case (4): $ending = $endingArray[1]; break;
			default: $ending=$endingArray[2];
		}
	}
	return $ending;
}

function get_tesimonials_vk_users()
{
	$access_token = '6df519726df519726df51972446da30e8566df56df51972313098e06ff8c86937af9256';
	$client_secret = 'UXqJKO70WqWE8LkoGJyY';
	$fields = 'photo_50,domain';
    $group_id = '30004163';
	$count = 20;
	$lang="ru";


	$url = 'http://api.vk.com/method/groups.getMembers.json?group_id='. $group_id
	       .'&fields='.$fields
	       .'&count='.$count
	       .'&access_token='.$access_token
	       .'&client_secret='.$client_secret
	       .'&lang='.$lang
	       .'&v=5.102';

	$result = file_get_contents($url);
	$answer = json_decode($result,true);
	$users = $answer['response'];
	$users = (is_array($users))?$users:[];
	$users_json = json_encode($users,JSON_UNESCAPED_UNICODE);



	$fields = "screen_name";

	$url = 'http://api.vk.com/method/groups.getById.json?group_id='. $group_id
	       .'&fields='.$fields
	       .'&lang='.$lang
	       .'&access_token='.$access_token
	       .'&client_secret='.$client_secret
	       .'&v=5.102';

	$result = file_get_contents($url);
	$answer = json_decode($result,true);
	$group = $answer['response'][0];
	$group = (is_array($group))?$group:[];
	$group_json = json_encode($group,JSON_UNESCAPED_UNICODE);


	update_field('vk_group_json',$users_json,'options');
    update_field('vk_group_params',$group_json,'options');
    return true;
}

function get_vk_testi()
{

    $get_json = get_field('vk_group_json','options');

	$html = '';
	if(!empty($get_json)) {

	    $group_json = get_field('vk_group_params','options');

		$users = json_decode( $get_json, true );
        $group = json_decode( $group_json, true );

		$html .= "<div class='vk-users'>";
		$html .= "<div class='vk-users__inner'>";

		$html .= "<div class='vk-users__header'>";

		$html .= "<div class='vk-users__logo'>";
		$html .= "<img src='".$group['photo_50']."' alt='".$group['name']." - Вконтакте' title='".$group['name']." - Вконтакте'>";
		$html .= "</div>";

		$html .= "<div class='vk-users__groupname'>";
		$html .= "<a href='//vk.com/". $group['screen_name']."'>";
		$html .= $group['name'];
		$html .= "</a>";
		$html .= "</div>";

		$html .= "</div>";

		$html .= "<div class='vk-users__count'>";
		$html .= "<a href='//vk.com/". $group['screen_name']."'>";
		$html .= $users['count'].' '.getNumEnding($users['count'], ['участник','участника','участников']);
		$html .= "</a>";
		$html .= "</div>";

		$html .= "<div class='vk-users__list'>";

		foreach ( $users['items'] as $user ) {

			$html .= "<div id='vk_user_" . $user['id'] . "' class='vk-user'>";
			$html .= "<div class='vk-user__inner'>";
			$html .= "<a href='//vk.com/". $user['domain']."'>";
			$html .= "<img src='".$user['photo_50']."' alt='".$user['first_name']."' title='".$user['first_name']."'>";
			$html .= "</a>";
			$html .= "</div>";
			$html .= "</div>";
		}
		$html .= "</div>";

		$html .= "<div class='vk-users__footer'>";

		$html .= "<div class='vk-users__subscribe'>";
		$html .= "<a href='//vk.com/". $group['screen_name']."'>";
		$html .= "Подписаться";
		$html .= "</a>";
		$html .= "</div>";

		$html .= "</div>";


		$html .= "</div>";
		$html .= "</div>";
	}

	return $html;

}
function my_acf_save_post( ) {
	get_tesimonials_vk_users();
}

add_action('acf/save_post', 'my_acf_save_post', 20);

function show_testimonials()
    {
        /**
         * @var $comment WP_Comment
         */
        $args = ['status'=>'approve','parent'=>0];
        $comments = get_comments($args);

        $html = '<div class="testimonials-wrapper">';
        $html .= '<ul id="vertical" class="testimonials">';

	    foreach ( $comments as $comment ) {
	        $testi_arr['name']  = $comment->comment_author;
	        $testi_arr['text']  = print_r($comment->comment_content,true);
	        $testi_arr['date']  = print_r($comment->comment_date,true);
	        $testi_arr['photo'] = get_field('comment_user_photo','comment_'.$comment->comment_ID);
	        $testi_arr['photo'] = (!$testi_arr['photo']) ? get_avatar_url($comment->user_id) : $testi_arr['photo'];

	        $testi_arr['link']  = $comment->comment_author_url;
		    $args_child = ['status'=>'approve','parent'=>$comment->comment_ID];
		    $comments_child = get_comments($args_child);
            $html .= '<li data-id="'.$comment->comment_ID.'" class="testimonials__item">'.get_testimonial_html($testi_arr);
            if($comments_child) {
	            $html .= '<ul class="testimonial-childs">';
	            foreach ( $comments_child as $item ) {
		            $testi_arr['name']  = $item->comment_author;
		            $testi_arr['text']  = print_r($item->comment_content,true);
		            $testi_arr['date']  = print_r($item->comment_date,true);
		            $testi_arr['photo'] = wp_get_attachment_image_url(get_field('comment_user_photo','comment_'.$item->comment_ID),'thumbnail');
		            $testi_arr['photo'] = (!$testi_arr['photo']) ? wp_get_attachment_image_url(get_field('comment_user_photo','user_'.$item->user_id),'thumbnail'): $testi_arr['photo'];
		            $testi_arr['photo'] = (!$testi_arr['photo']) ? get_avatar_url($item->user_id) : $testi_arr['photo'];

		            $testi_arr['link']  = $item->comment_author_url;

		            $html .= '<li data-id="'.$item->comment_ID.'" class="testimonials__item">'.get_testimonial_html($testi_arr);

		            $html .='</li>';
	            }
	            $html .= '</ul>';
            }
	            $html .='</li>';


        }
        $html .= '</ul>';

	    $html .= '<div class="testimonials-dots">';
	    $flag = true;
	    foreach ( $comments as $comment ) {
	        if($flag == true){$class=' active';$flag=false;}
	        else{$class='';}
		    $html .= '<div id="'.$comment->comment_ID.'" class="testimonials-dots__item'.$class.'"></div>';
	    }
        $html .= '</div>';
        $html .= '</div>';

        return $html;

    }

function get_testimonial_html(array $testimonial)
    {
        if(empty($testimonial['text'])){return '';}

        $photo_url = ($testimonial['photo']) ? $testimonial['photo'] : get_field('testi_default_photo');
	    $photo = ($testimonial['link']) ? sprintf('<a href="%s"><img src="%s" alt="'.get_bloginfo('name').' - Отзыв - '.$testimonial['name'].'"></a>',$testimonial['link'],$photo_url) : '<img src="'.$photo_url.'" alt="'.get_bloginfo('name').' - Отзыв - '.$testimonial['name'].'">';

	    $name = ($testimonial['link']) ? sprintf('<a href="%s">%s</a>',$testimonial['link'],$testimonial['name']) : $testimonial['name'];

        $html = '<div class="testimonial">';
        $html .= '<div class="testimonial__photo">';
	    $html .= $photo;
        $html .= '</div>';
        $html .= '<div class="testimonial__content">';
	    $html .= '<div class="testimonial__title">';
        $html .= '<span>'.$name.'</span>';
        $html .= '<span>'.$testimonial['date'].'</span>';
	    $html .= '</div>';

	    $html .= '<div class="testimonial__text">';
	    $html .= apply_filters('the_content',$testimonial['text']);

	    $html .= '</div>';
	    $html .= '<span class="show-full-testimonial">Прочитать весь отзыв...</span>';
	    $html .= '</div>';

        $html .= '</div>';
        return $html;
    }
function the_testimonials_block()
    {
        ?>

        <div class="footer-testimonials">
            <div class="footer-testimonials__inner">
                <div class="container">
                    <div class="footer-testimonials__title">Отзывы о нас</div>
                    <div class="footer-testimonials__content">
	                    <?php
                        if(get_current_blog_id() != MAIN_BLOG_ID){
                            switch_to_blog( MAIN_BLOG_ID );
                            echo show_testimonials();
                            restore_current_blog();
                        } else{
	                        echo show_testimonials();
                        }
                        ?>
                    </div>
                    <div class="footer-testimonials__form">
                        <?
                        $noreplytext='<p class="h3">Оставить отзыв</p>';
                        $replytext="Коментировать отзыв";
                        $linktoparent=false;
                        $commenter = wp_get_current_commenter();
                        $html_req = get_option( 'require_name_email' );
                        $aria_req = ( $html_req ? " aria-required='true'" : '' );
                        $html5 = true;
                        $args = [
	                        'fields'    => [
		                        'author' => '<div class="comment-form__line"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' placeholder="Ваше имя (обязательно)" /></div>',
		                        'email'  => '<div class="comment-form__line"><input id="email-testimonials" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' placeholder="Email (обязательно)"  /></div>',
		                        'url'    => '<div class="comment-form__line"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="Ссылка на профиль в соцсети (обязательно)" required /></div>',
	                        ],
	                        'title_reply' => '',
                            'label_submit' =>'Отправить отзыв',
                            'comment_field' => '<div class="comment-form__line"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Ваш отзыв (обязательно)" required></textarea></div>',
                            'comment_notes_after' => ''
                        ];
                        comment_form_title( $noreplytext, $replytext, $linktoparent );
                        comment_form($args);
                        ?>
                    </div>
                </div>
            </div>
        </div>


	    <?
    }
function is_page_without_testimonials()
    {
        if(is_page(47)){
            return true;
        }
        else{
            return false;
        }
    }

add_filter( 'wpcf7_recaptcha_threshold',function( $threshold ) {
	$threshold = 0.3; // decrease threshold to 0.3
	return $threshold;
	},	10, 1);


function get_messenger_prepared_tel($contact,$messenger_type = 'no_filter'){

	if($contact[0] == 8){
		$contact[0] = 7;
		$contact = '+'.$contact;
	}
	else if($contact[0] != '+'){
		$contact = '+'.$contact;
	}
	$prepaired_contact = preg_replace('/[ \-()]/','',$contact);

	if($messenger_type != 'no_filter'){
		switch($messenger_type){
			case 'viber':
				if(check_mobile_device() && $prepaired_contact[0] == '+'){
					$prepaired_contact = str_replace('+','',$prepaired_contact);
				}
				break;
			default:
				break;
		}

	}

	return $prepaired_contact;
}

function check_mobile_device() {
	$mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	foreach ($mobile_agent_array as $value) {
		if (strpos($agent, $value) !== false) return true;
	};
	return false;
}

function theLogo() {
	$logo_src = wp_get_attachment_image_url(get_theme_mod( 'custom_logo'),'full');
	if(!empty($logo_src)){
	    $alt = 'Русская Школа Искусств - на главную';
	    $html = '<a href="'.home_url().'" title="Русская Школа Искусств - на главную">';
	    $html .= '<img src="'.$logo_src.'" class="img-responsive header-logo" alt="'.$alt.'" title="'.$alt.'">';
	    $html .= '</a>';

    } else{
		$html = get_custom_logo(MAIN_BLOG_ID);
    }

	$html = '<div class="new-header-logo-wrapper">'.$html.'</div>';
	$html = switch_link($html);
	echo $html;
}
function get_contacts_page_id() {
	$switched_blog = false;
	$page          = get_page_by_title( 'Контакты' );
	$pageID        = $page->ID;

	if ( empty( $pageID ) ) {
		if ( is_multisite() && get_current_blog_id() !== MAIN_BLOG_ID ) {
			switch_to_blog( MAIN_BLOG_ID );
			$switched_blog = true;
		}
		$page   = get_page_by_title( 'Контакты' );
		$pageID = $page->ID;

	}
	if ( $switched_blog ) {
		restore_current_blog();
	}

	return $pageID;
}
function get_contacts($selector) {
	$page_id = get_contacts_page_id();
	$switched_blog = false;
	$return = get_field($selector,$page_id);
	if (empty($return) && is_multisite() && get_current_blog_id() !== MAIN_BLOG_ID ) {
		switch_to_blog( MAIN_BLOG_ID );
		$page_id = get_contacts_page_id();
		$switched_blog = true;
	}
	$return = get_field($selector,$page_id);
	if ( $switched_blog ) {
		restore_current_blog();
	}
	return $return;
}
add_filter( 'template_include', 'my_template' );
function my_template( $template ) {
    if(is_home()||is_front_page()){
	   return get_stylesheet_directory() . '/new_front-page.php';
    }
    else{
        return $template;
    }
}
function get_filials($type = 'public') {
    $return_filials = [];
	$filials = get_sites();
	foreach ( $filials as $filial ) {
        if($filial->$type == 1){
	        $return_filials[] = [
	                'raw' =>$filial,
	                'id' => $filial->blog_id,
	                'details' => get_blog_details($filial->blog_id),
            ];
        }
	}

    return $return_filials;
}
function filial_select_block() {
    $filials = get_filials();
//    echo '<pre>'.print_r($filials,true).'</pre>';
    $html = '<div class="filial-select-block">';
	$html .= '<ul class="filial-select-list">';

	foreach ( $filials as $filial ) {
		$class = [];
	    $class[] = (get_current_blog_id() == $filial['id']) ? 'active' : '';
		$class_filtered = array_filter($class);
		$class_filtered = implode(' ',$class_filtered);

		$html .= '<li class="filial-select-list__item '.$class_filtered.'">';

		$html .= '<a class="filial-select-list__link" href="'.$filial['details']->home.SELF_LINK.'">';
		$html .= $filial['details']->blogname;
		$html .= '</a>';
		$html .= '</li>';
    }
	$html .= '</ul>';
	$html .= '</div>';

	echo $html;
}
function switch_link($content){
	$main_site = get_sites(['ID'=>MAIN_BLOG_ID]);
	$main_site_domain = $main_site[0]->domain;
	$current_site = get_blog_details();
	return str_replace($main_site_domain,$current_site->domain,$content);
}
function main_video_block() {
    global $post;
	$switched_blog = false;
	$video_url = get_field('блок_видео',$post->ID);
	if(!$video_url){
		switch_to_blog( MAIN_BLOG_ID );
		$post = get_post(get_option( 'page_on_front' ));
		$video_url = get_field('блок_видео',$post->ID);
		$switched_blog = true;
    }

	$video_url_arr = explode('/',$video_url);
	$video_id = end($video_url_arr);

	show_youtube_video($video_id);
	if ( $switched_blog ) {
		restore_current_blog();
	}
}

function get_network_field($selector) {

	$field = get_field($selector);
	$switched_blog = false;
	if(!$field){
		switch_to_blog( MAIN_BLOG_ID );
		$post = get_post(get_option( 'page_on_front' ));
		$field = get_field($selector,$post->ID);
		$switched_blog = true;
	}
	if ( $switched_blog ) {
		restore_current_blog();
	}

    return $field;
}
if(!get_option( 'ipgeo_api_service' )){
	update_option('ipgeo_api_service','ip-api');
}

add_action('wp_initialize_site','new_site_page_generator');

function new_site_page_generator(WP_Site $new_site) {
	$is_switched = false;

	if ( get_current_blog_id() != MAIN_BLOG_ID ) {
		switch_to_blog( MAIN_BLOG_ID );

		$is_switched = true;
	}
	$front_page_id = get_option('page_on_front');
	$base_pages_args = [
		'post_type'   => 'page',
		'author'   => [1,55],
		'numberposts' => -1,
	];
	$base_posts      = get_posts( $base_pages_args );
	$menu_items = wp_get_nav_menu_items(MAIN_BLOG_MENU_NAME);
	foreach ( $base_posts as $base_post ) {
		switch_to_blog( MAIN_BLOG_ID );
		$base_post_metas = get_post_meta( $base_post->ID );
		$args = array(
			'description' => ( isset( $menu_data['description'] ) ? $menu_data['description'] : '' ),
			'name'        => ( isset( $menu_data['menu-name'] ) ? $menu_data['menu-name'] : '' ),
			'parent'      => ( isset( $menu_data['parent'] ) ? (int) $menu_data['parent'] : 0 ),
			'slug'        => null,
		);


		switch_to_blog( $new_site->blog_id );

		$new_post_metas  = [];
		foreach ( $base_post_metas as $meta_key => $base_post_meta ) {
//			$new_post_metas[] = [ $meta_key  => $base_post_meta];
			$new_post_metas[$meta_key]  = $base_post_meta[0];
		}
		$base_post_array = [
			'post_type'      => $base_post->post_type,
			'post_title'     => $base_post->post_title,
			'post_content'   => $base_post->post_content,
			'post_status'    => $base_post->post_status,
			'post_name'      => $base_post->post_name,
			'comment_status' => $base_post->comment_status,
//			'meta_input'   => $new_post_metas,
		];
		if($base_post->ID == 15) {
//			echo '<pre>'.print_r($new_post_metas,true).'</pre>';
        }

		$new_post_id = wp_insert_post( wp_slash($base_post_array) );
		if(!is_wp_error($new_post_id)){
			foreach ( $new_post_metas as $meta_key => $meta_value ) {
				update_post_meta($new_post_id,$meta_key,$meta_value);
			}
			if($base_post->ID == $front_page_id){
				update_option('page_on_front',$new_post_id);
				update_option('show_on_front','page');

            }
		}

	}
	switch_to_blog( $new_site->blog_id );

	add_new_site_menu($menu_items);

	add_new_site_widgets();
	$cat_defaults = array( 'cat_name' => 'Новости',  'category_nicename' => 'news' );
	wp_insert_category($cat_defaults);
	restore_current_blog();
}
function add_new_site_menu($menu_items){
	if(!is_nav_menu( MAIN_BLOG_MENU_NAME )){
		$menu_id = wp_create_nav_menu( MAIN_BLOG_MENU_NAME );
	} else{
		$menu_term = wp_get_nav_menu_object(MAIN_BLOG_MENU_NAME);
		$menu_id = $menu_term->term_id;
	}
	if(!is_wp_error($menu_id)){
		foreach ( $menu_items as $menu_item ) {
			if($menu_item->type == 'taxonomy'){
				$title = (!empty($menu_item->post_title)) ? $menu_item->post_title : $menu_item->title;
				$item_object = get_term_by('name',$title,$menu_item->object);
				$item_object_id = $item_object->term_id;
			} else  if($menu_item->type == 'post_type'){
				$title = (!empty($menu_item->post_title)) ? $menu_item->post_title : $menu_item->title;
				$item_object = get_page_by_title($title);
				if($item_object->post_status !== 'publish'){
					continue;
				}
				$item_object_id = $item_object->ID;
			} else{
				$item_object_id = $menu_item->ID;
			}
			$args = [
				'menu-item-object-id' => $item_object_id,
				'menu-item-object' =>$menu_item->object,
				'menu-item-parent-id' => $menu_item->menu_item_parent,
				'menu-item-type' => $menu_item->type,
				'menu-item-status' => 'publish',
				'menu-item-title' => $menu_item->title,
				'menu-item-url' => $menu_item->url,
				'menu-item-position' => $menu_item->menu_order,
				'menu-item-description' => $menu_item->description,
				'menu-item-attr-title' => $menu_item->attr_title,
				'menu-item-target' => $menu_item->target,
				'menu-item-classes' => implode(' ',$menu_item->classes),
				'menu-item-xfn' => $menu_item->xfn,
			];

			$new_menu_item_id = wp_update_nav_menu_item($menu_id,0,$args);
			$new_menu_db_id_compare[$menu_item->ID] = $new_menu_item_id;
		}

		$new_menu_items = wp_get_nav_menu_items(MAIN_BLOG_MENU_NAME);
		foreach ( $new_menu_items as $new_menu_item ) {
			$args=[
				'menu-item-object-id' => $new_menu_item->object_id,
				'menu-item-object' =>$new_menu_item->object,
				'menu-item-parent-id' => $new_menu_db_id_compare[$new_menu_item->menu_item_parent],
				'menu-item-type' => $new_menu_item->type,
				'menu-item-status' => 'publish',
				'menu-item-title' => $new_menu_item->title,
				'menu-item-url' => $new_menu_item->url,
				'menu-item-position' => $new_menu_item->menu_order,
				'menu-item-description' => $new_menu_item->description,
				'menu-item-attr-title' => $new_menu_item->attr_title,
				'menu-item-target' => $new_menu_item->target,
				'menu-item-classes' => implode(' ',$new_menu_item->classes),
				'menu-item-xfn' => $new_menu_item->xfn,
			];
			wp_update_nav_menu_item($menu_id,$new_menu_item->ID,$args);
		}

	}

}
function add_new_site_widgets()
{
	update_option( 'sidebars_widgets', [] );
	$active_widgets = get_option( 'sidebars_widgets' );
	$sidebars = ['videoblock-in-footer', 'contact-form-right-sidebar' ];
	$counter = 1;

	// Add a 'demo' widget to the top sidebar …
	$active_widgets[ $sidebars[0] ][0] = 'text-' . $counter;
	// … and write some text into it:
	$text_widget_content[ $counter ] = array ( 'title' => "Мы в Instagram" );
	// Add a 'demo' widget to the top sidebar …
	$counter++;
	$active_widgets[ $sidebars[1] ][1] = 'text-' . $counter;
	// … and write some text into it:
	$text_widget_content[ $counter ] = array ( 'title' => "Мы на Youtube" );

	update_option( 'widget_text', $text_widget_content );

	// Now save the $active_widgets array.
	update_option( 'sidebars_widgets', $active_widgets );



}


function prepare_multisite_image($data_item,$index,$selector){
    global $post;
	$image = $data_item['img'];
	$update_flag = false;
	if(empty($image)){
		$image = get_default_multisite_image($index,$selector);
		$update_flag = true;
    }
	if($image){

		if($update_flag){
			$new_image_id = upload_image_to_new_site($image,$post->ID);
			if($new_image_id){
				update_option('update_flag',true);
			    return $new_image_id;
            } else{
				return false;
            }
        }
		return (is_int($image)) ? $image : attachment_url_to_postid($image);
    }
}
function get_default_multisite_image($index,$selector) {
    switch_to_blog(MAIN_BLOG_ID);
    $banners_default = get_network_field($selector);
    restore_current_blog();
    return (!empty($banners_default[$index]['img'])) ? $banners_default[$index]['img'] : false;
}
function upload_image_to_new_site($image,$post_id) {
	switch_to_blog(MAIN_BLOG_ID);
	$image_url = (is_int($image)) ? wp_get_attachment_image_url($image,'full') : $image;
	restore_current_blog();

	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	if(function_exists('media_sideload_image')){
		return media_sideload_image( $image_url, $post_id, '', 'id' );
	}
	return false;
}

function get_data_network_items($selector) {
	global $post;
	$banners = get_network_field($selector);
	$data = [];
	update_option('update_flag',false);
	foreach ( $banners as $index => $banner_item ) {
		$banner_item['img'] = prepare_multisite_image($banner_item,$index,$selector);
		if(!empty($banner_item['img'])){
			$data[] = $banner_item;
		}
	}
	$update_flag = get_option('update_flag');

	if(get_current_blog_id() != MAIN_BLOG_ID && $update_flag){
		update_field($selector,$data,$post->ID);
	}
	update_option('update_flag',false);
    return $data;
}
function get_filials_addreses() {
	$filials = get_filials();
	foreach ( $filials as $filial ) {
		switch_to_blog($filial['id']);
		$address = get_contacts('addresses');
		$addresses[$filial['id']] = $address[0];
		restore_current_blog();
	}

	return $addresses;
}

function auto_select_filial_redirect($filial_id){

	if(get_current_blog_id() != $filial_id && !isset($_SESSION['redirrected']) && $_SESSION['redirrected']!=1){

		$blog_details = get_blog_details($filial_id);
		$_SESSION['redirrected'] = 1;
		wp_redirect($blog_details->home,'302');
		exit();
    }



}

//add_action('init','auto_select_filial');

function auto_select_filial() {
	$auto_select_filial_id = MAIN_BLOG_ID;
	if(class_exists('IpGeoClass')) {
		$ipGeoObj = new IpGeoClass();
		$ip = $_SERVER['REMOTE_ADDR'];
		$result = $ipGeoObj->getIpInfo($ip);
		$filial_adresses = get_filials_addreses();

		$min = 9999999999999999;
		foreach ( $filial_adresses as $filial_id => $address ) {

			$lats = [$result['lat'],$address['longitude']];
			$lons = [$result['lon'],$address['latitude']];
			$coordinates_calc_item = coordinate_calc($lats,$lons);
			if($coordinates_calc_item<=$min){
				$min = $coordinates_calc_item;
				$auto_select_filial_id = $filial_id;
			}
			$coordinates_calc[$filial_id] = $coordinates_calc_item;

		}

	}
	return $auto_select_filial_id;
}

function autoselect_filial_html() {
	$blog_details = get_blog_details(get_current_blog_id());
	$html = '<div class="autoselect-filial-modal-body">';

	$html .= '<div class="autoselect-filial-data">';
	$html .= '<span class="selected-filial" >Ваш филиал: '.$blog_details->blogname.'</span>';
	$html .= '</div>';

	$html .= '<div class="autoselect-filial-change">';
	$html .= '<button class="site-btn site-btn--filial-change" data-dismiss="modal">Да</button>';
	$html .= '<button class="site-btn site-btn--filial-change js--filial-change">выбрать другой?</button>';
	$html .= '</div>';

	$html .= '</div>';

	$html .= '</div>';
	echo $html;
}

function get_current_single_contact($type){
    if($type == 'address'){
        $address = get_contacts('addresses');
	    return $address[0]['address_shown'];
    } else{
	    $contacts = get_contacts('contacts');
	    foreach ( $contacts as $contact ) {
		    if($contact['contact_type'] == $type){
			    return $contact['value'];
		    }
	    }

    }
}

function the_header_callback_block() {
    $email = get_current_single_contact('email');
        ?>
    <div class="header__callbackBtn">
        <? /* <button data-toggle="modal" data-target="#modal-1">Заказать звонок</button> */ ?>
    </div>
    <p class='header-workhours'>Ежедневно с 13:00 до 21:00</p>
    <div class="header__email">
		<? email_convert_to_link($email) ?>
    </div>
    <div class="header__social">
        <div class="social-item">
            <a href="https://www.instagram.com/rusartschool/" rel="nofollow noopenner"><img src="/wp-content/themes/cesselWebgateTheme_014_alfa/img/instagram_icon.png" alt="<? bloginfo('name') ?> - Instagram"></a>
        </div>
        <div class="social-item">
            <a href="https://vk.com/rusartschool" rel="nofollow noopenner"><img src="/wp-content/themes/cesselWebgateTheme_014_alfa/img/vk.png" alt="<? bloginfo('name') ?> - Вконтакте"></a>
        </div>
        <div class="social-item">
            <a href="https://www.youtube.com/channel/UCk5hD7tUdO_RIWzx6W6-iTA" rel="nofollow noopenner"><img src="/wp-content/themes/cesselWebgateTheme_014_alfa/img/youtube.png" alt="<? bloginfo('name') ?> - Youtube"></a>
        </div>
    </div>
    <?php
}
function the_header_contacts_block() {
	$phone = get_current_single_contact('tel');
	$address = get_current_single_contact('address');
        ?>
    <div class="selected-filial">
        <div class="selected-filial__title js--filial-name">
            <span><?php bloginfo('name'); ?><span class="filial-name ">(Изменить?)</span></span>
        </div>
        <div class="selected-filial__value">
            <span class='header-adress'>
                <a href="<?=get_permalink(get_contacts_page_id()); ?>"><?=$address;?></a>
            </span>
            <span class='header-phone'>
			    <? phone_convert_to_link($phone); ?>
		    </span>
        </div>
    </div>

	<?php
}