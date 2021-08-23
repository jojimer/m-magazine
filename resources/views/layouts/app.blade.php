<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp data-barba="wrapper">
    @php do_action('get_header') @endphp
    @include('partials.header')
    <div class="wrap container" role="document">
      <div class="content">
        <main class="main">
          <div class="row g-2 mt-5" id="top-feed">
            <div class="col-3">
              <div class="blue-box-component">
                @include('component::profile-box')
                  @divider('pt-3 pb-4')
                @include('component::filter-box')
                  @divider('pt-2 pb-4')
                @include('component::chatroom-box')
                  @divider('pt-2 pb-3')
              </div>
            </div>
            <div id="dynamic-container" class="col-9" data-barba="container" data-barba-namespace="{!! Page::slug() !!}">
              @yield('content')
            </div>
          </div>
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
