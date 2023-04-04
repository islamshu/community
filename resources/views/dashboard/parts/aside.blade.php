<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        {{-- @if (auth()->user()->type != 'famous' || auth()->user()->famous == null) --}}
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item  ">
                <a href="{{ route('packages.index') }}">
                    <i class="fa fa-th-large"></i>
                    <span class="menu-title">الباقات </span></a>
            </li>
            <li class="nav-item  ">
              <a href="{{ route('books.index') }}">
                  <i class="fa fa-book"></i>
                  <span class="menu-title">الكتب </span></a>
          </li>
          <li class="nav-item  ">
            <a href="{{ route('videos.index') }}">
                <i class="fa fa-video-camera"></i>
                <span class="menu-title">الجلسات </span></a>
        </li>
        <li class="nav-item  ">
            <a href="{{ route('tools.index') }}">
                <i class="fa fa-pencil"></i>
                <span class="menu-title">الادوات </span></a>
        </li>
        <li class="nav-item  ">
            <a href="{{ route('quastions.index') }}">
                <i class="fa fa-pencil"></i>
                <span class="menu-title">أسئلة المستخدمين </span></a>
        </li>
        <li class="nav-item  ">
            <a href="{{ route('members.index') }}">
                <i class="fa fa-user-circle"></i>
                <span class="menu-title">انواع مستخدمي النظام  </span></a>
        </li>
        <li class="nav-item  ">
            <a href="{{ route('faqs.index') }}">
                <i class="fa fa-pencil"></i>
                <span class="menu-title">الاسئلة الشائعة </span></a>
        </li>
        <li class="nav-item  ">
            <a href="{{ route('partners.index') }}">
                <i class="fa fa-user"></i>
                <span class="menu-title">الشركاء </span></a>
        </li>
        <li class="nav-item  ">
            <a href="{{ route('tabs') }}">
                <i class="fa fa-user"></i>
                <span class="menu-title">اظهار او اخفاء التابات </span></a>
        </li>
        <li class="nav-item  ">
            <a href="{{ route('usersVideo.index') }}">
                <i class="fa fa-user"></i>
                <span class="menu-title"> طلبات تسجيل الجلسات   </span></a>
        </li>
        <li class="nav-item has-sub "><a href="#"><i class="la la-users"></i><span class="menu-title" data-i18n="nav.menu_levels.main"> الاعضاء</span></a>
            <ul class="menu-content" style="">
              <li class="is-shown"><a class="menu-item" href="{{ route('users.index') }}" data-i18n="nav.menu_levels.second_level"> جميع الاعضاء</a>
              </li>
              <li class="is-shown"><a class="menu-item" href="{{ route('users_paid.index') }}" data-i18n="nav.menu_levels.second_level"> جميع   الاعضاء الدافعين</a>
              </li>
              <li class="is-shown"><a class="menu-item" href="{{ route('un_paid_user.index') }}" data-i18n="nav.menu_levels.second_level"> جميع الاعضاء الغير دافعين</a>
              </li>
              
            </ul>
          </li>

        {{-- <li class="nav-item  ">
            <a href="{{ route('users.index') }}">
                <i class="fa fa-pencil"></i>
                <span class="menu-title">المستخدمين </span></a>
        </li>         --}}


        </ul>
    </div>
</div>
