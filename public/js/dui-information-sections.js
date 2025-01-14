jQuery(document).ready(function($){
  var playlistSlider = $('.playlist.slider');
  playlistSlider.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    vertical: true,
    verticalSwiping: true,
    autoplay: false,
  });
  $('.playlist.slider + .navigation-arrows .previous-slide').on('click',function(){
    playlistSlider.slick('slickPrev');
  });
  $('.playlist.slider + .navigation-arrows .next-slide').on('click',function(){
    playlistSlider.slick('slickNext');
  });
});