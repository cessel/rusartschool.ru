<?php
add_action('init','rusartschool_redirects');

function rusartschool_redirects() {
	if(!is_admin()){
		if($_SERVER['HTTP_HOST'] == 'rusartschool.ru' && !is_user_logged_in()){
			wp_redirect('https://vodniy.rusartschool.ru/',301);
			exit();
		}
//		echo '<pre>'.print_r($_SERVER,true).'</pre>';
	}
}