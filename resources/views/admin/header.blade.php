<div class="container-fluid page-body-wrapper">
<nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('admin/assets/images/logo-mini.svg')}}" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav w-100">
              <li class="nav-item w-100">
                <form action="{{url('search_products')}}" method="GET">
                    @csrf
                    <input style="color: black;" type="text" name="search" placeholder="Search Products">
                    <input type="submit" value="Search" class="btn btn-outline-primary">
                  </form>
              </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown d-none d-lg-block">
                <a class="nav-link btn btn-success create-new-button" id="createbuttonDropdown" aria-expanded="false" href="{{url('/view_product')}}">+ Add New Products</a>
              </li>
            </ul>
              <li class="">
                    <x-app-layout>
                        <x-slot name="header">
                         </x-slot>
                     </x-app-layout>
                </li>
          </div>
        </nav>