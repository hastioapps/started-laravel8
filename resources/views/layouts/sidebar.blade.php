<aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-pills nav-sidebar flex-column mt-2"  data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-header">{{ __('label.profile') }}</li>
      @if(Request::user()->company_id!=null)
      <li class="nav-item">
        <a href="{{ route('company') }}" class="nav-link {{ (Request::is('company*'))?'active':'' }}">
          <i class="nav-icon fas fa-flag"></i>
          <p>{{ __('label.company') }}</p>
        </a>
      </li>
      @endif
      <li class="nav-item">
        <a href="{{ route('profile') }}" class="nav-link {{ (Request::is('profile'))?'active':'' }}">
          <i class="nav-icon fa fa-user"></i>
          <p>{{ Str::limit(Request::user()->name,30,'...') }}</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('logout') }}" class="nav-link">
          <i class="nav-icon fa fa-sign-out-alt"></i>
          <p>{{ __('auth.log_out') }}</p>
        </a>
      </li>
      <li class="nav-header">{{ __('label.manage_account') }}</li>
      <li class="nav-item">
        <a href="{{ route('users') }}" class="nav-link {{ (Request::is('users*'))?'active':'' }}">
          <i class="nav-icon fas fa-users"></i>
          <p>{{ __('label.users') }}</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('roles') }}" class="nav-link {{ (Request::is('roles*'))?'active':'' }}">
          <i class="nav-icon fas fa-universal-access"></i>
          <p>{{ __('label.roles') }}</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('branches') }}" class="nav-link {{ (Request::is('branches*'))?'active':'' }}">
          <i class="nav-icon fas fa-code-branch"></i>
          <p>{{ __('label.branches') }}</p>
        </a>
      </li>
    </ul>
</aside>