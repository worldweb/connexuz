@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error('{{$error}}');
        </script>
    @endforeach
@elseif (session()->get('flash_success'))
    <script>
        toastr.success("{{session()->get('flash_success')}}");
    </script>
@elseif (session()->get('flash_warning'))
    <script>
        toastr.warning("{{session()->get('flash_warning')}}");
    </script>
@elseif (session()->get('flash_info'))
    <script>
        toastr.info("{{session()->get('flash_info')}}");
    </script>
@elseif (session()->get('flash_error'))
    <script>
        toastr.error("{{session()->get('flash_error')}}");
    </script>
@elseif (session()->get('flash_message'))
    <script>
        toastr.info("{{session()->get('flash_info')}}");
    </script>
@endif