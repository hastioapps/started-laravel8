<aside class="control-sidebar control-sidebar-dark">
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ (is_file('storage/users-img/'.Request::user()->img))? asset('storage/users-img/'.Request::user()->img):url('assets/img/default.png')}}" class="img-circle elevation-2" style="height: 35px;width: 35px" alt="..."  style="background-color:#ffffff">
      </div>
      <div class="info">
        <a href="{{ route('profile') }}" class="d-block">{{ Str::limit(Request::user()->name,30,'...') }}</a>
      </div>
  </div>
  <ul class="nav nav-pills nav-sidebar flex-column"  data-widget="treeview" role="menu" data-accordion="false">
      @if(Request::user()->company_id!=null)
      <li class="nav-item">
        <a href="{{ route('company') }}" class="nav-link {{ (Request::is('company*'))?'active':'' }}">
          <i class="nav-icon fas fa-flag"></i>
          <p>{{ __('label.company') }}</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('branches') }}" class="nav-link {{ (Request::is('branches*'))?'active':'' }}">
          <i class="nav-icon fas fa-code-branch"></i>
          <p>{{ __('label.branches') }}</p>
        </a>
      </li>
      @endif
      <li class="nav-item">
        <a href="{{ route('roles') }}" class="nav-link {{ (Request::is('roles*'))?'active':'' }}">
          <i class="nav-icon fas fa-universal-access"></i>
          <p>{{ __('label.roles') }}</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('users') }}" class="nav-link {{ (Request::is('users*'))?'active':'' }}">
          <i class="nav-icon fas fa-users"></i>
          <p>{{ __('label.users') }}</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('logout') }}" class="nav-link">
          <i class="nav-icon fa fa-sign-out-alt"></i>
          <p>{{ __('auth.log_out') }}</p>
        </a>
      </li>
  </ul>
</aside>