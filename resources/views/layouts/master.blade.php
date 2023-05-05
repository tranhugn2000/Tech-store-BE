<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Huji</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/tailwind.output.css') }}" />
  <link rel="stylesheet" href="{{ asset('plugins/fancy-file-uploader/fancy_fileupload.css') }}" type="text/css" media="all" />
  
  @yield('css')
</head>

<body>
  <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen}">
    <!-- Desktop sidebar -->
      @include('layouts.navigation')
      <div class="flex flex-col flex-1">
      @include('layouts.header')

      <main class="h-full pb-16 overflow-y-auto">
        <!-- Remove everything INSIDE this div to a really blank page -->
          @yield('content')
      </main>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('js/init-alpine.js') }}"></script>
  <script src="https://kit.fontawesome.com/ec9329e6ad.js" crossorigin="anonymous"></script>
  <script src="{{ asset('plugins/fancy-file-uploader/jquery.ui.widget.js') }}"></script>
  <script src="{{ asset('plugins/fancy-file-uploader/jquery.fileupload.js') }}"></script>
  <script src="{{ asset('plugins/fancy-file-uploader/jquery.iframe-transport.js') }}"></script>
  <script src="{{ asset('plugins/fancy-file-uploader/jquery.fancy-fileupload.js ') }}"></script>

  <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
       
    $(document).ready(function() {
      $(document).on('click', '.btn-logout', function() {
        $('.logout-form').submit();
      });
    });
  </script>
  @yield('script')
</body>

</html>