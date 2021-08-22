<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp data-barba="wrapper">
    @php do_action('get_header') @endphp
    @include('partials.header')
    <div id="main-container" class="wrap container" role="document"  data-barba="container" data-barba-namespace="{!! Page::slug() !!}">
      <div class="content">
        <main class="main">
          @yield('content')
        </main>
        @if (App\display_sidebar())
          <aside class="sidebar">
            @include('partials.sidebar')
          </aside>
        @endif
      </div>
    </div>
    @php wp_footer() @endphp
  </body>
</html>
