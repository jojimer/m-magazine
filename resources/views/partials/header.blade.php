<header class="banner">
  <div class="container">
    <nav class="navbar justify-content-between p-0">
        <a class="navbar-brand py-0 px-4" href="/">@fas_icon('fire-alt') LOGO</a>
        <div class="responsive-navbar-wrap">
        <ul class="navbar-nav responsive-navbar">
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
              @php
                get_search_form(['echo']);
                $userID = get_current_user_id();
                $user = get_userdata($userID); 
              @endphp
              <div class="nav-account d-none">                
                @if(!is_user_logged_in())
                  <span class="xoo-el-login-tgr">Login</span>
                  <span class="xoo-el-reg-tgr">Sign Up</span>
                @else
                  <div class="d-none-lg text-white text-center h5 mb-3">{{ $user->display_name }}
                  </div>
                  <div class="d-none-lg">                    
                    <span><a class="profile" href="/profile/{{ $user->user_login }}" class="text-dark">Profile</a></span>
                    <span><a class="manage-account" href="/account" class="text-dark">Manage Account</a></span>
                    <span><a class="text-dark" href="{{ str_replace('&amp;', '&', wp_logout_url('news')) }}">Logout</a></span>
                  </div>         
                  <div class="logged-in-user">
                    <span>Hello, {{ $user->display_name }}</span>
                    <span><a class="manage-account" href="/account" class="text-dark">Manage Account</a></span>
                    <span><a class="profile" href="/profile/{{ $user->user_login }}" class="text-dark">Profile</a></span>
                    <span><a class="text-dark" href="{{ str_replace('&amp;', '&', wp_logout_url('news')) }}">Logout</a></span>
                  </div>
                @endif
              </div>
              @if(!is_user_logged_in())
                <span class="icon-holder mx-3 account-icon">
                  @far_icon('user')
                </span>
              @else
                <span class="avatar-holder mx-3 account-icon mt-n2">
                  @php                   
                   $avatar = uwp_get_usermeta( $userID, 'avatar_thumb', '' );
                   if(!empty($avatar)){
                    echo '<img data-placeholder-background="rgba(0, 0, 0, 0.2)" id="profile_avatar" src="/app/uploads/'.$avatar.'">';
                   }else{
                    echo '<img data-placeholder-background="rgba(0, 0, 0, 0.2)" id="profile_avatar" src="'. esc_url( get_avatar_url($userID) ) .'" />';
                   }
                  @endphp
                </span>
              @endif              
            </div>            
          </li>
        </ul>
        <div class="menu-toggle d-none-lg">
          <span>
            @fas_icon('bars')
          </span>
        </div>
        <div class="mobile-menu-bg d-none-lg">
          <span>
            @fas_icon('times')
          </span>
        </div>
      </nav>
      </div>      
  </div>
</header>
