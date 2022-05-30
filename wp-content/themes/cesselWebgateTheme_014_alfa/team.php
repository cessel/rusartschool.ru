<?

/*
Template Name: Наша команда
*/
 
get_header('new');
?>



<div class='container'>
	<div class='row'>
        <? /*
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
 */ ?>
		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 page-wrapper'>


<?php wp_reset_query(); ?>

<?php $content = get_the_content(); ?>
<div class="row">
	<div class="col-xs-12">
		<?php echo apply_filters('the_content',$content); ?>
	</div>
</div>





<? 
$posts = get_posts( array(
	'numberposts'     => -1, // тоже самое что posts_per_page
	'offset'          => 0,
	'category'        => '',
	'orderby'         => 'menu_order',
	'order'           => 'ASC',
	'include'         => '',
	'exclude'         => '',
	'meta_key'        => '',
	'meta_value'      => '',
	'post_type'       => 'team',
	'post_mime_type'  => '', // image, video, video/mp4
	'post_parent'     => '',
	'post_status'     => 'publish'
) );
foreach($posts as $post){ 
setup_postdata($post);
    // формат вывода

//    $acf_team_data['team-name'] = get_field('team-name',$post->ID);
//    $acf_team_data['team-role'] = get_field('team-role',$post->ID);
//    $acf_team_data['team-bio'] = get_field('team-bio',$post->ID);
//    $acf_team_data['team-foto'] = '';
//
//	foreach ( $acf_team_data as $key => $acf_team_datum ) {
//		if(empty($acf_team_datum)){
//			$value = get_post_meta($post->ID,'wpcf-'.$key,true);
//		    if($key == 'team-foto'){
//		        $value = attachment_url_to_postid($value);
//            }
//            update_field($key,$value,$post->ID);
//        }
//    }
?>

			<?php $name     =   get_post_meta($post->ID,'wpcf-team-name',true); ?>
			<?php $role     =   get_post_meta($post->ID,'wpcf-team-role',true); ?>
			<?php $bio      =   get_post_meta($post->ID,'wpcf-team-bio',true); ?>
			<?php $foto     =   get_post_meta($post->ID,'wpcf-team-foto',true); ?>



<? if ($name!='') { ?>
<div class="team_member">
    <div class="row">
        <div class="col-xs-12">
            <p class="h4 team_name"><? echo $name; ?> <? echo $role; ?></p>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><img class="img-responsive center-block" src="<? echo $foto; ?>" alt="Фотография <? echo $name; ?>" width="214" height="214" /></div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<? if (($post->ID != 2513)&&($post->ID != 673))
			{
				?>
                <p class=""><strong>Краткая творческая биография:</strong></p>

				<?
			}
			?>
            <p class="team-bio"><? echo $bio; ?></p>
        </div>
    </div>

</div>
<? }
}?>
<?php wp_reset_query(); ?>


</div>
</div>

</div>


<?php get_footer(); ?>