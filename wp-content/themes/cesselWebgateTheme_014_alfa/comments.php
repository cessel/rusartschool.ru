<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentytwelve_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
/*
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<p class="h4">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'twentytwelve' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</p>

<?  
$args = array(
	'author_email' => ''
	,'ID' => ''
	,'karma' => ''
	,'number' => ''
	,'offset' => ''
	,'orderby' => ''
	,'order' => 'DESC'
	,'parent' => ''
	,'post_id' => 0
	,'post_author' => ''
	,'post_name' => ''
	,'post_parent' => ''
	,'post_status' => ''
	,'post_type' => ''
	,'status' => 'approve'
	,'type' => ''
	,'user_id' => ''
	,'search' => ''
	,'count' => false
	,'meta_key' => ''
	,'meta_value' => ''
	,'meta_query' => ''
);

if( $comments = get_comments( $args) ){
	foreach($comments as $comment){
		echo "<div class='row bottom-line comment'>";
		echo "<div class='col-md-12'>";
			echo "<p>Автор: ".$comment->comment_author."</p>";
			echo "<p>Отзыв: ".$comment->comment_content."</p>";
		echo "</div>";
		echo "</div>";
	}
}

?>






		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'twentytwelve' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentytwelve' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentytwelve' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.

		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'twentytwelve' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>
<?php
$noreplytext='Добавить отзыв';
$replytext="Коментировать отзыв";
$linktoparent=false;
$args = array(
	'title_reply' => ''
	,'label_submit' =>'Отправить отзыв'
	,'comment_field' => '<p><label for="comment">Ваш отзыв:</label></p><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>'
	,'comment_notes_after' => ''
);

?>
<?
if ( comments_open() )
	{
?>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
<?
		echo "<p class='h4'>";
		comment_form_title( $noreplytext, $replytext, $linktoparent );
		echo "</p>"; 
?>
	<?php comment_form($args); ?>
<? if(is_user_logged_in())
		{
			$padding="padding30-top";
		} 
	else 
		{
			$padding="padding140-top";
		}
?>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<span class="">
<img src="/wp-content/themes/cesselWebgateTheme_014_alfa/img/feather.png" class="img-responsive <? echo $padding; ?>" width="450" alt="Перышко">
</span>
</div>
</div>
<? } ?>

</div><!-- #comments .comments-area --> */ ?>


<? the_testimonials_block(); ?>
