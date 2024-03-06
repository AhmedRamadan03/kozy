

(function ($) {
    "use strict";


    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').css('top', '0px');
        } else {
            $('.sticky-top').css('top', '-100px');
        }
    });


    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";

    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });





    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        center: true,
        margin: 24,
        dots: true,
        loop: true,
        nav : false,
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:3
            }
        }
    });





    // window.addEventListener('contextmenu', function (e) {
    //     e.preventDefault();
    // }, false);


    // document.addEventListener('keydown', function(event) {
    //     if(event.keyCode==123){
    //         event.preventDefault();
    //         return false;
    //     }
    //     else if(event.ctrlKey && event.shiftKey && event.keyCode==73){
    //         event.preventDefault();
    //         return false;  //Prevent from ctrl+shift+i
    //     }
    // });
    document.addEventListener('keyup', (e) => {
        if (e.key == 'PrintScreen') {
            navigator.clipboard.writeText('no ):');
        }
    });


})(jQuery);

function addWish(element){

    var This = $(element);
    var Liked = This.hasClass('liked') ? true : false;
    var Url = This.hasClass('liked') ? $('#FavoritesDelete').attr('href') : $('#FavoritesStore').attr('href');
    var favoritesCount = $('.favoritesCount');
    $.ajax({
        url: Url,
        type: 'post',
        dataType: 'json',
        data: {'course_code': This.data('course_code'), '_token': $('meta[name="_token"]').attr('content')},
        success: function (res) {
            if (res.status === true) {
                if (Liked) {
                    This.removeClass('liked');
                    This.addClass('unliked');
                    This.removeClass('favorite')
                    $(element).html('<svg viewBox="0 0 24 24" width="24" height="24" stroke="black" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>');


                } else {
                    This.addClass('liked');
                    This.removeClass('unliked');
                    This.addClass('favorite');
                    $(element).html('<svg viewBox="0 0 24 24" width="24" height="24" stroke="red" stroke-width="2" fill="red" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>');

                }
                    swal.fire("", res.message, "success");
                    favoritesCount.html(res.data.count);
            }
        },
        error: function (e) {
            window.location.href = '/login';
        }
    });

}

function addToCart(elment){

    var form = $(elment).parent();
      let CartStoreR = $('#CartStoreR');
      let submitBtnAddCart = form.find('#submitBtnAddCart');

      // Set Send Data
      let sendData = {
          'course_code': $(form).find('.course_code').val(),
      };
      $.ajax({
          url: CartStoreR.attr('href'),
          type: 'post',
          dataType: 'json',
          beforeSend: function () {
              $(elment).attr('disabled', true).append('<i class="ion-load-a spinnerBTN"></i>');
          },
          data: {'cart': sendData, '_token': $('meta[name="_token"]').attr('content')},
          success: function (res) {
              $(elment).attr('disabled', false).find('.spinnerBTN').remove();
              if (res.status === true) {
                  $('#cart_header_box').html(res.data.resultCheckout);
                  $('.cart_trigger .cart_count span').html((res.data.items_count > 99 ? '+99' : res.data.items_count));
                  swal.fire("", res.message, "success");



                }
          },
          error: function (reject) {

          }
      });
      return false;
  }

function deleteItem(elment ,id){

      let CartStoreR = $('#CartDelete');
      $.ajax({
          url: CartStoreR.attr('href'),
          type: 'post',
          dataType: 'json',
          data: {'id': id, '_token': $('meta[name="_token"]').attr('content')},
          success: function (res) {
              if (res.status === true) {
                  $('#cart_header_box').html(res.data.resultCheckout);
                  $('.cart_trigger .cart_count span').html((res.data.items_count > 99 ? '+99' : res.data.items_count));
                  swal.fire("", res.message, "success");

                //   console.log(window.location.pathname+'cart');
                  alert(window.location.hostname );
                  if (window.location.hostname == window.location.hostname+'/cart') {
                      window.location.reload();
                  }
                }
          },
          error: function (reject) {

          }
      });
      return false;
  }




