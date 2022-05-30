<?php
/**
 * @package WordPress
 * @subpackage cesselWebgateTheme
 * @since cesselWebgateTheme 0.1
 */

get_header('new'); ?>



<?php if( have_posts() ){ while( have_posts() ){ the_post(); ?>

	<?
			$cat=get_the_category();
			//print_r($cat);
			$i=0;
			$cat_str = '';
			foreach ($cat as $c)
				{
					if ($i!=0)
						{
							$cat_str .= ', ';
						}
					$i++;
					$cat_str .= $c->name;
				}
			if($i>1)
				{
					$rubr = 'Рубрики: ';
				}
			if($i==1)
				{
					$rubr = 'Рубрика: ';
				}
	$bgi = get_the_post_thumbnail_url($post);
	$bg_image = $bgi ? $bgi : "/wp-content/uploads/sites/4/2016/12/073.jpg";
	?>
    <div class="latest-new-block">
        <div class="bgi" style="background-image:url('<? echo $bg_image; ?>')"></div>
        <div class="container">
            <div class='latest-news-wrapper'>
				<?  echo news_carousel(4); ?>
            </div>
        </div>
    </div>

    <div class='container'>
    <div class='row'>
    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 page-wrapper'>



		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 page-content-xs">
				<p class='single-category-title'><? the_title();?></p>
				<p class='single-category-cat'><strong><? echo $rubr;?></strong><? echo $cat_str;?></p>
				<?php the_content(); ?>
			</div>
		</div>
		<div class="row visible-xs ">
			<div class="col-xs-12">
				<?php //the_content(); ?>
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