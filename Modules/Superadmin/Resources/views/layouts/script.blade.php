<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/simplebar.js') }}"></script>
{{-- <script src="{{ asset('assets/js/dashboard.js') }}"></script> --}}
<script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
{{-- <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script src="{{ asset('assets/js/tinymce/tiny-init.js') }}" referrerpolicy="origin"></script> --}}

 @yield('js')
<script>
     function changeImage(element, id) {
        if (element.files && element.files[0]) {
            var reader = new FileReader();
            console.log(id);
            reader.onload = function(e) {
                $('.image-preview-' + id).attr('src', e.target.result);
            }

            reader.readAsDataURL(element.files[0]);
        }
    }


    $(".image").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    @if(count($errors) > 0)
    var list = {!! $errors !!};
    var values = '';
    jQuery.each(list, function (key, value) {
         values += value + '\n';
     });
            $(document).ready(function() {
            swal.fire({
                // title: 'Error!',
                text: values,
                icon: 'error'
            });
        });


    @endif
    $(document).ready(function() {
        $('.select2').select2();
    });

    $(document).on('click', '.btn-modal', function(e) {
        e.preventDefault();
        var container = $(this).data('container');
        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function(result) {
                $(container)
                    .html(result)
                    .modal('show');
            },
        });
    });


    $(document).on('keyup change', '#price', function () {
        var Self = $(this);
        $('#discount').prop('max', Self.val());
        checkDiscount();
    });

    $(document).on('keyup change', '#discount', function () {
        checkDiscount();
    });


    function checkDiscount() {
        var Discount = $('#discount');
        var Price = $('#price');
        var AfterDiscount = $('#after_discount');
        // Check If discount value larger than price
        if(parseFloat(Discount.val()) > parseFloat(Price.val())) {
            Discount.parent().addClass('has-error');
            AfterDiscount.val(parseFloat(Price.val()).toFixed(2));
        } else {
            Discount.parent().removeClass('has-error');
            AfterDiscount.val((parseFloat(Price.val()) - parseFloat(Discount.val())).toFixed(2));
        }
    }
</script>
