<div class="main-menu menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
        {{-- @if (auth()->user()->type != 'famous' || auth()->user()->famous == null) --}}
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @can('read-package')
            <li class="nav-item  ">
                <a href="{{ route('packages.index') }}">
                    <i class="fa fa-th-large"></i>
                    <span class="menu-title">الباقات </span></a>
            </li> 
            
            @endcan
            @can('read-book')

            <li class="nav-item  ">
                <a href="{{ route('books.index') }}">
                    <i class="fa fa-book"></i>
                    <span class="menu-title">الكتب </span></a>
            </li>
            @endcan
            @can('read-invoice')

            <li class="nav-item  ">
                <a href="{{ route('invoices.index') }}">
                    <i class="fa fa-file-pdf-o"></i>
                    <span class="menu-title">  الفواتير    </span></a>
            </li>
            @endcan
            @can('destroy-claim')

            <li class="nav-item  ">
                <a href="{{ route('claims.index') }}">
                    <i class="fa fa-file-pdf-o"></i>
                    <span class="menu-title">  المطالبات    </span></a>
            </li>
            @endcan


            @can('read-community')
                
            <li class="nav-item  ">
                <a href="{{ route('communites.index') }}">
                    <i class="fa fa-users"></i>
                    <span class="menu-title">  المجتمعات    </span></a>
            </li>
            @endcan
            @can('read-discount')
            
            <li class="nav-item has-sub "><a href="#"><i class="fa fa-percent"></i><span class="menu-title"
                data-i18n="nav.menu_levels.main"> الخصومات</span></a>
        <ul class="menu-content" style="">
            <li class="is-shown"><a class="menu-item" href="{{ route('discountcode.index') }}"
                    data-i18n="nav.menu_levels.second_level"> اكواد الخصم </a>
            </li>
            <li class="is-shown"><a class="menu-item" href="{{ route('packageDiscount.index') }}"
                data-i18n="nav.menu_levels.second_level"> خصم الباقات  </a>
        </li>
       
           
            

        </ul>
    </li>
            
            @endcan
            
            @can('read-video')

            <li class="nav-item  ">
                <a href="{{ route('videos.index') }}">
                    <i class="fa fa-video-camera"></i>
                    <span class="menu-title">الجلسات </span></a>
            </li>
            @endcan
            @can('read-tool')
                
            <li class="nav-item  ">
                <a href="{{ route('tools.index') }}">
                    <i class="fa fa-pencil"></i>
                    <span class="menu-title">الادوات </span></a>
            </li>
            @endcan
            {{-- @if (@can('read-member') || @can('read-paid-member') || @can('read-unpaid-member') || @can('read-free-member') ) --}}
            @can(['read-member','read-paid-member','read-unpaid-member','read-free-member'])
            <li class="nav-item has-sub "><a href="#"><i class="la la-users"></i><span class="menu-title"
                        data-i18n="nav.menu_levels.main"> الاعضاء</span></a>
                <ul class="menu-content" style="">
                    @can('read-member')

                    <li class="is-shown"><a class="menu-item" href="{{ route('users.index') }}"
                            data-i18n="nav.menu_levels.second_level"> جميع الاعضاء</a>
                    </li>
                    @endcan
                    @can('read-paid-member')

                    <li class="is-shown"><a class="menu-item" href="{{ route('users_paid.index') }}"
                            data-i18n="nav.menu_levels.second_level"> العضويات المدفوعة  </a>
                    </li>
                    @endcan
                    @can('read-unpaid-member')

                    <li class="is-shown"><a class="menu-item" href="{{ route('un_paid_user.index') }}"
                            data-i18n="nav.menu_levels.second_level"> العضويات المجانية </a>
                    </li>
                    @endcan
                    @can('read-free-member')

                     <li class="is-shown"><a class="menu-item" href="{{ route('free_users.index') }}"
                            data-i18n="nav.menu_levels.second_level"> الاشتركات المجانية </a>
                    </li>
                    @endcan

                    

                </ul>
            </li>
            @endcan
            
            @can('setting')
            <li class="nav-item  ">
                <a href="{{ route('member_setting') }}">
                    <i class="fa fa-user"></i>
                    <span class="menu-title">  اعدادات التسويق بالعمولة   </span></a>
            </li>
            <li class="nav-item  ">
                <a href="{{ route('bank_info') }}">
                    <i class="fa fa-user"></i>
                    <span class="menu-title"> طلبات التسويق بالعمولة</span>
                    <span class="badge badge badge-info badge-pill float-right mr-2">{{ App\Models\BankInfo::where('status',2)->count() }}</span>
                </a>
            </li>
            <li class="nav-item  ">
                <a href="{{ route('all_withdrow_request') }}">
                    <i class="fa fa-user"></i>
                    <span class="menu-title"> طلبات سحب الارصدة </span>
                    <span class="badge badge badge-info badge-pill float-right mr-2">{{ App\Models\BlalnceRequest::where('status',2)->count() }}</span>
                </a>
            </li>

            
            @endcan
            @can('read-QuestionMember')

            <li class="nav-item  ">
                <a href="{{ route('quastions.index') }}">
                    <i class="fa fa-pencil"></i>
                    <span class="menu-title">أسئلة المستخدمين </span></a>
            </li>
            @endcan
            @can('read-MemberType')
            <li class="nav-item  ">
                <a href="{{ route('members.index') }}">
                    <i class="fa fa-user-circle"></i>
                    <span class="menu-title">انواع مستخدمي النظام </span></a>
            </li>
            @endcan
            @can('read-faqs')

            <li class="nav-item  ">
                <a href="{{ route('faqs.index') }}">
                    <i class="fa fa-pencil"></i>
                    <span class="menu-title">الاسئلة الشائعة </span></a>
            </li>
            @endcan
            @can('read-partner')

            <li class="nav-item  ">
                <a href="{{ route('partners.index') }}">
                    <i class="fa fa-user"></i>
                    <span class="menu-title">الشركاء </span></a>
            </li>
            @endcan
            @can('setting')
            <li class="nav-item  ">
                <a href="{{ route('admins.index') }}">
                    <i class="fa fa-user"></i>
                    <span class="menu-title"> الاداريين   </span></a>
            </li>
            <li class="nav-item  ">
                <a href="{{ route('roles.index') }}">
                    <i class="fa fa-user"></i>
                    <span class="menu-title"> الصلاحيات   </span></a>
            </li>
            <li class="nav-item  ">
                <a href="{{ route('tabs') }}">
                    <i class="fa fa-user"></i>
                    <span class="menu-title">اظهار او اخفاء التابات </span></a>
            </li>
            

            <li class="nav-item  ">
                <a href="{{ route('usersVideo.index') }}">
                    <i class="fa fa-user"></i>
                    <span class="menu-title"> طلبات تسجيل الجلسات </span></a>
            </li>
           

            <li class="nav-item  ">
                <a href="{{ route('video_setting') }}">
                    <i class="fa fa-user"></i>
                    <span class="menu-title"> الفيديو بالملف الشخصي </span></a>
            </li>
            {{-- <li class="nav-item  ">
                <a href="{{ route('meeting_setting') }}">
                    <i class="fa fa-user"></i>
                    <span class="menu-title"> اعدادات الجلسات </span></a>
            </li> --}}
            
            <li class="nav-item  ">
                <a href="{{ route('setting') }}">
                    <i class="fa fa-cog"></i>
                    <span class="menu-title"> بيانات الواجهة الرئيسية </span></a>
            </li>
            @endcan
            @can('read-ScopeMember')
                
            <li class="nav-item  ">
                <a href="{{ route('domians.index') }}">
                    <i class="fa fa-list"></i>
                    <span class="menu-title"> مجالات المستخدمين </span></a>
            </li>
            @endcan



            {{-- <li class="nav-item  ">
            <a href="{{ route('users.index') }}">
                <i class="fa fa-pencil"></i>
                <span class="menu-title">المستخدمين </span></a>
        </li>         --}}


        </ul>
    </div>
</div>
