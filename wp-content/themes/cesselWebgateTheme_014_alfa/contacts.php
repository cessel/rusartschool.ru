<?
/*
Template Name: contacts
*/

get_header('new');
$contacts['addresses'] = get_field('addresses');
$address_msk = $contacts['addresses'][0];
$address_istra = (isset($contacts['addresses'][1]))?$contacts['addresses'][1]:'';
$contacts['contacts'] = get_field('contacts');
?>
				<? $meta_type='post'; ?>
				<? $contacts['tel'] = get_metadata($meta_type,15, 'tel', true); ?>
				<? $contacts['tel1'] = get_metadata($meta_type,15, 'tel1', true); ?>
				<? $contacts['email'] = get_metadata($meta_type,15, 'email', true); ?>
				<? $contacts['adress'] = get_metadata($meta_type,15, 'adress', true); ?>
				<? $contacts['adress1'] = get_metadata($meta_type,15, 'adress1', true); ?>
				<? $contacts['adress2'] = get_metadata($meta_type,15, 'adress2', true); ?>
				<? $contacts['proezd'] = get_metadata($meta_type,15, 'proezd', true); ?>
				<? $contacts['adress_shown'] = get_metadata($meta_type,15, 'adress_shown', true); ?>


<div class='container'>
	<div class='row'>
        <? /*
		<div class='col-lg-3 col-md-3 col-sm-4 hidden-xs'>
			<? wp_nav_menu(array('menu'=>'side_menu','menu_class'=>'nav nav-pads side-menu')); ?>
 		</div>
 */ ?>
		<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 page-wrapper'>
            <div class="row">
                <div class="col-xs-12">
                    <p class="h2" style="color:#800000;">Контакты и схема проезда</p>
	                <?



                    foreach ( $contacts['contacts'] as $contact ) {

		                if($contact['contact_type'] == 'email'){
			               $value = email_convert_to_link($contact['value'],'',false);
		                }
		                else if ($contact['contact_type'] == 'tel'){
			                $value = phone_convert_to_link($contact['value'],'',false,false);
		                }
						else if($contact['contact_type'] == 'messenger'){
							$value = get_messenger_prepared_tel($contact['value']);
							$value = '<a href="https://wa.me/'.$value.'">'.$contact['value'].'</a>';
						}
						else{
							$value = $contact['value'];
						}
						?>
		                <p class="contacts-contact">
			                <strong><?=$contact['label']; ?>: </strong>
			                <span class="contacts-contact-value"><?=$value; ?></span>
			                <span class="contacts-contact-desc"><?=$contact['desc']; ?></span>
		                </p>
		                <?
	                }?>

                    <p class="h3" style="color:#800000;">Наши адреса:</p>
	                <? foreach ( $contacts['addresses'] as $address ) {
	                	$path_link = ($address['path_link']) ? '<a href="'.$address['path_link'].'" class="js--scroll-to-link" data-scroll_to="'.$address['path_link'].'">Как пройти до школы</a>' : '';
	                	$map_link = ($address['map_link']) ? '<a href="'.$address['map_link'].'" class="js--scroll-to-link" data-scroll_to="'.$address['map_link'].'">Посмотреть на карте</a>' : '';
	                	$route_link = '<a href="https://yandex.ru/maps/?rtext=~'.$address['longitude'].','.$address['latitude'].'">Построить маршрут</a>';
		                ?>
		                <p class="contacts-addresses">
			                <strong><?=$address['label']; ?>: </strong>
			                <span class="contacts-address-shown"><?=$address['address_shown']; ?></span>
			                <span class="contacts-map-link"><?=$map_link; ?></span>
			                <span class="contacts-path-link"><?=$path_link; ?></span>
			                <span class="contacts-route-link"><?=$route_link; ?></span>

		                </p>
		                <?
	                }?>
                </div>
            </div>
            <div id="address-msk" class="row">
                <div class="col-xs-12">
                    <? //show_map($address_msk['longitude'], $address_msk['latitude'],$address_msk['address_map']); //'55.844950','37.481523'?>
                    <? show_multipoint_map($contacts['addresses']); ?>
                </div>
            </div>
            <?

            $path_title = get_field('заголовок_как_пройти_до_школы');
            $path_data = get_field('фотографии_как_пройти_до_школы');
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="path-to-school">
                        <h3><?=$path_title; ?></h3>
	                    <div class="arrows">
		                    <div class="arrow arrow-prev js--path-carousel-msk-prev"><i class="fa fa-angle-left"></i></div>
		                    <div class="arrow arrow-next js--path-carousel-msk-next"><i class="fa fa-angle-right"></i></div>
	                    </div>

	                    <div id="path-carousel-msk" class="owl-carousel owl-carousel-theme">
		                    <?
	                        $i = 1;

	                        foreach ( $path_data as $path_datum ) {
	                            $path_foto_url = wp_get_attachment_image_url($path_datum['фото'],'large');
	                            ?>
	                            <div class="path-to-school__item">
	                                <div class="path-to-school__itemIner">
	                                    <div class="path-to-school__itemImg">
	                                        <img src="<?=$path_foto_url; ?>" alt="<? bloginfo('name'); ?> - как пройти до школы - <?=$i++; ?>">
	                                    </div>
	                                    <div class="path-to-school__itemTitle">
		                                    <?=$path_datum['подпись_к_фото']; ?>
	                                    </div>
	                                </div>
	                            </div>
	                            <?
	                        }
	                        ?>
                        </div>
                    </div>
                </div>
            </div>
		</div>
    </div>
</div>

<?php


get_footer(); ?>