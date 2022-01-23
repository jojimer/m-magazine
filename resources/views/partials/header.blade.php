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
              @if(!is_user_logged_in())
                <span class="icon-holder mx-3 account-icon">
                  @far_icon('user')
                </span>
              @else
                <span class="avatar-holder mx-3 account-icon">
                  @php
                   $userID = get_current_user_id();
                   $avatar = uwp_get_usermeta( $userID, 'avatar_thumb', '' );
                   if(!empty($avatar)){
                    echo '<img class="lozad" id="profile_avatar" data-src="/app/uploads/'.$avatar.'">';
                   }else{
                    echo '<img class="lozad" id="profile_avatar" data-src="'. esc_url( get_avatar_url($userID) ) .'" />';
                   }
                  @endphp
                </span>
              @endif
            </div>
            <div class="nav-account d-none">
              @if(!is_user_logged_in())
                <span class="xoo-el-login-tgr">Login</span>
                <span class="xoo-el-reg-tgr">Sign Up</span>
              @else
              @php $user = get_userdata($userID); @endphp
                <div class="logged-in-user">
                  <span>Hello, {{ $user->display_name }}</span>
                  <span><a class="manage-account" href="/account" class="text-dark">Manage Account</a></span>
                  <span><a class="profile" href="/profile/{{ $user->user_login }}" class="text-dark">Profile</a></span>
                  <span><a class="text-dark" href="{{ str_replace('&amp;', '&', wp_logout_url('news')) }}">Logout</a></span>
                </div>
              @endif
            </div>
          </li>
        </ul>
      </nav>
  </div>
</header>
