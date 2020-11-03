jQuery.fn.yprm_split_screen = function () {
  return this.each(function () {
    jQuery('body').addClass('body-one-screen');

    var $this_el = jQuery(this),
      $el = $this_el.find('.screen-item'),
      $nav = $this_el.find('.nav-arrows'),
      $counter = $this_el.find('.counter'),
      $pagination = $nav.find('.pagination'),
      delay = 1000,
      status = false;

    $el.each(function (index) {
      index++;
      $pagination.append('<span data-magic-cursor="link-small"></span>');
    });

    jQuery(window).on('load resize', function () {
      var height = jQuery(window).outerHeight() - jQuery('.header-space:visible').height() - jQuery('#wpadminbar').outerHeight();
      $this_el.css('height', height);
      $this_el.find('.items .item').css('height', height);

      $el.find('.letter').each(function () {
        var $l_el = jQuery(this),
          p_w = $l_el.parent().width(),
          f_size = 0;

        if (height > p_w) {
          f_size = p_w;
        } else {
          f_size = height;
        }
        if (f_size > 800) {
          f_size = 800;
        }
        $l_el.css('font-size', f_size);
      });
    });

    function vertical_parallax(coef, index) {
      index = index === undefined ? false : index;
      if (coef != false) {
        var index = $this_el.find('.screen-item.current').index() - coef;
      }
      $el.eq(index).removeClass('prev next').addClass('current').siblings().removeClass('current');
      $el.eq(index).prevAll().removeClass('next').addClass('prev');
      $el.eq(index).nextAll().removeClass('prev').addClass('next');

      $pagination.find('span:eq('+index+')').addClass('current').siblings().removeClass('current');
      
      $counter.find('.current').text(leadZero(index+1));
      $counter.find('.total').text(leadZero($el.length));

      if(index == 0) {
        $nav.find('.prev').addClass('disabled');
      } else {
        $nav.find('.prev').removeClass('disabled');
      }
      
      if(index == ($el.length - 1)) {
        $this_el.find('.scroll-down').addClass('reverse');
        $nav.find('.next').addClass('disabled');
      } else {
        $this_el.find('.scroll-down').removeClass('reverse');
        $nav.find('.next').removeClass('disabled');
      }
    }

    vertical_parallax(false, 0);

    $this_el.on('mousewheel wheel', function (e) {
      if (jQuery(window).width() > 768) {
        e.preventDefault();
        var cur = $this_el.find('.screen-item.current').index();
        if (status != true) {
          status = true;
          if (e.originalEvent.deltaY > 0 && cur != parseInt($el.length - 1)) {
            vertical_parallax('-1');
            setTimeout(function () {
              status = false
            }, delay);
          } else if (e.originalEvent.deltaY < 0 && cur != 0) {
            vertical_parallax('1');
            setTimeout(function () {
              status = false
            }, delay);
          } else {
            status = false;
          }
        }
      }
    });

    $nav.on('click', '.prev:not(.disabled)', function() {
      vertical_parallax('1');
    }).on('click', '.next:not(.disabled)', function() {
      vertical_parallax('-1');
    });

    $this_el.find('.scroll-down').on('click', function() {
      if(jQuery(this).hasClass('reverse')) {
        vertical_parallax(false, 0);
      } else {
        vertical_parallax('-1');
      }
    });
  });
};