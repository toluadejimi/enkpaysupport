<!-- js file  -->
<script src="{{ asset('common/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('common/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('common/js/plugins.js') }}"></script>
<script src="{{ asset('common/js/percircle.js') }}"></script>
<script src="{{ asset('common/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('common/js/jQuery-plugin-progressbar.js') }}"></script>
<script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
<script src="{{ asset('common/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('common/js/select2.min.js') }}"></script>
<script src="{{ asset('common/js/toastr.min.js') }}"></script>
<script src="{{ asset('common/js/sweetalert2.all.js') }}"></script>
<script src="{{ asset('customer/assets/js/coustom.js') }}"></script>
<script src="{{ asset('common/js/common.js') }}"></script>
<script src="{{ asset('common/js/pusher.min.js') }}"></script>
<script src="{{ asset('agent/assets/js/custom/chat.js') }}"></script>
<script src="{{ asset('assets/js/chat.js') }}"></script>
<script>
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
    var pushActive = "{{getOption('pusher_status')}}";
</script>

<script src="{{ asset('customer/assets/js/custom/progress_bar.js') }}"></script>
<script src="{{ asset('customer/assets/js/custom/layout.js') }}"></script>
