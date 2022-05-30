<?php
/**
 * The page template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage cesselWebgateTheme
 * @since cesselWebgateTheme 0.1
 */

get_header('new'); ?>
<? /*
<div class='container'>
	<div class='row'>
		 <div class='col-lg-3 col-md-3 col-sm-4 hidden-xs'>
			<? wp_nav_menu(array('menu'=>'side_menu','menu_class'=>'nav nav-pads side-menu')); ?>
			<div>
				<!-- VK Widget -->
				<div id="vk_groups"></div>
				<script type="text/javascript">
					VK.Widgets.Group("vk_groups", {mode: 0, width: "auto", height: "400", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 30004163);
				</script>
			</div>								
 		</div>
		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 page-wrapper'>

    */?>


<?php if( have_posts() ){ while( have_posts() ){ the_post(); ?>
		
		<? if($post->ID != 141)
			{
		/*?>
			<div class="row latest-new-block">
				<div class="">
					<p class='latest-news-block-title'>Последние новости</p>
				</div>
				<div>
					<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 latest-news-wrapper'>
						<div class=" col-lg-2 col-md-3 col-sm-3 hidden-xs latest-news-img-wrapper">
							<? last_news_gallery(); ?>
						</div>
						<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
							<? get_latest_news(); ?>
						</div>
					</div>
				</div>
			</div>
		<?	*/
$bgi = get_the_post_thumbnail_url($post);
$bg_image = $bgi ? $bgi : "/wp-content/uploads/2017/12/1-1040293-Virtual-TV-Studio_HD-Loop-77.jpg";
$nonews = array(143);
		?>
				<?
				if(!in_array($post->ID,$nonews) && false)
				{
                    ?>
                <div class="latest-new-block">
                    <div class="bgi" style="background-image:url('<? echo $bg_image; ?>')"></div>
                    <div class="container">
                        <div class='latest-news-wrapper'>
                            <? echo news_carousel(4); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
    <div class='container'>
        <div class='row'>
            <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 page-wrapper'>


                <?


			}
		?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php the_content(); ?>
				<?
					if (($post->ID == '2023'||$post->ID == '2024')&&(is_user_logged_in())&&(get_user_num_votes(get_current_user_id())>=3))
						{
							echo do_shortcode('[contact-form-7 id="2068" title="Отправить работу на конкурс"]');
						}
					else if ($post->ID == '2023'||$post->ID == '2024')
						{
							echo "<p class='vote-access-condition'>Для размещения работы на фотоконкурсе необходимо <a href='/register/'>зарегистрироваться</a> и <a href='/perspektiva/'>проголосовать</a> за 3 различные работы</p>";
						}
				
				?>
			</div>
		</div>

<?php } // конец while ?>






<?php
} // конец if
else 
	echo "<h2>Записей нет.</h2>";
?>



		</div>
	</div>
</div>


<?php get_footer(); ?>