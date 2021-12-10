<header class="banner">
  <div class="container">
    <nav class="navbar justify-content-between p-0">
        <a class="navbar-brand py-0 px-4" href="/">@fas_icon('fire-alt') LOGO</a>
        <ul class="navbar-nav">
          <li class="nav-item">            
            <a href="/" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="/news" class="nav-link">News</a>
          </li>
          <li class="nav-item">
            <a href="/galleries" class="nav-link">Gallery</a>
          </li>
          <li class="nav-item">
            <a href="/shop" class="nav-link">Shop</a>
          </li>
          <li class="nav-item">
            <a href="/field-reports" class="nav-link">Field Report</a>
          </li>
          <li class="nav-item">
            <div class="icons-wrap">
              {{-- <span class="icon-holder">
                @far_icon('comment-alt')
              </span>
              <span class="icon-holder">
                @far_icon('bell')
              </span> --}}
              {{ get_search_form(['echo']) }}
              <span class="icon-holder mx-3 account-icon">
                @far_icon('user')
              </span>
            </div>
            <div class="nav-account d-none">
              @if(!is_user_logged_in())
                <span class="xoo-el-login-tgr">Login</span>
                <span class="xoo-el-reg-tgr">Sign Up</span>
              @else
                <span><a href="/my-account" class="text-dark">My Account</a></span>
                <span id="logout-trigger"><a class="text-dark" href="#">Logout</a></span>
              @endif
            </div>
          </li>
        </ul>
      </nav>
  </div>
</header>
