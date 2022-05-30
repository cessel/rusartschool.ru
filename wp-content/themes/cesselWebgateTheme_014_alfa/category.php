 <?php
/**
 * @package WordPress
 * @subpackage cesselWebgateTheme
 * @since cesselWebgateTheme 0.1.4
 */

get_header('new'); ?>

<div class='container'>
	<div class='row'>
        <? /*
		<div class='col-lg-3 col-md-3 col-sm-4 col-xs-12 hidden-xs'>
			<? wp_nav_menu(array('menu'=>'side_menu','menu_class'=>'nav nav-pads side-menu')); ?>
			<div>
				<!-- VK Widget -->
				<div id="vk_groups"></div>
				<script type="text/javascript">
					VK.Widgets.Group("vk_groups", {mode: 0, width: "auto", height: "400", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 30004163);
				</script>
			</div>								
 		</div>
 */ ?>
		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 page-wrapper'>
<?
	$cat = get_the_category();
	if ($cat[0]->name!='Новости')
		{
	?>

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

	<?
		}
	else
		{
	?>

			<div class="row new-block">
				<div class="">
					<p class='news-block-title'>НАШИ НОВОСТИ</p>
				</div>
			</div>
	<?		
		}
	?>

	
<?
$i=0;

?>	
	
<?php if( have_posts() ){ while( have_posts() ){ the_post(); ?>
	<?
		$cat = get_the_category();
	?>

	<? 
		if($cat[0]->name=='Новости'||$cat[1]->name=='Новости')
			{
				if($i==0)
				{
					echo '<div class="news-wrapper">';
					$i=1;
				}
					$media = get_attached_media( 'image', $post->ID );
					$media = array_shift( $media );
					$media_v = get_attached_media( 'video', $post->ID );
					$media_v = array_shift( $media_v );

					// ссылка на картинку
					$image_url = $media->guid;

					// ссылка на видео 
					$video_url = $media_v->guid;
					if(!$video_url)
						{
							$video_url = get_sitedata('video',$post->ID);
						}
				    $html = '';
					if(!$video_url)
						{
							$html .= "<a  href='".get_the_permalink()."' title='Наши новости - ".get_the_title()."' class='news-link-overlay'></a>";
							$html .= "<a href='".get_the_permalink()."' title='Наши новости - ".get_the_title()."' class='news-link'>";
						}
					$html .= "<p class='news-date'>";
					$html .= get_the_date('d.m.Y');
					$html .= "</p>";
					if($video_url)
						{
							$returnHtml = "<div class='news-item'>";
							$addclass = ' news-title-has-video';
							//$html .= "<video src='".$video_url."' class='news-video' controls></video>";
							$html .= "<div class='video-wrapper'>";
							$html .= do_shortcode('[video src="'.$video_url.'"][/video]');
							$html .= "</div>";
 						}
					else if (has_post_thumbnail())
						{
							$returnHtml = "<div class='news-item' style='background-image:url(\"".get_the_post_thumbnail_url()."\")'>";

							$addclass = ' news-title-has-img';
							//$html .= "<img src='".get_the_post_thumbnail_url()."' class='news-img'>";
						}
					else if ($image_url)
						{
							$returnHtml = "<div class='news-item' style='background-image:url(\"".$image_url."\")'>";

							//$html .= "<img src='".$image_url."' class='news-img'>";
							$addclass = ' news-title-has-img';
						}
					else
						{
							$returnHtml = "<div class='news-item'>";
							$returnHtml = "<div class='news-item' style='background-image:url(\"".CES_IMG."/img_for_latest_news.png\")'>";

							$addclass = ' news-title-no-img';
							//$html .= "<img src='".CES_IMG."/img_for_latest_news.png' class='news-img'>";
						}
					$html .= "<p class='news-title".$addclass."'>";
					if($video_url)
						{
							$html .= "<a href='".get_the_permalink()."' title='Наши новости - ".get_the_title()."' class='news-link'>";
						}
					$html .= (get_the_title());
					if($video_url)
						{
							$html .= "</a>";
						}
						$html .= "</p>";
					if(!$video_url)
						{
							$html .= "</a>";
						}

				    $returnHtml .= $html;
				    $returnHtml .= "</div>";

					$div[$i][] = $returnHtml;
							
						
					$i++;
				if($i>3) {$i=1;}
			}
		else
			{
	?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<p class='h4 category-title'><a href='<? echo get_the_permalink(); ?>' title='Наши новости - <? the_title();?>'><? the_title();?></a></p>
						<?php the_content(); ?>
					</div>
				</div>

	<?
			}
	
	?>	
	
		
<?php } // конец while ?>

<?
if($cat[0]->name=='Новости'||$cat[1]->name=='Новости')
	{
		for ($j=1;$j<4;$j++)
			{
				echo "<div class='news-wrapper-col hidden-xs news-wrapper-col-".$j."'>";
				foreach ($div[$j] as $news_item)
					{
						echo $news_item;
					}
				echo "</div>";
			}
				echo "<div class='visible-xs news-wrapper-col'>";
				$j=1;
				$n=0;
				while ($div[$j][$n])
					{
						echo $div[$j][$n];
						$j++;
						if($j>3)
							{
								$n++;
								$j=1;
							}
						
					}
				echo "</div>";
			

?>
		</div>
<?
	}


?>




<?php
} // конец if
else 
	echo "<h2>Записей нет.</h2>";
?>

		</div>
	</div>
</div>


<?php get_footer(); ?>