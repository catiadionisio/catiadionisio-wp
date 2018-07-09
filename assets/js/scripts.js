jQuery(function($) {
  $(document).ready(function($) {
    console.log('it works');

    /* Navigation */

    $(document).on('click', '#nav-icon', function() {
      $(this).toggleClass('open');
      $('.mobile-menu-container').toggleClass('open');
    });


    /* Posts dropdown */

    $(document).on({
      mouseenter: function() {
        $('.category-dropdown .dropdown-div').addClass('open');
      },

      mouseleave: function() {
        $('.category-dropdown .dropdown-div').removeClass('open');
      }
    }, '.category-dropdown');


    /* Posts gallery */

    if ($('.gallery-slider').length) {
      var i = 0;
      var sliders = [];

      $('.gallery-slider').each(function() {
        var $this = $(this);

        $this.imagesLoaded(function() {
          sliders[i] = $this;

          sliders[i].on('init', function() {
            setTimeout(function() {
              //$this.removeClass('hidden');
              //$this.closest('.gallery-slider-container').find('.gallery-current-slide').removeClass('hidden');
            }, 600);
          });

          sliders[i].on('init reInit afterChange', function(event, slick, currentSlide) {
            //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
            var i = (currentSlide ? currentSlide : 0) + 1;
            $this.closest('.gallery-slider-container').find('.gallery-current-slide span').text(i);
          });

          sliders[i].slick({
            dots: false,
            arrows: true,
            infinite: true,
            speed: 600
          });
        });

        i++;
      });
    }


    $(document).on('click', '.gallery-container .gallery-img', function(event) {
      event.preventDefault();

      var galleryContainer = $(this).closest('.gallery-container');
      var gallerySlider = galleryContainer.find('.gallery-slider').eq(0);

      if (!galleryContainer.find('.gallery-slider-container').eq(0).hasClass('visible')) {
        var slideNum = $(this).attr('data-slideNum');
        $(this).closest('.gallery-container').find('.gallery-slider-container .gallery-current-slide span').text(parseInt(slideNum, 10) + 1);
        gallerySlider.slick('slickGoTo', slideNum);

        $('body').addClass('oh');

        galleryContainer.find('.gallery-slider-container').eq(0).addClass('visible');

        setTimeout(function() {
          gallerySlider.find('.slick-current').focus();
        }, 400);
      }
    });


    $(document).on('click', '.close-gallery', function(event) {
      event.preventDefault();

      if ($('.gallery-slider-container').hasClass('visible')) {
        $('body').removeClass('oh');
        $('.gallery-slider-container').removeClass('visible');
      }
    });

    $(document).on('keyup', function(evt) {
      if (evt.keyCode == 27) {
        if ($('.gallery-slider-container').length && $('.gallery-slider-container').hasClass('visible')) {
          $('body').removeClass('oh');
          $('.gallery-slider-container').removeClass('visible');
        }
      }
    });
  });
});
