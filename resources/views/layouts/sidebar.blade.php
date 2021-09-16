<aside class="control-sidebar control-sidebar-dark">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-header">Menu</li>
      <li class="nav-item">
        <a href="{{ route('profile') }}" class="nav-link">
          <i class="nav-icon fa fa-user"></i>
          <p>{{ Request::user()->name }}</p>
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
      <li class="nav-header">{{ __('label.your_apps') }}</li>
    </ul>
</aside>