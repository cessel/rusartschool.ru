<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */ 
?>
				<? $meta_type='post'; ?>
				<? $contacts_locale['ru']['tel']='Телефон: '; ?> 
				<? $contacts_locale['ru']['fax']='Факс: '; ?> 
				<? $contacts_locale['ru']['email']='Почта: '; ?>
				<? $contacts_locale['ru']['copyright']='© Компания «Русская школа искусств»<br>Любое несанкционированное использование материалов сайта запрещено.';?>
				<? $contacts_locale['ru']['address']='Адрес: ';?>
				<? $contacts_locale['ru']['copydevelopment']='Разработка сайта - ';?>
				<? $contacts_locale['ru']['copydesign']='Дизайн сайта - ';?>
                <? // $contacts['tel'] = get_sitedata('tel'); ?>
                <? // $contacts['tel1'] = get_sitedata('tel1'); ?>
                <? // $contacts['email'] = get_sitedata('email'); ?>
                <? // $contacts['adress'] = get_sitedata('adress'); ?>
                <? // $contacts['adress2'] = get_sitedata('adress2'); ?>
                <? // $contacts['adress_shown'] = get_sitedata('adress_shown'); ?>
                <? // $contacts['adress_1_shown'] = get_sitedata('adress_1_shown'); ?>
                <?php
                    $contacts['contacts'] = get_contacts('contacts');
                    $contacts['addresses'] = get_contacts('addresses');
                    $contacts['adress_1_shown'] = $contacts['addresses'][0]['address_shown'];
                    $contacts['tel'] = get_current_single_contact('tel');
                    $contacts['email'] = get_current_single_contact('email');
                ?>


				<? $lang="ru";

				?>

<? if(!is_page_without_testimonials()) {the_testimonials_block();} ?>

<section class="frontpageform">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?
                use Classes\Forms\RusArtMainForm;
                $form = new RusArtMainForm;
				echo $form->getForm();

				//                if(wpcf7_contact_form(3132)){
////					echo do_shortcode('[contact-form-7 id="3132" title="Онлайн заявка для новой главной"]');
//				}else if(get_current_blog_id() != MAIN_BLOG_ID){
////					echo do_shortcode('[contact-form-7 id="589" title="Онлайн заявка для новой главной"]');
//				}
				?>
            </div>
        </div>
        <div class="row footer-social-block">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <h4>Мы в контакте</h4>
                <!-- VK Widget -->
                <div id="vk_groups2" data-nonce="<?=wp_create_nonce('vk-users'); ?>">
	                <?=get_vk_testi(); ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 instagram-widget">
				<? dynamic_sidebar('contact-form-right-sidebar'); ?>
                <div class="vk-users__header">
                    <div class="vk-users__logo">
                        <img class=" lazyloaded" src="https://sun9-12.userapi.com/c840131/v840131441/40e50/UHtUPe_iwM0.jpg?ava=1" data-src="https://sun9-12.userapi.com/c840131/v840131441/40e50/UHtUPe_iwM0.jpg?ava=1" alt="Русская Школа Искусств - Вконтакте" title="Русская Школа Искусств - Вконтакте">
                    </div>
                    <div class="vk-users__groupname">
                        <a href="//instagram.com/rusartschool/">Русская Школа Искусств</a>
                    </div>
                </div>
                <div class="elfsight-app-07575c1c-b212-4c71-a94a-f26d9923b185"></div>
                <div><p class="clear"><a href="//instagram.com/rusartschool/" rel="me" target="_self" class="">Подписаться </a></p></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 instagram-widget">
	            <? dynamic_sidebar('videoblock-in-footer'); ?>
                <div class="elfsight-app-5bba6a72-5736-4ab3-a2a6-5c1e6aefb5cb"></div>

            </div>
        </div>
    </div>
</section>

<footer>
    <div class='container'>
        <div class="row footer">
            <div class="col-xs-12">
                <? /*
                <div class="row footer-menu-wrapper">
                    <div class="col-sm-8 hidden-xs">
						<? wp_nav_menu(array('menu'=>'footer_menu','menu_class'=>'nav nav-pills footer-menu')); ?>
                    </div>
                    <div class="col-xs-12 visible-xs">
                        <p class='footer-menu-xs-title'>
                            <a href='#footer-menu-xs'  data-toggle="collapse">
                                Меню
                                <span class="caret"></span>
                            </a>
                        </p>
                        <div id='footer-menu-xs' class='collapse'>
							<? wp_nav_menu(array('menu'=>'footer_menu','menu_class'=>'nav nav-pads footer-menu-xs')); ?>
                            <p class='online-order-xs'>
                                <a href='/onlajn-zayavka/' class='btn btn-order'>Онлайн заявка</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-12 visible-xs">
                        <!-- VK Widget -->
                        <div id="vk_groups_footer"></div>
                        <script type="text/javascript">
                            VK.Widgets.Group("vk_groups_footer", {mode: 0, width: "auto", height: "400", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 30004163);
                        </script>
                    </div>
                    <div class="col-sm-4 col-xs-12 footer-search-block">
						<? get_search_form(); ?>
                    </div>
                </div>
                 */ ?>
                <div class="row">
                    <div class="col-sm-4 col-xs-12 footer-copyrights-block">
                        <strong>
							<? echo $contacts_locale[$lang]['copyright']; ?>
                        </strong>
                    </div>
                    <div class="col-sm-4 col-xs-12 footer-adress-block">
                        <?/*
                         <strong><? echo $contacts_locale[$lang]['address']; ?><a href='//rechnoy.rusartschool.ru/kontakty/' title='Русская Школа Искусств - Контакты'><? echo $contacts['adress_shown']; ?></a></strong><br>
*/ ?>
                        <strong><? echo $contacts_locale[$lang]['address']; ?><a href='//vodniy.rusartschool.ru/kontakty/' title='Русская Школа Искусств - Контакты'><? echo $contacts['adress_1_shown']; ?></a></strong><br>
                    </div>
                    <div class="col-sm-4 col-xs-12 footer-contacts-block">
                        <strong><? echo $contacts_locale[$lang]['tel']; ?><a href='tel://<? echo $contacts['tel']; ?>'><? echo $contacts['tel']; ?></a></strong><br>
                        <strong><? echo $contacts_locale[$lang]['email']; ?><a href='mailto:<? echo $contacts['email']; ?>'><? echo $contacts['email']; ?></a></strong><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 line "></div>
                </div>
                <div class="row">
                    <div id="col-xs-12 padding5">
                        <span class="f-left padding5"><? echo $contacts_locale[$lang]['copydesign']; ?><a href="http://futurodesign.ru/">Futurodesign.ru</a>.</span>
                        <span class="f-right padding5"><? echo $contacts_locale[$lang]['copydevelopment']; ?><a href="//cessel.ru/">cessel's WEBgate Studio</a>.</span>
                    </div>
                </div>
            </div>
        </div>
</footer>

<!--END FOOTER-->

</div>
<!--END CONTAINER-->
<?php wp_footer(); ?>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter26209260 = new Ya.Metrika({id:26209260,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/26209260" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
 
<? /*
<script type="text/javascript"
                src="//cdn.callbackhunter.com/cbh.js?hunter_code=fe1180f440214a41875b7b38fe97c302" charset="UTF-8"></script>
*/
?>
<? get_template_part('modals'); ?>
</body>
</html>