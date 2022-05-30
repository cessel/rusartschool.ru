<?php
/*
  Template Name: Новая главная
 */
//$new_pages = (get_current_blog_id() != MAIN_BLOG_ID) ? 'new' : '';
//get_header($new_pages);

//get_header((is_user_logged_in())?'new':'');
get_header('new');
?>

<section class="banner">
    <? get_main_banner_html(); ?>
</section>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="content__video">
	                <?
                    main_video_block();
	                ?>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?php if( have_posts() ){ while( have_posts() ){ the_post(); ?>

                    <? the_content(); ?>

                <?php } }  else {echo "<h2>Записей нет.</h2>";} ?>
            </div>
        </div>
    </div>
</section>

<section class="services">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3>Наши направления</h3>
                <? get_services_html(); ?>
            </div>
        </div>
    </div>
</section>



<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3>Наши преимущества</h3>

                <? get_features_html(); ?>
            </div>
        </div>
    </div>
</section>


<?


get_footer();
?>