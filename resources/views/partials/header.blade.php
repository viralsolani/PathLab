<div class="page-header-inner">
    <div class="page-header-inner">
        <div class="navbar-header">
            <a href="{{ url('/') }}"
               class="navbar-brand">
                @lang('admin.site-title')
            </a>
        </div>
        <a href="javascript:;"
           class="menu-toggler responsive-toggler"
           data-toggle="collapse"
           data-target=".navbar-collapse">
        </a>

        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                @if (Auth::guest())
                  <li><a href="/login"><i class="fa fa-btn fa-sign-in"></i>Login</a></li>
                @else
                  <li class="navbar-text"><i class="fa fa-btn fa-user"></i>{{ Auth::user()->name }}</li>
                @endif
            </ul>
        </div>
    </div>
</div>