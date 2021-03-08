<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://orionisbd.com/" class="simple-text logo-normal">
      {{ __('Orionis') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>

      <!-- First line describe the icons -->
      <!-- <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
          <i class="material-icons">content_paste</i>
          <p>Users</p>
        </a>
      </li> -->


      <li class="nav-item {{ ($activePage == 'add-product' || $activePage == 'category' || $activePage == 'sub-category') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#nav-product" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('img/laravel.svg') }}"></i>
          <p>{{ __('Products') }}
            <b class="caret"></b>
          </p>
        </a>
        <!-- <div class="collapse show" id="laravelExample"> -->
        <div class="collapse " id="nav-product">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'product-edit' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('productIndex.edit') }}">
                <span class="sidebar-mini"> PL </span>
                <span class="sidebar-normal">{{ __('Product List') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'add-product' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('addproduct.index') }}">
                <span class="sidebar-mini"> AP </span>
                <span class="sidebar-normal">{{ __('Add Product') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'category' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('category.index') }}">
                <span class="sidebar-mini"> CT </span>
                <span class="sidebar-normal"> {{ __('Category') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'sub-category' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('subcategory.index') }}">
                <span class="sidebar-mini"> SCT </span>
                <span class="sidebar-normal"> {{ __('Sub Category') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item{{ $activePage == 'pos' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('pos.index') }}">
          <i class="material-icons">content_paste</i>
          <p>Pos</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'client' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('client.index') }}">
          <i class="material-icons">bubble_chart</i>
          <p>{{ __('Clients') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'customer' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('customer.index') }}">
          <i class="material-icons">location_ons</i>
          <p>{{ __('Customers') }}</p>
        </a>
      </li>

      <li class="nav-item{{ $activePage == 'advance' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('advance.index') }}">
          <i class="material-icons">language</i>
          <p>{{ __('Advance Give/Take') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'payment' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('payment.index') }}">
          <i class="material-icons">payments</i>
          <p>{{ __('Payments') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'collection' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('collection.index') }}">
          <i class="material-icons">collections</i>
          <p>{{ __('Collections') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
        <a class="nav-link" href="#">
          <i class="material-icons">library_books</i>
          <p>{{ __('Expense') }}</p>
        </a>
      </li>
      <!-- <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="#">
          <i class="material-icons">language</i>
          <p>{{ __('Costs') }}</p>
        </a>
      </li> -->
      <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="#">
          <i class="material-icons">language</i>
          <p>{{ __('Commission') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'reports' ? ' active' : '' }}">
        <a class="nav-link" href="#">
          <i class="material-icons">content_paste</i>
          <p>Reports</p>
        </a>
      </li>

      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('img/laravel.svg') }}"></i>
          <p>{{ __('User Management') }}
            <b class="caret"></b>
          </p>
        </a>
        <!-- <div class="collapse show" id="laravelExample"> -->
        <div class="collapse " id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="#">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'users' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('users.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('Users') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>