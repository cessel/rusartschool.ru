<?php
/**
 * The Header template for our theme
 *
 *
 *
 * @package WordPress
 * @subpackage cesselWebgateTheme
 * @since cesselWebgateTheme 0.1.4 alfa
 */
?><!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="ExpiresDefault" content="access plus 10 years" />
    <meta name="yandex-verification" content="b0ed05a6a1ed079b" />
    <title><?php wp_title(); ?></title>
	<? wp_site_icon(); ?>
	<link rel="shortcut icon" href="<? echo CES_IMG; ?>/img_for_latest_news_150x150.png" type="image/x-icon">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <? wp_head(); ?>
</head>
<? $body_class = (wp_is_mobile()) ? 'mobile' : 'desktop';?>
<body <?php body_class($body_class); ?>>
<header class="header">
    <div class="header-top">
        <div class="header-logo">
		    <?php theLogo(); ?>
        </div>
        <div class='mobile-menu-button-wrapper'>
            <button type='button' class='mobile_menu_button js--toggle-menu' title='Русская Школа Искусств - открыть меню'>
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <div class="header-callback">
		    <?php the_header_callback_block(); ?>
        </div>

        <div class="header-contacts">
		    <?php the_header_contacts_block(); ?>
        </div>
    </div>
    <div class="header-bottom">
        <section class='new-header-menu-wrapper'>
            <?
            if(!wp_get_nav_menu_items(MAIN_BLOG_MENU_NAME)) {
	            switch_to_blog( MAIN_BLOG_ID );
            }
            $menu = wp_nav_menu(array('menu'=>MAIN_BLOG_MENU_NAME,'menu_class'=>'nav nav-pills nav-justified top-menu','echo'=>false));
            restore_current_blog();
            echo switch_link($menu);
            ?>
        </section>
    </div>

</header>
<div class="nav-mobile visible-xs visible-sm js--nav-mobile">
    <div class="nav-mobile__inner">
        <div class="selected-filial selected-filial--mobile">
            <div class="selected-filial__title js--filial-name">
                <p class="selected-filial__title--label">Ваш филиал:</p>
                <span><?php bloginfo('name'); ?><span class="filial-name ">(Изменить?)</span></span>
            </div>
        </div>
		<? if(!wp_get_nav_menu_items('top-menu-082019')){
			switch_to_blog( MAIN_BLOG_ID );
		}
		$menu = wp_nav_menu(array('menu'=>'top-menu-082019','menu_class'=>'nav-mobile-menu','echo'=>false));
		restore_current_blog();
		echo switch_link($menu);
		?>
        <div class="nav-mobile__close js--toggle-menu">x</div>
    </div>
</div>

<?
$current_blog_id = get_current_blog_id();
if ($current_blog_id == 2)
{
	$pages_with_slider = array(2416=>6,141=>5,143=>4);
}
else if ($current_blog_id == 3)
{
	$pages_with_slider = array(2416=>6,141=>5,143=>4);
}
else if ($current_blog_id == 4)
{
	$pages_with_slider = array(2416=>6,141=>5,143=>4);
}
else
{
	?>
    <script>


        var date = new Date();
        function track_user() {
            setInterval(function() {
                date.setTime(date.getTime()+(2*1000000));
                document.cookie = "filial-select-modal=shown; expires="+ date.toGMTString() + "; path=/";
            }, 1000);
        }

        $('#filial-select').on('show.bs.modal', function (e) {
            //$.cookie('filial-select-modal', 'shown', {expires: 1});
            track_user();
        });

        var shown = $.cookie('filial-select-modal');

        if(shown == 'shown')
        {

        }
        else
        {
            // $('#filial-select').modal('show');
        }

    </script>

	<?
	$pages_with_slider = array(6=>5,141=>6,143=>7);
}

foreach ($pages_with_slider as $page_id => $slider_id)
{
	if (is_page($page_id)) { ?>
        <div class='slider-background'>
            <div class='container main-slider-wrapper'>
                <div class='row'>
                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
						<?php masterslider($slider_id); ?>
                    </div>
                </div>
            </div>
        </div>
	<? }
} ?>
