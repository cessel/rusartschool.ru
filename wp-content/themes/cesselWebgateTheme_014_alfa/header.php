<?php
//header("Cache-Control: max-age=604800, must-revalidate");
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
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/fonts/KFOmCnqEu92Fr1Mu72xKOzY.woff2" as="font" type="font/woff2" crossorigin>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="ExpiresDefault " content="access plus 10 years" />
    <meta name="yandex-verification" content="b0ed05a6a1ed079b" />
    <title><?php wp_title(); ?></title>
	<? wp_site_icon(); ?>
    <meta name=viewport content="width=device-width, initial-scale=1">

    <? /*
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
	<link rel="stylesheet" href="/wp-content/themes/cesselWebgateTheme_014_alfa/css/hover-min.css">
	<link rel="stylesheet" href="/wp-content/themes/cesselWebgateTheme_014_alfa/css/styles.css">
	<link rel="stylesheet" href="/wp-content/themes/cesselWebgateTheme_014_alfa/css/styles (1).css">
	<link rel="stylesheet" href="/wp-content/themes/cesselWebgateTheme_014_alfa/css/cessel_style.css">
	<script type="text/javascript" src="//yastatic.net/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
	<script src="//vk.com/js/api/openapi.js?122" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.2/jquery.scrollTo.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.cookie/1.4.1/jquery.cookie.min.js"></script>

    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"></script>
    <script src="/wp-content/themes/cesselWebgateTheme_014_alfa/js/zzmisc.js"></script>
*/ ?>
    <? wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<? /*
if (!is_super_admin())
    {
        echo "<div class='maintenance'>
        <h1>Ведутся работы по преобразованию сайта.</h1>
        <h2>Скоро все заработает.</h2>
        </div>";
        die();
    }
*/ ?>

<? /* БЛОК НАСТРОЕК */ ?>

<? $contacts['tel'] = get_sitedata('tel'); ?>
<? $contacts['tel1'] = get_sitedata('tel1'); ?>
<? $contacts['email'] = get_sitedata('email'); ?>
<? $contacts['adress'] = get_sitedata('adress'); ?>
<? $contacts['adress1'] = get_sitedata('adress1'); ?>
<? $contacts['adress2'] = get_sitedata('adress2'); ?>
<? $contacts['adress_shown'] = get_sitedata('adress_shown'); ?>

<?
//$contacts['contacts'] = get_field('contacts',15);
$contacts['contacts'] = get_contacts('contacts');
$contacts['addresses'] = get_contacts('addresses');
$address_msk = $contacts['addresses'][0];
$contacts['email'] = get_current_single_contact('email');


?>

<div class='container new-header'>
	<div class='row hidden-xs hidden-sm'>
		<div class='col-lg-4 col-md-4 col-sm-3'>
			<div class="row">
				<div class="col-xs-12">
					<?php theLogo(); ?>
				</div>
			</div>
			<? /*<div class="row">
					<div class="col-xs-12">
						<a href="<?php echo esc_url( home_url( '/o-nas' ) ); ?>">
							<img src="/wp-content/uploads/2016/10/sublogo.png" class="img-responsive header-sublogo" width="" alt="Russian Art School">
						</a>
					</div>
				</div>
 */ ?>

		</div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="header__callbackBtn">
                <button data-toggle="modal" data-target="#modal-1">Заказать звонок</button>
            </div>
	        <p class='header-workhours'>Ежедневно с 13:00 до 21:00</p>
	        <div class="header__email">
		        <? email_convert_to_link($contacts['email']) ?>
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

        </div>
		<div class='col-lg-4 col-md-4 col-sm-5'>
			<? /*
			<div class='row padding35-top header-phone-wrapper'>
				<div class='col-lg-offset-1 col-lg-5 col-md-offset-1 col-md-5 col-sm-offset-1 col-sm-5 header-l-phone-wrapper'>
					<p class='header-phone header-l-phone'><? echo $contacts['tel']; ?></p>
				</div>
				<div class='col-lg-1 col-md-1 col-sm-1 header-phone-icon-wrapper'>
					<img src='<? echo CES_IMG;?>/phone_icon.png' class='top-phone-icon'>
				</div>
				<div class='col-lg-5 col-md-5 col-sm-5 header-r-phone-wrapper'>
					<p class='header-phone header-r-phone'><? echo $contacts['tel']; ?></p>
				</div>
			</div>

			<div class='row header-phone-wrapper'>
				<div class='col-lg-12 col-md-12 col-sm-12'>
					<p class=''>
						<span class='header-phone header-l-phone'  itemprop="telephone"><? echo $contacts['tel']; ?></span>
						<img src='<? echo CES_IMG;?>/phone_icon.png' class='top-phone-icon'>
						<span class='header-phone header-r-phone'  itemprop="telephone"><? echo $contacts['tel1']; ?></span>
					</p>
				</div>
			</div>
			<div class='row'>
				<div class='col-lg-12 col-md-12 col-sm-12 header-address-wrapper'>
					<? echo header_conacts_block(); ?>
				</div>
			</div>
 */ ?>
			<div class="row">
				<? /*
				foreach ( $contacts['contacts'] as $contact ) {
					if ($contact['contact_type'] == 'tel'){
						if($contact['desc'] == 'Истра'){
							$address = $address_istra['address_shown'];
						}
						else{
							$address = $address_msk['address_shown'];
						}
						?>
						<p class="header-block-title">
							<span class='header-adress'>
								<a href="<?=get_permalink(15); ?>"><?=$address;?></a>
							</span>
							<span class='header-phone'>
								<? phone_convert_to_link($contact['value'])?>
							</span>
						</p>
						<?
					}
				} */ ?>
                <div class="selected-filial">
                    <?
                    ?>
                    <div class="selected-filial__title js--filial-name">
                        <span><?php bloginfo('name'); ?><span class="filial-name ">(Изменить?)</span></span>
                    </div>
                    <div class="selected-filial__value">
                        <span class='header-adress'>
                            <a href="<?=get_permalink(get_contacts_page_id()); ?>"><?=$address_msk['address_shown'];?></a>
                        </span>
                        <span class='header-phone'>
					        <? phone_convert_to_link($contacts['contacts'][0]['value']); ?>
					    </span>
                    </div>
                </div>
			</div>
		</div>
	</div>

	<div class='row visible-xs visible-sm mobile-header'>
		<div class='mobile-logo-wrapper'>
			<?php theLogo(); ?>
		</div>
		<div class='mobile-menu-button-wrapper'>
			<button type='button' class='mobile_menu_button js--toggle-menu' title='Русская Школа Искусств - открыть меню'>
				<span></span>
				<span></span>
				<span></span>
			</button>
		</div>
	</div>
	<div class='row mobile-phone-wrapper visible-xs visible-sm'>
		<div class='col-xs-12 '>
			<p class='mobile-phone-title'><span>Звоните нам:</span></p>
            <p class="header-mobile-contact-line">
	            <?php phone_convert_to_link( $contacts['contacts'][0]['value'] ); ?>
            </p>
            <p class='header-workhours'>Ежедневно с 13:00 до 21:00</p>
            <div class="header__callbackBtn">
                <button data-toggle="modal" data-target="#modal-1">Заказать звонок</button>
            </div>
        </div>
	</div>
</div>

<?
$menu_name = 'top_menu';
$new_main_ids = array('2619','2673','2624');
if(in_array($post->ID,$new_main_ids))
{
	//$menu_name = 'top-menu-new-2';
	$menu_name = MAIN_BLOG_MENU_NAME;
}
?>

<section class='new-header-menu-wrapper'>
	<div class='container'>
		<div class='row hidden-xs hidden-sm'>
			<div class='col-lg-10 col-md-10 col-sm-9 top-menu-wrapper'>
				<?
				switch_to_blog( MAIN_BLOG_ID );
                $menu = wp_nav_menu(array('menu'=>MAIN_BLOG_MENU_NAME,'menu_class'=>'nav nav-pills nav-justified top-menu','echo'=>false));
				restore_current_blog();
				echo switch_link($menu);
                ?>
			</div>
		</div>
        <? /*
		<div class='row visible-xs'>
			<div class='collapse' id='mobile-menu'>
				<div class='col-xs-12'>

					<? //wp_nav_menu(array('menu'=>'side_menu','menu_class'=>'nav nav-pills nav-justified top-menu-xs')); ?>
				</div>
				<? /*<div class='col-xs-12 top-menu-order-btn-wrapper'>
				<a  href='#top-addmenu-xs'  data-toggle="collapse" class='btn btn-add-menu-xs'>Дополнительно...</a>
			</div>
			<div id='top-addmenu-xs' class='collapse col-xs-12 top-addmenu-wrapper'>
				<? wp_nav_menu(array('menu'=>'side_menu','menu_class'=>'nav nav-pills nav-justified top-menu-xs')); ?>
			</div>
			</div>
		</div> */ ?>
	</div>
</section>
<div class="nav-mobile visible-xs visible-sm js--nav-mobile">
    <div class="nav-mobile__inner">
        <div class="selected-filial selected-filial--mobile">
            <div class="selected-filial__title js--filial-name">
                <p class="selected-filial__title--label">Ваш филиал:</p>
                <span><?php bloginfo('name'); ?><span class="filial-name ">(Изменить?)</span></span>
            </div>
        </div>
        <?

        if(!wp_get_nav_menu_items(MAIN_BLOG_MENU_NAME)){
            switch_to_blog( MAIN_BLOG_ID );
        }
        $menu = wp_nav_menu(array('menu'=>MAIN_BLOG_MENU_NAME,'menu_class'=>'nav-mobile-menu','echo'=>false));
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
