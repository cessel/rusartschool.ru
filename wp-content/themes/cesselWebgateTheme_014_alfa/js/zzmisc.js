/* global $ */
/* global vars */
$(document).ready(function(event) {
    setTimeout(function (e) {
        $('.js--selected_filial').val(vars.current_blog_adress);
    },300);
    if(!is_filial_switched()){
        Cookies.set('is_filial_switched',1,{  domain: '.rusartschool.ru' });
        Cookies.set('modal_must_be_showed',1,{  domain: '.rusartschool.ru' });
        if(vars.current_blog_id != vars.geo_target_filial_data.blog_id){
            location.href=vars.geo_target_filial_data.home;
        }
    } else{
    }
    if(is_modal_must_be_showed()){
        show_switched_filial_modal();
    }


    $('body').on('click','.js--filial-name',function(e){
        $('#filial-select').modal('show');
    });
    $('body').on('click','.js--filial-change',function(e){
        $('#switched-filial-modal').modal('hide');
        $('#filial-select').modal('show');
    });
        $('.show-full-testimonial').click(function(){
            $(this).closest('.testimonial').find('.testimonial__text').addClass('show');
            $(this).remove();
        });

        try{

            var testi_base_position = [];


            // $('#vertical').lightSlider({
            //     gallery:false,
            //     item:1,
            //     vertical:true,
            //     verticalHeight:'100%',
            //     slideMargin:0,
            //     currentPagerPosition: 'left',
            //     pager:true,
            //     prevHtml:'<i class="fa fa-angle-up"></i>',
            //     nextHtml:'<i class="fa fa-angle-down"></i>',
            // });
            var sections = $('.testimonials__item');
            var nav = $('.testimonials-dots');
            var nav_height = nav.outerHeight();
            sections.each(
                function() {
                    testi_base_position[$(this).data('id')] = $(this).position().top ;
                }
                );
            $('.testimonials').on('scroll', function () {
                var cur_pos = $(this).scrollTop();
                sections.each(function() {

                    var top = testi_base_position[$(this).data('id')];

                    var bottom = top + $(this).outerHeight();


                    if (cur_pos >= top && cur_pos <= bottom) {
                        nav.find('.testimonials-dots__item').removeClass('active');
                        sections.removeClass('active');

                        $(this).addClass('active');
                        nav.find('#'+$(this).data('id')).addClass('active');
                    }
                });
            });

            nav.find('.testimonials-dots__item').on('click', function () {


                var id = $(this).attr('id');
                 var top_change = testi_base_position[id];
                 $('.testimonials').animate({
                    scrollTop: top_change
                 }, 500);

                return false;
            });
        }
        catch(e){
        	console.log(e);
        }


		setInterval(function (){remove_insta_w();},2000);

        $('.js--show-class-group').click(function (e)
			{
                if(!$(this).closest('.class-group').hasClass('show')){
                    $('.class-group__content').slideUp(300);
                    $('.class-group').removeClass('show');
                    $(this).closest('.class-group').find('.class-group__content').slideDown(300);
                    $(this).closest('.class-group').addClass('show');
                }
                else{
                $('.class-group__content').slideUp(300);
                $('.class-group').removeClass('show');
                }
			});

        $('.js--show-class').click(function (e)
        {
            if(!$(this).closest('.class').hasClass('show')){
                $('.class__content').slideUp(300);
                $('.class').removeClass('show');
                $(this).closest('.class').find('.class__content').slideDown(300);
                $(this).closest('.class').addClass('show');
            }
            else{
                $('.class__content').slideUp(300);
                $('.class').removeClass('show');
            }

        });


        $('.js--toggle-menu').click(function (e)
		    {
		        $('.js--nav-mobile').toggleClass('show');
		    });

		$('.menu-item-4067').click(function (e)
		    {
		        $('.js--nav-mobile').toggleClass('show');
		    });

		$(".menu-item-has-children").on('mouseenter',function(e)
		    {
		        $(this).find('.sub-menu').addClass('show');
		    });
		$(".menu-item-has-children").on('mouseleave',function(e)
		    {
		        $(this).find('.sub-menu').removeClass('show');
		    });

		$("a[href='#newForm__Wrapper']").on('click',function(e)
		    {
		    	$.scrollTo('.newForm__Wrapper');
		    });
		$('#wpcf7-f3132-o2 input').on('change',function(e)
		    {
		    	var footer_form = $(this).closest('form');
				var your_fam = footer_form.find('input[name="fam_parent"]').val();
				var your_name = footer_form.find('input[name="imya_parent"]').val();
				var your_email = footer_form.find('input[name="email"]').val();
				var your_subject = '[ZAYAVKA]Заявка на обучение в изостудии';
                footer_form.find('input[name="your-name"]').val(your_fam + ' ' + your_name);
                footer_form.find('input[name="your-email"]').val(your_email);
                footer_form.find('input[name="your-subject"]').val(your_subject);

		    });
		$('#wpcf7-f53-p13-o2 input').on('change',function(e)
		    {
		    	var footer_form = $(this).closest('form');
				var your_fam = footer_form.find('input[name="fam_parent"]').val();
				var your_name = footer_form.find('input[name="imya_parent"]').val();
				var your_email = footer_form.find('input[name="email"]').val();
				var your_subject = '[ZAYAVKA]Заявка на обучение в изостудии';

				console.log(your_fam + " " +your_name );
				console.log(your_email);
				console.log(your_subject);

                footer_form.find('input[name="your-name"]').val(your_fam + ' ' + your_name);
                footer_form.find('input[name="your-email"]').val(your_email);
                footer_form.find('input[name="your-subject"]').val(your_subject);

		    });
		$('#wpcf7-f195-o4 input').on('change',function(e)
		    {
		    	var footer_form = $(this).closest('form');
				var your_fam = footer_form.find('input[name="fam_parent"]').val();
				var your_name = footer_form.find('input[name="imya_parent"]').val();
				var your_email = footer_form.find('input[name="email"]').val();
				var your_subject = '[ZAYAVKA_1_ZANYATIE]Заявка на бесплатное занятие';
                footer_form.find('input[name="your-name"]').val(your_fam + ' ' + your_name);
                footer_form.find('input[name="your-email"]').val(your_email);
                footer_form.find('input[name="your-subject"]').val(your_subject);

		    });








		//setTimeout(function(){$(".preloader").hide();},5000);

        $(".front-page-plusses-link").on('mouseover',function()
		    {
		            $(".collapse").collapse('hide');
		        	$($(this).data('target')).collapse('show');
		    })
		$(".front-page-plusses-link").on('mouseout',function()
		    {
		        $(".collapse").collapse('hide');
		        $($(this).data('target')).collapse('hide');
		    })
		$(".current_page_item").addClass('active');
		$(".menu-item-57").append("<a href='#fselect' data-toggle='modal' data-target='#filial-select' class='subscribe-link'>Подписка на новости</a>");
		$(".menu-item-2440").append("<a href='/podpiska-na-novosti/' class='subscribe-link'>Подписка на новости</a>");
		$(".menu-item-2415").append("<a href='/podpiska-na-novosti/' class='subscribe-link'>Подписка на новости</a>");
		
		/*$(".menu-item-57").append("<a href='/podpiska-na-novosti/' class='subscribe-link'>Подписка на новости</a>");*/
				
	$('.owl-carousel').not("#banner__carousel").not('#news-carousel').owlCarousel({
        autoplay : true,
		stopOnHover : false,
		loop:true,
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1000:{
					items:1
				}
			}
		});

	$("#banner__carousel").owlCarousel({
        autoplayTimeout:5000,
        autoplay : true,
		stopOnHover : false,
		loop:true,
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1000:{
					items:1
				}
			}
		});
	$("#news-carousel").owlCarousel({
        autoplayTimeout:8000,
        autoplay : true,
		stopOnHover : true,
		loop:true,
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		margin:15,
		responsive:{
				0:{
					items:1
				},
				600:{
					items:2
				},
				1000:{
					items:5
				}
			}
		});
	var path_carousel_msk = $("#path-carousel-msk").owlCarousel({
        autoplayTimeout:8000,
        autoplay : true,
		stopOnHover : true,
		loop:true,
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		margin:15,
		responsive:{
				0:{
					items:1
				},
				600:{
					items:1
				},
				1000:{
					items:1
				}
			}
		});

	    $('.js--path-carousel-msk-prev').click(function (e) {
            path_carousel_msk.trigger('prev.owl.carousel');
        });
	    $('.js--path-carousel-msk-next').click(function (e) {
            path_carousel_msk.trigger('next.owl.carousel');
        });

        $(".js--scroll-to-link").on('click',function(e) {
            e.preventDefault();
            var scroll_to = $(this).data('scroll_to');
            $.scrollTo(scroll_to,200,{'offset':{'top':-100}});
        });




		//$(".footer-menu-xs>li.active>a").append('<span class="caret"></span>');
		$(".news-category img").addClass('img-responsive center-block');
	
		
		//$('.front-page-plusses-link').animateCss('pulse infinite');


		//VK.Widgets.Group("vk_groups", {mode: 0, width: "auto", height: "400", color1: '0', color2: '2B587A', color3: '5B7FA6'}, 30004163);
		/*
        var vk_testi_result = $('#vk_testi');
        if(vk_testi_result.length > 0)
        {
            vk_testi_show(vk_testi_result,1);
        }

        vk_testi_result.on('click','.vk-testimonials-pagelink',function(e)
        {
            var next_page = $(this).data('nextpage');
            vk_testi_show(vk_testi_result,next_page);

        });
*/




        if($('body').hasClass('page-template-contacts'))
            {
                //mapInit('#map-yandex');
                mapInitMultiPpoint('#map-yandex-multipoints');
            }
        $('#events-modal .btn').click(function (e)
            {
                $('#events-modal').modal('hide');
            });
        /*setTimeout(function ()
            {
                var event_modal_show_status = $.cookie('event_modal_show_status');
                if(event_modal_show_status === undefined)
                    {
                        $('#events-modal').modal('show');
                        $.cookie('event_modal_show_status', 'showed', { expires: 7 });
                    }
                //console.log(event_modal_show_status);
            },2300);
*/

    var version = '3';
    console.log("Версия misc.js: " + version);

});


function is_filial_switched(){
    var is_filial_switched = Cookies.get('is_filial_switched');
    return (is_filial_switched !== undefined);
}

function is_modal_must_be_showed(){
    var is_modal_must_be_showed = Cookies.get('modal_must_be_showed');
    return (is_modal_must_be_showed !== undefined);
}
function show_switched_filial_modal(){
    Cookies.remove('modal_must_be_showed',{  domain: '.rusartschool.ru' });
    $('#switched-filial-modal').modal('show');
}




$.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});


'use strict';
function r(f){/in/.test(document.readyState)?setTimeout('r('+f+')',9):f()}
r(function(){
    if (!document.getElementsByClassName) {
        // Поддержка IE8
        var getElementsByClassName = function(node, classname) {
            var a = [];
            var re = new RegExp('(^| )'+classname+'( |$)');
            var els = node.getElementsByTagName("*");
            for(var i=0,j=els.length; i<j; i++)
                if(re.test(els[i].className))a.push(els[i]);
            return a;
        }
        var videos = getElementsByClassName(document.body,"youtube");
    } else {
        var videos = document.getElementsByClassName("youtube");
    }
    var nb_videos = videos.length;
    for (var i=0; i<nb_videos; i++) {
        // Находим постер для видео, зная ID нашего видео
        videos[i].style.backgroundImage = 'url(https://i.ytimg.com/vi/' + videos[i].id + '/sddefault.jpg)';

        // Размещаем над постером кнопку Play, чтобы создать эффект плеера
        var play = document.createElement("div");
        play.setAttribute("class","play");
        videos[i].appendChild(play);

        videos[i].onclick = function() {
            // Создаем iFrame и сразу начинаем проигрывать видео, т.е. атрибут autoplay у видео в значении 1
            var iframe = document.createElement("iframe");
            var iframe_url = "https://www.youtube.com/embed/" + this.id + "?autoplay=1&autohide=1&rel=0";
            if (this.getAttribute("data-params")) iframe_url+='&'+this.getAttribute("data-params");
            iframe.setAttribute("src",iframe_url);
            iframe.setAttribute("frameborder",'0');

            // Высота и ширина iFrame будет как у элемента-родителя
            iframe.style.width  = this.style.width;
            iframe.style.height = this.style.height;

            // Заменяем начальное изображение (постер) на iFrame
            this.parentNode.replaceChild(iframe, this);
        }
    }
});


function mapInit(selector)
{
    ymaps.ready(init);
    var myMap,
        myPlacemark;
    var lattitude = $(selector).data('lat');
    var longtitude = $(selector).data('long');

    var adress = $(selector).data('adress');
    var siteName = $(selector).data('sitename');
    if(siteName == undefined || siteName == '' )
    {
        siteName = 'Сайт созданный в Cessel\'s WEBGae Studio';
    }
    function init()
    {
        myMap = new ymaps.Map('map-yandex',{center: [longtitude,lattitude],zoom : 14 });
        var myPlacemark = new ymaps.Placemark([longtitude,lattitude],{hintContent: siteName,balloonContent: siteName + " - " + adress});
        myMap.geoObjects.add(myPlacemark);

    }
}

function mapInitMultiPpoint(selector) {
    ymaps.ready(init);
    var myMap,
        myPlacemark;
    var lattitude = $(selector).data('lat');
    var longtitude = $(selector).data('long');

    var adress = $(selector).data('adress');
    var siteName = $(selector).data('sitename');
    if (siteName == undefined || siteName == '') {
        siteName = 'Сайт созданный в Cessel\'s WEBGae Studio';
    }

    function init() {
        myMap = new ymaps.Map(selector.replace('#',''), {center: [average(longtitude), average(lattitude)], zoom: 9, /*controls: ['routeButtonControl']*/});
        var myPlacemark;
        for(index in longtitude){
            myPlacemark = new ymaps.Placemark([longtitude[index], lattitude[index]], {
                hintContent: siteName[index],
                balloonContent: siteName[index] + " - " + adress[index]
            });
            myMap.geoObjects.add(myPlacemark);

        }
        // var control = myMap.controls.get('routeButtonControl');
        //
        // control.routePanel.state.set({
        //     fromEnabled: false,
        //     toEnabled: false,
        //     from: '',
        //     to: '',
        // });
        // control.routePanel.options.set({
        //     adjustMapMargin: true,
        // });
        // var mskRouteBtn = new ymaps.control.Button({
        //     data: {content: "Маршрут до филиала в Москве", title: "Проложить маршрут до филиала в Москве"},
        //     options: {selectOnClick: false, maxWidth: 300,adjustMapMargin:true}
        // });
        // var istraRouteBtn = new ymaps.control.Button({
        //     data: {content: "Маршрут до филиала в Истре", title: "Проложить маршрут до филиала в Истре"},
        //     options: {selectOnClick: false, maxWidth: 300,adjustMapMargin:true}
        // });
        //
        // mskRouteBtn.events.add('click', function () {
        //     // Меняет местами начальную и конечную точки маршрута.
        //     control.routePanel.state.set({
        //         fromEnabled: false,
        //         toEnabled: false,
        //         from: '',
        //         to: adress[0],
        //     });
        //     control.routePanel.geolocate('from');
        // });
        // myMap.controls.add(mskRouteBtn);
        //
        // istraRouteBtn.events.add('click', function () {
        //     // Меняет местами начальную и конечную точки маршрута.
        //     control.routePanel.state.set({
        //         fromEnabled: false,
        //         toEnabled: false,
        //         from: '',
        //         to: adress[1],
        //     });
        //     control.routePanel.geolocate('from');
        // });
        // myMap.controls.add(istraRouteBtn);
        //



    }
}

function average(nums) {
    var summ = 0;
    for(i in nums){
        summ = summ + +nums[i] ;
    }
    var average = Math.round10(summ / nums.length,-6);
    return average;
}
function remove_insta_w()
    {
        $('#eapps-instagram-feed-1 > a').remove();
        $('#yottie_1 > div.yottie-widget-inner > a').remove();
    }
/*
function vk_testi_show(result_block,current_page) {
    var body = $('body');
    if (!(body.hasClass('loading'))) {
        body.addClass('loading');
        var spinner = "<i class='icon-spin icon-2x animate-spin'></i>";
        result_block.html(spinner);

        var nonce = result_block.data('nonce');
        var data = {action: 'vk_testi', '_ajax_nonce': nonce,'current_page':current_page};
        $.post('/wp-admin/admin-ajax.php', data, function (result) {

            body.removeClass('loading');

            var result_json = JSON.parse(result);
            if (result_json.status === 0) {
                result_block.html(result_json.html);
            }
            else {
                console.log(result_json);
                result_block.html(result_json.error);
            }
        });
    }
}
*/





// Замыкание
(function() {
    /**
     * Корректировка округления десятичных дробей.
     *
     * @param {String}  type  Тип корректировки.
     * @param {Number}  value Число.
     * @param {Integer} exp   Показатель степени (десятичный логарифм основания корректировки).
     * @returns {Number} Скорректированное значение.
     */
    function decimalAdjust(type, value, exp) {
        // Если степень не определена, либо равна нулю...
        if (typeof exp === 'undefined' || +exp === 0) {
            return Math[type](value);
        }
        value = +value;
        exp = +exp;
        // Если значение не является числом, либо степень не является целым числом...
        if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
            return NaN;
        }
        // Сдвиг разрядов
        value = value.toString().split('e');
        value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
        // Обратный сдвиг
        value = value.toString().split('e');
        return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
    }

    // Десятичное округление к ближайшему
    if (!Math.round10) {
        Math.round10 = function(value, exp) {
            return decimalAdjust('round', value, exp);
        };
    }
    // Десятичное округление вниз
    if (!Math.floor10) {
        Math.floor10 = function(value, exp) {
            return decimalAdjust('floor', value, exp);
        };
    }
    // Десятичное округление вверх
    if (!Math.ceil10) {
        Math.ceil10 = function(value, exp) {
            return decimalAdjust('ceil', value, exp);
        };
    }
})();
