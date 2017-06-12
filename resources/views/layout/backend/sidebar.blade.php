<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ URL::asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->fullname }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>      
      
      @if(Auth::user()->type == 1)
      <li class="treeview {{ in_array(\Request::route()->getName(), ['shop-von.index', 'shop-von.create']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>Trang</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['shop-von.index', 'shop-von.edit']) ? "class=active" : "" }}><a href="{{ route('shop-von.index') }}"><i class="fa fa-circle-o"></i> Trang</a></li>
          <li {{ in_array(\Request::route()->getName(), ['shop-von.create']) ? "class=active" : "" }}><a href="{{ route('shop-von.create') }}"><i class="fa fa-circle-o"></i> Thêm trang</a></li>          
        </ul>
      </li>
      @endif
      
      @if(Auth::user()->role > 1)
      <li class="treeview {{ in_array(\Request::route()->getName(), ['account.index', 'info-seo.index', 'settings.index', 'settings.noti']) || (in_array(\Request::route()->getName(), ['custom-link.edit', 'custom-link.index', 'custom-link.create']) && isset($block_id) && $block_id == 2 ) ? 'active' : '' }}">
        <a href="#">
          <i class="fa  fa-gears"></i>
          <span>Cài đặt</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">          
          <li {{ \Request::route()->getName() == "account.index" ? "class=active" : "" }}><a href="{{ route('account.index') }}"><i class="fa fa-circle-o"></i> Users</a></li>          
        </ul>
      </li>
      @endif
      <!--<li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>-->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<style type="text/css">
  .skin-blue .sidebar-menu>li>.treeview-menu{
    padding-left: 15px !important;
  }
</style>