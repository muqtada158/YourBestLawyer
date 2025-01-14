jQuery(document).ready(function($){
    // Menu
    document.querySelector(".hamburger").addEventListener("click", function() {
        this.classList.toggle("is-active");
    });
    const testimonial_images_swiper = new Swiper('.swiper.testimonial-images-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        breakpoints: {
            500: {
                slidesPerView: 1,
                spaceBetween: 0
            },
            1280: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            1380: {
                slidesPerView: 5,
                spaceBetween: 20
            }
        },
        centeredSlides: true,
        roundLengths: true,
        loop: true,
        navigation: {
            nextEl: '.testimonial-images-swiper .swiper-button-next',
            prevEl: '.testimonial-images-swiper .swiper-button-prev',
        },
    });

    const testimonial_text_swiper = new Swiper('.swiper.testimonial-text-swiper', {
        slidesPerView: 1,
        loop: true,
        navigation: {
            nextEl: '.testimonial-images-swiper .swiper-button-next',
            prevEl: '.testimonial-images-swiper .swiper-button-prev',
        },
    });

});
$(function(){

  //Scroll event
  $(window).scroll(function(){
    var scrolled = $(window).scrollTop();
    if (scrolled > 500) $('.go-top').fadeIn('slow');
    if (scrolled < 500) $('.go-top').fadeOut('slow');
  });

  //Click event
  $('.go-top').click(function () {
    $("html, body").animate({ scrollTop: "0" },  200);
  });

});
