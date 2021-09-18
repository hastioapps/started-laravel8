<aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-pills nav-sidebar flex-column mt-2" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-header">{{ __('label.manage_account') }}</li>
      <li class="nav-item">
        <a href="{{ route('profile') }}" class="nav-link">
          <i class="nav-icon fa fa-user"></i>
          <p>{{ Str::limit(Request::user()->name,20,'...') }}</p>
        </a>
      </li>
      @if(Request::user()->company_id!=null)
      <li class="nav-item">
        <a href="{{ route('company') }}" class="nav-link">
          <i class="nav-icon fas fa-flag"></i>
          <p>{{ __('label.company') }}</p>
        </a>
      </li>
      @endif
      <li class="nav-header">{{ __('label.navigation') }}</li>
    </ul>
</aside>