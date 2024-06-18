<!-- js file  -->
<script src="{{ asset('common/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('common/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('common/js/plugins.js') }}"></script>
<script src="{{ asset('common/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('common/js/toastr.min.js') }}"></script>
<script src="{{ asset('common/js/sweetalert2.all.js') }}"></script>
<script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
<script src="{{ asset('common/js/common.js') }}"></script>

<script>
    var currencySymbol = "{{ getCurrencySymbol() }}";
    var currencyPlacement = "{{ getCurrencyPlacement() }}";

    @if (Session::has('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if (Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif
    @if (Session::has('info'))
        toastr.info("{{ session('info') }}");
    @endif
    @if (Session::has('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if (@$errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
