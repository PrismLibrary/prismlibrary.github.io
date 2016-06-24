 $(document).ready(function(){
      $('.carousel').slick({
			infinite: true,
			lazyLoad: 'ondemand',
			slidesToShow: 1,
			slidesToScroll: 1,			
			speed: 500,
			fade: true,
			cssEase: 'linear',
			autoplay: true,
			autoplaySpeed: 2000,
			arrows: false 
      });   
    });