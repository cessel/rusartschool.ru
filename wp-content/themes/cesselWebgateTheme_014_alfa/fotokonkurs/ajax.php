<?
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
$post_id = sanitize_text_field($_POST['post_id']);
$user_id = get_current_user_id();

if($action = 'vote')
	{
		vote($post_id,$user_id);
	}

?>