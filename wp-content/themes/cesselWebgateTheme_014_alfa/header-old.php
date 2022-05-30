<?
//header("Cache-Control: max-age=604800, must-revalidate");

?>
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
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="ExpiresDefault " content="access plus 10 years" />
<title><?php wp_title(); ?></title>
<link rel="shortcut icon" href="<? echo CES_IMG; ?>/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<script type="text/javascript" src="//yastatic.net/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
    <script src="//vk.com/js/api/openapi.js?122" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/jquery.cookie/1.4.1/jquery.cookie.min.js"></script>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<? wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<? get_template_part('modals'); ?>

<? /* БЛОК НАСТРОЕК */ ?>

				<? $contacts['tel'] = get_sitedata('tel'); ?>
				<? $contacts['tel1'] = get_sitedata('tel1'); ?>
				<? $contacts['email'] = get_sitedata('email'); ?>
				<? $contacts['adress'] = get_sitedata('adress'); ?>
				<? $contacts['adress1'] = get_sitedata('adress1'); ?>
				<? $contacts['adress2'] = get_sitedata('adress2'); ?>
				<? $contacts['adress_shown'] = get_sitedata('adress_shown'); ?>
				
				<? $logo_src = wp_get_attachment_image_url(get_theme_mod( 'custom_logo'),'full'); ?>

    <script type="text/javascript">
        ymaps.ready(init);
        var myMap, 
            myPlacemark;

        function init()
			{
				var adress = '<? echo $contacts['adress']; ?>';
				var adress1 = '<? echo $contacts['adress1']; ?>';
				var adress2 = '<? echo $contacts['adress2']; ?>';
				

	            		ymaps.geocode(adress).then(function (res)
					{	
						var position = res.geoObjects.get(0).geometry.getCoordinates();
    						myMap = new ymaps.Map('map',{center: position,zoom : 13 });
						var myPlacemark = new ymaps.Placemark(position,{hintContent: 'Русская Школа Искусств',balloonContent: 'Русская Школа Искусств - Москва, Ул. Ляпидевского, д. 10а'});
						myMap.geoObjects.add(myPlacemark);  
					 	ymaps.geocode(adress1).then(function (res)
							{var position1 = res.geoObjects.get(0).geometry.getCoordinates();
var myPlacemark1 = new ymaps.Placemark(position1,{hintContent: 'Русская Школа Искусств',balloonContent: 'Русская Школа Искусств - Москва, ' + adress1});
						myMap.geoObjects.add(myPlacemark1); 
});

ymaps.geocode(adress2).then(function (res)
							{var position2 = res.geoObjects.get(0).geometry.getCoordinates();
var myPlacemark2 = new ymaps.Placemark(position2,{hintContent: 'Русская Школа Искусств',balloonContent: 'Русская Школа Искусств - Москва, ' + adress2});
						myMap.geoObjects.add(myPlacemark2); 
});
						

					});

 }
		
    </script>
				
				
				
				
				
				
<div class='container'>
	<div class='row hidden-xs'>
		<div class='col-lg-6 col-md-6 col-sm-6'>
				<div class="row">
					<div class="col-xs-12">
						<a href='/o-nas/' title='Русская Школа Искусств - на главную'>
							<img src='<? echo $logo_src; ?>' class='img-responsive header-logo' alt='Русская Школа Искусств - на главную' title='Русская Школа Искусств - на главную'>
						</a>
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
		<div class='col-lg-6 col-md-6 col-sm-6'>
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
                <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12">
                    <p class="header-block-title">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <span>Выбор филиала</span>
                    </p>
                    <? header_conacts_block(); ?>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
                    <p class="header-block-title">
                        <i class="fa fa-mobile" aria-hidden="true"></i>
                        <span>Наши телефоны</span>
	                    <? header_conacts_block('phones'); ?>
                    </p>
                </div>
            </div>
		</div>
	</div>
	<div class='row visible-xs mobile-header'>
		<div class='col-xs-10 mobile-logo-wrapper'>
			<a href='/o-nas/' title='Русская Школа Искусств - на главную'>
				<img src='<? echo $logo_src; ?>' class='img-responsive' alt='Русская Школа Искусств - на главную' title='Русская Школа Искусств - на главную'>
			</a>
		</div>
		<div class='col-xs-2 mobile-menu-button-wrapper'>
			<button type='button' class='mobile_menu_button' title='Русская Школа Искусств - на главную' type="button" data-toggle="collapse" data-target="#mobile-menu" >
				<span class='glyphicon glyphicon-menu-hamburger'></span>
			</button>
		</div>
	</div>
	<div class='row mobile-phome-wrapper visible-xs'>
		<div class='col-xs-12 '>
			<p class='mobile-phome-title'>
				<span>
					Звоните нам:
				</span><br>
				<a href='tel://<? echo $contacts['tel']; ?>' title='Русская Школа Искусств - контактный телефон' itemprop="telephone">
					<? echo $contacts['tel']; ?>
				</a>
			</p>
			<p class='mobile-phome-title'>
				<a href='tel://<? echo $contacts['tel1']; ?>' title='Русская Школа Искусств - контактный телефон' itemprop="telephone">
					<? echo $contacts['tel1']; ?>
				</a>
			</p>
		</div>
	</div>
</div>
<?
$menu_name = 'top_menu';
$new_main_ids = array('2619','2673','2624');
if(in_array($post->ID,$new_main_ids))
    {
	    $menu_name = 'top_menu_new';
    }
?>

<div class='container menuBloсk'>
	<div class='row hidden-xs'>
		<div class='col-lg-10 col-md-10 col-sm-9 top-menu-wrapper'>
			<? wp_nav_menu(array('menu'=>$menu_name,'menu_class'=>'nav nav-pills nav-justified top-menu')); ?>
		</div>
		<div class='col-lg-2 col-md-2 col-sm-3 top-menu-order-btn-wrapper'>
			<? //modal_toggle_link('Онлайн заявка','#top-menu-order','btn btn-order'); ?>
			<a href='/onlajn-zayavka/' class='btn btn-order'>Онлайн заявка</a>
		</div>
	</div>
	<div class='row visible-xs'>
		<div class='collapse' id='mobile-menu'>
			<div class='col-xs-12'>
				<? wp_nav_menu(array('menu'=>'top_menu','menu_class'=>'nav nav-pills nav-justified top-menu-xs')); ?>
				<? wp_nav_menu(array('menu'=>'side_menu','menu_class'=>'nav nav-pills nav-justified top-menu-xs')); ?>
			</div>
			<div class='col-xs-12 top-menu-order-btn-wrapper'>
				<? //modal_toggle_link('Онлайн заявка','#top-menu-order','btn btn-order'); ?>
				<a href='/onlajn-zayavka/' class='btn btn-order'>Онлайн заявка</a>
			</div>
			<? /*<div class='col-xs-12 top-menu-order-btn-wrapper'>
				<a  href='#top-addmenu-xs'  data-toggle="collapse" class='btn btn-add-menu-xs'>Дополнительно...</a>
			</div>
			<div id='top-addmenu-xs' class='collapse col-xs-12 top-addmenu-wrapper'>
				<? wp_nav_menu(array('menu'=>'side_menu','menu_class'=>'nav nav-pills nav-justified top-menu-xs')); ?>
			</div>*/?>
		</div>
	</div>
</div>

<? 
if (get_current_blog_id() == 2)
	{
		$pages_with_slider = array(2416=>6,141=>5,143=>4);
	}
else if (get_current_blog_id() == 3)
	{
		$pages_with_slider = array(2416=>6,141=>5,143=>4);
	}
else if (get_current_blog_id() == 4)
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
                    date.setTime(date.getTime()+(2*10000000));
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

                }
            //$('#filial-select').modal('show');
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
