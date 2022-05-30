<?php
/*
  Template Name: Фотоконкурс
 */

get_header('new'); ?>

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
		<div class='col-lg-9 col-md-9 col-sm-8 col-xs-12 page-wrapper'>
		





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

			<div class="row">
				<div class="col-xs-12">
					<?php the_content(); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 fotokonkurs-wrapper">
					<? if(is_user_logged_in())
						{
							$vote_access_text = "Вы можете проголосовать за понравивщуюся работу";
							if(get_user_num_votes(get_current_user_id())>=3)
								{
									$vote_access_text = "<a href='/profile/' class='btn btn-default btn-add-work'>Добавить работу на конкурс</a>";
								}
							else
								{
									echo "<p class='vote-access-condition'>Для размещения работы на фотоконкурсе необходимо <a href='/register/'>зарегистрироваться</a> и <a href='/perspektiva/'>проголосовать</a> за 3 различные работы</p>";
								}
						}
					else
						{
							$vote_access_text = "Для того чтобы проголосовать необходимо <a href='/register/'>войти</a> или <a href='/register/'>зарегистрироваться</a>";
						}
					echo "<p class='vote-access-text'>".$vote_access_text."</p>";?>
					
					<? get_works(); ?>
					
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 add-next-work-wrapper">
					
				</div>
			</div>
		</div>
	</div>
</div>
<script>
jQuery(document).ready(function()
	{
		jQuery('.work').click(function()
			{
				var isVote = confirm("Вы точно хотите проголосовать?");
				if(isVote)
					{
						var post_id = jQuery(this).data('post_id');
						$.post('/wp-content/themes/cesselWebgateTheme_014_alfa/fotokonkurs/ajax.php'
						,{'post_id':post_id,'action':'vote'}
						,function(result)
							{
								alert(result);
								location.reload();
							});
					}
			});
	});

</script>

<?php get_footer(); ?>