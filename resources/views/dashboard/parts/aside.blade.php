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
        


        </ul>
    </div>
</div>
