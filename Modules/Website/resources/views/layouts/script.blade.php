<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('website/lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('website/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('website/lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('website/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('website/lib/counterup/counterup.min.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('website/js/main.js') }}"></script>

@yield('js')

<script>
    function addWish(element) {

var This = $(element);
var Liked = This.hasClass('liked') ? true : false;
var Url = This.hasClass('liked') ? $('#FavoritesDelete').attr('href') : $('#FavoritesStore').attr('href');



$.ajax({
    url: Url,
    type: 'post',
    dataType: 'json',
    data: {
        'product_id': This.data('id'),
        '_token': '{{ csrf_token() }}'
    },
    success: function(res) {
        if (res.status === true) {
            if (Liked) {
                $('body').find(`[data-id='${This.data('id')}']`).each(function() {
                    $(element).removeClass('liked');
                    $(element).addClass('unliked');
                    $(element).removeClass('favorite')
                    $(this).html(' <svg width="40" height="40" viewBox="0 0 40 40" fill="none"xmlns="http://www.w3.org/2000/svg"><circle cx="20" cy="20" r="19.5" stroke="#EAECF0" /><path d="M24.6875 11C22.7516 11 21.0566 11.8325 20 13.2397C18.9434 11.8325 17.2484 11 15.3125 11C13.7715 11.0017 12.294 11.6147 11.2044 12.7044C10.1147 13.794 9.50174 15.2715 9.5 16.8125C9.5 23.375 19.2303 28.6869 19.6447 28.9062C19.7539 28.965 19.876 28.9958 20 28.9958C20.124 28.9958 20.2461 28.965 20.3553 28.9062C20.7697 28.6869 30.5 23.375 30.5 16.8125C30.4983 15.2715 29.8853 13.794 28.7956 12.7044C27.706 11.6147 26.2285 11.0017 24.6875 11ZM20 27.3875C18.2881 26.39 11 21.8459 11 16.8125C11.0015 15.6692 11.4563 14.5732 12.2647 13.7647C13.0732 12.9563 14.1692 12.5015 15.3125 12.5C17.1359 12.5 18.6669 13.4713 19.3062 15.0312C19.3628 15.1688 19.4589 15.2865 19.5824 15.3693C19.7059 15.4521 19.8513 15.4963 20 15.4963C20.1487 15.4963 20.2941 15.4521 20.4176 15.3693C20.5411 15.2865 20.6372 15.1688 20.6937 15.0312C21.3331 13.4684 22.8641 12.5 24.6875 12.5C25.8308 12.5015 26.9268 12.9563 27.7353 13.7647C28.5437 14.5732 28.9985 15.6692 29 16.8125C29 21.8384 21.71 26.3891 20 27.3875Z"fill="#D0D5DD" /></svg>')
                })
            } else {
                $('body').find(`[data-id='${This.data('id')}']`).each(function() {
                    $(this).addClass('liked');
                    $(this).removeClass('unliked');
                    $(this).addClass('favorite');
                    $(element).html('<svg width="41" height="40" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="20.333" cy="20" r="19.5" stroke="#EAECF0"/><path d="M30.833 16.8125C30.833 23.375 21.1027 28.6869 20.6883 28.9062C20.5791 28.965 20.457 28.9958 20.333 28.9958C20.209 28.9958 20.0869 28.965 19.9777 28.9062C19.5633 28.6869 9.83301 23.375 9.83301 16.8125C9.83474 15.2715 10.4477 13.794 11.5374 12.7044C12.627 11.6147 14.1045 11.0017 15.6455 11C17.5814 11 19.2764 11.8325 20.333 13.2397C21.3896 11.8325 23.0846 11 25.0205 11C26.5615 11.0017 28.039 11.6147 29.1286 12.7044C30.2183 13.794 30.8313 15.2715 30.833 16.8125Z" fill="#ED3436"/></svg>');
                });
                // window.location.reload();
            }

            // if (This.hasClass('from_wishlist')) {
            //     This.parents('tr').remove();
            // }
            // favoritesCount.html(res.data.count);

            // window.location.reload();
        }

    },
    error: function(e) {
        if (e.status === 401) {
            window.location.href = $('#LoginUrl').attr('href');
        }
        Messages.append('<div class="fl fl_red">' + e.responseJSON.message + '</div>');
        $('.fl').slideDown(300);
        setTimeout(function() {
            $('.fl').slideUp(300);
        }, 3000);
    }
});

}
</script>
