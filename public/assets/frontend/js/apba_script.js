$(document).ready(function () {


    // Language Dropdown Open 
    // $('.language_drpdwn').click(() => {
    //     $('.language_drpdwn_content').toggleClass('open');
    // });

    // Membership Type List Limit
    $('.membership_type_list').each(function () {
        $(this).find('li').each(function (index) {
            if (index >= 4) $(this).hide()
        })
    });


    // Scroll To Top Of Page
    $("#move-to-top").hide();
    $(function scrollTop() {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 350) {
                $('#move-to-top').fadeIn();
            } else {
                $('#move-to-top').fadeOut();
            }
        });
        $("#move-to-top").click(() => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            })
        });
    });

    // Event Details Page Photo Gallery
    $('#photo_gallery_slider').owlCarousel({
        items: 1,
        loop: true,
        margin: 30,
        nav: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        animateOut: 'fadeIn',
        animateIn: 'fadeIn',
        responsive: {
            0: {
                items: 1.4
            },
            600: {
                items: 1.4
            },
            1000: {
                items: 1.4
            }
        }
    });

    $('[data-fancybox]').fancybox({
        buttons: [
            'close'
        ],
        wheel: false,
        transitionEffect: "slide",
        // thumbs          : false,
        // hash            : false,
        loop: true,
        // keyboard        : true,
        toolbar: false,
        // animationEffect : false,
        // arrows          : true,
        clickContent: false
    });


    // Survey Table
    $('#survey_mobile_table').owlCarousel({
        items: 1,
        loop: false,
        margin: 30,
        nav: true,
    });
    $( "#survey_mobile_table .owl-prev").html('<svg xmlns="http://www.w3.org/2000/svg" height="1.5em" fill="#868484" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg>');
    $( "#survey_mobile_table .owl-next").html('<svg xmlns="http://www.w3.org/2000/svg" height="1.5em" fill="#868484" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>');


    // Event Details Sidenav
    $(document).on('click', '.side_nav_items', function (e) {
        $('.side_nav_items').removeClass("active");
        $(this).addClass("active");
    });


    // SortBy Dropdown Open n Close
    $(".sort_by_dropdown_val").click(function() { 
        $(this).siblings().addClass("open");
     });

    $(document).mouseup(function (e) {
        var container = $(".sort_by_dropdown_content");
        if (e.target != container && e.target.parentNode != container) {
            container.removeClass('open');
        }
    });

    // Membership Div Hover Color
    $('.membership_type_link').on('mouseover', function () {
        $(this).parent().css('background-color', '#02b0b5');
    }).on('mouseout', function () {
        $(this).parent().css('background-color', '#005599');
    });

    // Event Participate Div Show Hide
    $('#guest').click(() => {
        $('.event_participate_div').toggleClass('d-none');
    });

    // Stepper Scripts Strts
    let curOpen;
    curOpen = $('.step')[0];
    // $('.next-btn').on('click', function () {
    //     let cur = $(this).closest('.step');
    //     let next = $(cur).next();
    //     $(cur).addClass('minimized');
    //     setTimeout(function () {
    //         $(next).removeClass('minimized');
    //         curOpen = $(next);
    //     }, 400);
    //     $('#step_1_span').toggle();
    //     $('#step_1_img').toggle();
    // });
    $('.step .step_content').on('click', function (e) {
        e.stopPropagation();
    });
    $('.step').on('click', function () {
        if (!$(this).hasClass("minimized")) {
            curOpen = null;
            $(this).addClass('minimized');
        } else {
            let next = $(this);
            if (curOpen === null) {
                curOpen = next;
                $(curOpen).removeClass('minimized');
            } else {
                $(curOpen).addClass('minimized');
                setTimeout(function () {
                    $(next).removeClass('minimized');
                    curOpen = $(next);
                }, 300);
            }
        }
    });
    // Stepper Scripts Ends

    // Tablet Responsive
    if ((screen.width >= 769 && screen.width <= 825)) {
        $('.home_section_2 .col-md-6').removeClass('pl-4');
        $('.home_section_2 .col-md-6:first-child').addClass('mb-4');

        $('.menu-icon-toggle').on('click', () => {
            $('.header_logo').toggle();
            $('.header_language_dropdown').toggle();
            $('.header_search_box').toggle();
            $('.header_login_box').toggle();
            $(".header_search_input").attr("placeholder", "How Can We Help?");
            $('.home').toggleClass('open_menu');
            $('.nav_toggle').toggle();
            $('.nav_toggle_close').toggle();
            $('body').toggleClass('modal-open');
            $('#nav_backdrop').toggleClass('modal_white_backdrop');
            $('.header_top').toggleClass('w-100');
            $('header').removeClass('header_scrolled_responsive');
        });
    }
    if ((screen.width >= 576 && screen.width <= 768)) {

        $('.home_section_2 .col-md-6').removeClass('pl-4');
        $('.home_section_2 .col-md-6:first-child').addClass('mb-4');
        $('.home_section_5 .col-sm-3').removeClass('col-sm-3').addClass('col-sm-6');
        $('.home_section_5 .col-sm-9').removeClass('col-sm-9 pl-5').addClass('col-sm-6 pl-3');
        $('.resources_div .col-sm-3').removeClass('col-sm-3').addClass('col-sm-12');
        $('.resources_div .col-sm-9').removeClass('col-sm-9 pl-4').addClass('col-sm-12 mt-5');
        $('.event_detail_div .col-sm-3').addClass('d-none');
        $('.event_detail_div .col-sm-9').removeClass('col-sm-9').addClass('col-sm-12');
        $('.profile_div .col-sm-3').removeClass('col-sm-3').addClass('col-sm-12');
        $('.profile_div .col-sm-9').removeClass('col-sm-9 pl-4').addClass('col-sm-12 mt-5');
        $('.about_items').removeClass('ml-4').addClass('mb-4');
        $('.footer_div').addClass('mb-4');
        $('.footer_div .col-sm-4').removeClass('pr-5');
        $('.footer_div .col-sm-3').removeClass('pl-5 mb-4');
        $('.footer_div .col-sm-5').removeClass('pl-5');
        $('.event_section_speakers_thumb').parent().addClass('mx-0');
        $('.membership_thumb').removeClass('my-5').addClass('mb-5');       

        $('.menu-icon-toggle').on('click', () => {
            $('.header_logo').toggle();
            $('.header_language_dropdown').toggle();
            $('.header_search_box').toggle();
            $('.header_login_box').toggle();
            $(".header_search_input").attr("placeholder", "How Can We Help?");
            $('.home').toggleClass('open_menu');
            $('.nav_toggle').toggle();
            $('.nav_toggle_close').toggle();
            $('body').toggleClass('modal-open');
            $('#nav_backdrop').toggleClass('modal_white_backdrop');
            $('.header_top').toggleClass('w-100');
            $('header').removeClass('header_scrolled_responsive');
        });

        // Header Scroll Top
        $(window).scroll(function () {
            if ($(window).scrollTop() >= 100) {
                $('header').addClass('header_scrolled_responsive');
            }
            else {
                $('header').removeClass('header_scrolled_responsive');
            }
        });
        // Header Scroll Top

    }

    // Reverse Tablet Responsive
    if ((screen.width > 825)) {

        var nav_width = $('.site_navbar').width();
        $('.header_top').css('width', nav_width);

        $(window).scroll(function () {
            if ($(window).scrollTop() >= 100) {
                $('header').addClass('header_scrolled');
                $('.header_logo').addClass('header_logo_sized');
                $('.site_navbar').css('margin-top', '-65px');
                $('.header_top').addClass('header_top_hide');
            }
            else {
                $('header').removeClass('header_scrolled');
                $('.header_logo').removeClass('header_logo_sized');
                $('.site_navbar').css('margin-top', '-25px');
                $('.header_top').removeClass('header_top_hide');
            }
        });

        // Search Placeholder Set 
        $('.header_search_icon').mouseover(() => {
            $('.header_search_input').attr('placeholder', 'Type to search');
        });
        $('.header_search_input').focusout(() => {
            $('.header_search_input').attr('placeholder', '');
        });


        // Event Nav Sticky 
        $(window).scroll(function () {
            if ($(window).scrollTop() >= 400) {
                $('.event_nav').addClass('sticky_event_nav');
            } else {
                $('.event_nav').removeClass('sticky_event_nav');
            }
        });
        // Event Nav Sticky
    }

    // Mobile Responsive
    if ((screen.width <= 576)) {

        $('.home_section_2 .col-md-6').removeClass('pl-4');
        $('.home_section_2 .col-md-6:first-child').addClass('mb-4');    
        $('.home_section_3 .row').addClass('slide_top');
        $('.home_section_3 .col-sm-4').addClass('slide_child pr-0');
        $('.home_section_4 .col-sm-6:first-child').removeClass('pr-5');
        $('.home_section_4 .col-sm-6:last-child').addClass('slide_top py-5');
        $('.home_section_4 .partners_div_outer').addClass('slide_child');
        $('.home_section_5 div:nth-child(2)').addClass('mt-4');
        $('.home_section_5 .col-sm-9').removeClass('pl-5');
        $('.about_items').removeClass('ml-4 mt-5').addClass('mb-4');
        $('.about_items').parent().addClass('mx-0');
        $('.our_team_header_div h2').removeClass('mb-5');
        $('.sortby_nav_div').removeClass('ml-5');
        $('.sortby_nav_div:last-child').addClass('mt-4');
        $('.aboutus_section_2').removeClass('mr-0');
        $('.aboutus_section_3 .col-sm-4').removeClass('py-5');
        $('.about_vision_content').removeClass('pr-5');
        $('.our_team_list').removeClass('my-5');
        $('.our_team_details_row_div .col-sm-9').addClass('mt-5');
        $('.small_nav .fa-chevron-right').removeClass('mx-4').addClass('mx-3 my-1');
        $('.certificate_div').addClass('slide_top');
        $('.certificate_items').addClass('slide_child');
        $('.event_nav_row').removeClass('mx-0');
        $('.event_detail_div .col-sm-3').addClass('d-none');
        $('.event_detail_div .col-sm-9').removeClass('pl-4');
        $('.resources_header_div h2').removeClass('mb-5').addClass('mb-4');
        $('.resources_div .col-sm-3').addClass('mb-5');
        $('.resources_div .col-sm-9').removeClass('pl-4');
        $('.membership_thumb').removeClass('my-5').addClass('mb-4 mt-3');
        $('.profile_div .col-sm-3').addClass('mb-5');
        $('.profile_div .col-sm-9').removeClass('pl-4');
        $('.contact_header_div h2').removeClass('mb-5').addClass('mb-3');
        $('.footer_div .col-sm-3').removeClass('pl-5');
        $('.footer_div .col-sm-5').removeClass('pl-5').addClass('mb-4 mt-4');
        
        $('.nominee_modal_row_div').removeClass('px-3 pt-5 pb-4');
        $('.nominee_modal_thumb').addClass('mx-auto');
        $('.nomination_filter').removeClass('d-flex justify-content-between');
        $('.namination_search_div').removeClass('w-50').addClass('w-100');
        $('.nomination_filter .sortby_nav_div').removeClass('mt-3').addClass('mb-5 ml-3');

        $('.step_content').removeClass('px-2');
        $('.final_price_check .checkbox').removeClass('mr-4').addClass('mr-3');
        $('.event_payment_details_value_left').addClass('mt-2');

        $('.search_row_div .col-sm-3').addClass('p-0 mt-3');
        $('.search_row_div .col-sm-9').removeClass('pl-4').addClass('p-0 mt-4');

        $('.task_progress_section').removeClass('mb-5').addClass('mb-4');
        
        $('.menu-icon-toggle').on('click', () => {
            $('.header_logo').toggle();
            $('.header_language_dropdown').toggle();
            $('.header_search_box').toggle();
            $('.header_login_box').toggle();
            $(".header_search_input").attr("placeholder", "How Can We Help?");
            $('.home').toggleClass('open_menu');
            $('.nav_toggle').toggle();
            $('.nav_toggle_close').toggle();
            $('body').toggleClass('modal-open');
            $('#nav_backdrop').toggleClass('modal_white_backdrop');
            $('.header_top').toggleClass('w-100');
            $('header').removeClass('header_scrolled_responsive');
        });

        // Cd Popup
        $('#login_cd_popup_trigger').on('click', function (event) {
            event.preventDefault();
            $('#login_cd_popup').addClass('is-visible');
            $('body').toggleClass('modal-open');
            $('#nav_backdrop').toggleClass('modal_white_backdrop');
        });

        $('#login_cd_popup_open').on('click', function (event) {
            event.preventDefault();
            $('#login_cd_popup').addClass('is-visible');
            $('body').toggleClass('modal-open');
            $('#nav_backdrop').toggleClass('modal_white_backdrop');
        });

        $('#lost_pass_cd_popup_trigger').on('click', function (event) {
            event.preventDefault();
            $('#lost_pass_cd_popup').addClass('is-visible');
            $('#login_cd_popup').removeClass('is-visible');
        });

        // $('.nominate_popop_trigger').on('click', function (event) {
        //     event.preventDefault();
        //     $('#nominate_cd_popup').addClass('is-visible');
        //     $('body').addClass('modal-open');
        //     $('#nav_backdrop').toggleClass('modal_white_backdrop');
        // });


        // $('.close_modal').click(() => {
        //     $('.cd_popup').removeClass('is-visible');
        //     $('body').removeClass('modal-open');
        //     $('#nav_backdrop').removeClass('modal_white_backdrop');
        //     $('#cd_popup_backdrop').removeClass('cd_popup_backdrop');
        //     $('.home_container').removeClass('blur_bg');
        // });
        $(document).keyup(function (event) {
            if (event.which == '27') {
                $('.cd_popup').removeClass('is-visible');
                $('body').removeClass('modal-open');
                $('#nav_backdrop').removeClass('modal_white_backdrop');
            }
        });
        // Cd Popup

        // Header Scroll Top
        $(window).scroll(function () {
            if ($(window).scrollTop() >= 100) {
                $('header').addClass('header_scrolled_responsive');
            }
            else {
                $('header').removeClass('header_scrolled_responsive');
            }
        });
        // Header Scroll Top

        // Our Team Dropdown Filter Start
        $(".team_filter_li_active_value").click(function () {
            $('.team_filter').toggleClass("open");
        });
        $(".team_filter li").click(function () {
            $('.team_filter').toggleClass("open");
            var active_li = $(this).html();
            $('.team_filter_li_active_value span').html(active_li);
        });
        // Our Team Dropdown Filter End

        // News & Events Filtering Start
        $('.news_event_filter_mob').on('click', () => {
            $('.news_event_div_section').toggle();
            $('body').toggleClass('modal-open');
        });
        $('.news_event_filter_close').on('click', () => {
            $('.news_event_div_section').toggle();
            $('body').toggleClass('modal-open');
        });
        $('.news_event_filter_apply_btn').on('click', () => {
            $('.news_event_div_section').hide();
            $('body').toggleClass('modal-open');
        });
        // News & Events Filtering End

        // Event Nav Sticky 
        $(window).scroll(function () {
            if ($(window).scrollTop() >= 400) {
                $('.event_nav').addClass('d-none');
                $('.event_nav_register_float').css('display', 'block');
            } else {
                $('.event_nav').removeClass('d-none');
                $('.event_nav_register_float').css('display', 'none');
            }
        });
        // Event Nav Sticky

        // Resources Filtering Start
        $('.resources_filter_mob').on('click', () => {
            $('.resources_filter_div').toggle();
            $('body').toggleClass('modal-open');
        });
        $('.resources_filter_close').on('click', () => {
            $('.resources_filter_div').toggle();
            $('body').toggleClass('modal-open');
        });
        $('.resources_filter_apply_btn').on('click', () => {
            $('.resources_filter_div').hide();
            $('body').toggleClass('modal-open');
        });
        // Resources Filtering 

    }

    // Reverse Mobile Responsive
    if ((screen.width >= 576)) {

        // Cd Popup
        $('#login_cd_popup_trigger').on('click', function (event) {
            event.preventDefault();
            $('#login_cd_popup').addClass('is-visible');
            $('body').addClass('modal-open');
            $('#cd_popup_backdrop').addClass('cd_popup_backdrop');
            $('.home_container').addClass('blur_bg');
            $('header').addClass('blur_bg');
        });

        $('#login_cd_popup_open').on('click', function (event) {
            event.preventDefault();
            $('#login_cd_popup').addClass('is-visible');
            $('body').addClass('modal-open');
            $('#cd_popup_backdrop').addClass('cd_popup_backdrop');
            $('.home_container').addClass('blur_bg');
            $('header').addClass('blur_bg');
        });

        $('#lost_pass_cd_popup_trigger').on('click', function (event) {
            event.preventDefault();
            $('#lost_pass_cd_popup').addClass('is-visible');
            $('#login_cd_popup').removeClass('is-visible');
        });
        // Cd Popup

        // Our Team Dropdown
        $(document).on('click', '.team_filter li', function (e) {
            $('.team_filter li').removeClass("active nav_slide");
            $(this).addClass("active nav_slide");
        });
        // Our Team Dropdown

    }


    // CD Popup Close 
    $(document).keyup(function (event) {
        if (event.which == '27') {
            $('.cd_popup').removeClass('is-visible');
            $('body').removeClass('modal-open');
            $('#cd_popup_backdrop').removeClass('cd_popup_backdrop');
            $('.home_container').removeClass('blur_bg');
            $('header').removeClass('blur_bg');
        }
    });

    $('.cd_popup').on('click', function (event) {
        if ($(event.target).is('.close_modal') || $(event.target).is('.cd_popup')) {
            event.preventDefault();
            $(this).removeClass('is-visible');
            $('body').removeClass('modal-open');
            $('#cd_popup_backdrop').removeClass('cd_popup_backdrop');
            $('.home_container').removeClass('blur_bg');
            $('header').removeClass('blur_bg');
        }
    });

});

