<!DOCTYPE html>
<html lang="en">
<head>

    @include('common.header')
</head>
<body>
	<!-- header section start -->
    @include('common.topbar')
	<!-- header section end -->
    
    @yield('content')
    {!!flash_message()!!}
    @include('common.help')
    

    @include('common.footer')

</body>
</html>
