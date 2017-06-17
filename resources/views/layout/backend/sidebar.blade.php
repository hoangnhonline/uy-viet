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
      <li class="treeview {{ in_array(\Request::route()->getName(), ['shop.index', 'shop.create']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>Shop</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['shop.index', 'shop.edit']) ? "class=active" : "" }}><a href="{{ route('shop.index') }}"><i class="fa fa-circle-o"></i> Danh sách </a></li>
          <li {{ in_array(\Request::route()->getName(), ['shop.create']) ? "class=active" : "" }}><a href="{{ route('shop.create') }}"><i class="fa fa-circle-o"></i> Thêm shop</a></li>          
        </ul>
      </li>
      <li class="treeview {{ in_array(\Request::route()->getName(), ['shop-type.index', 'shop-type.create']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>Danh mục</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['shop-type.index', 'shop-type.edit']) ? "class=active" : "" }}><a href="{{ route('shop-type.index') }}"><i class="fa fa-circle-o"></i> Danh sách </a></li>
          <li {{ in_array(\Request::route()->getName(), ['shop-type.create']) ? "class=active" : "" }}><a href="{{ route('shop-type.create') }}"><i class="fa fa-circle-o"></i> Thêm mới</a></li>          
        </ul>
      </li>
      <?php 
      $condList = DB::table('select_condition')->orderBy('col_order')->get();
      ?>
      @foreach($condList as $cond)
      <li class="treeview {{ in_array(\Request::route()->getName(), ['condition.index', 'condition.create', 'condition.edit']) && $table_name = $cond->name ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>{{ $cond->display_name }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['condition.index', 'condition.edit']) ? "class=active" : "" }}><a href="{{ route('condition.index', ['table' => $cond->name]) }}"><i class="fa fa-circle-o"></i> Danh sách </a></li>
          <li {{ in_array(\Request::route()->getName(), ['condition.create']) ? "class=active" : "" }}><a href="{{ route('shop-von.create') }}"><i class="fa fa-circle-o"></i> Thêm mới</a></li>          
        </ul>
      </li>
      @endforeach
      <li class="treeview {{ in_array(\Request::route()->getName(), ['shop-tiem-nang.index', 'shop-tiem-nang.create']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>Tiềm năng</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['shop-tiem-nang.index', 'shop-tiem-nang.edit']) ? "class=active" : "" }}><a href="{{ route('shop-tiem-nang.index') }}"><i class="fa fa-circle-o"></i> Danh sách </a></li>
          <li {{ in_array(\Request::route()->getName(), ['shop-tiem-nang.create']) ? "class=active" : "" }}><a href="{{ route('shop-tiem-nang.create') }}"><i class="fa fa-circle-o"></i> Thêm mới</a></li>          
        </ul>
      </li>
      <li class="treeview {{ in_array(\Request::route()->getName(), ['shop-quy-mo.index', 'shop-quy-mo.create']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>Quy mô</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['shop-quy-mo.index', 'shop-quy-mo.edit']) ? "class=active" : "" }}><a href="{{ route('shop-quy-mo.index') }}"><i class="fa fa-circle-o"></i> Danh sách </a></li>
          <li {{ in_array(\Request::route()->getName(), ['shop-quy-mo.create']) ? "class=active" : "" }}><a href="{{ route('shop-quy-mo.create') }}"><i class="fa fa-circle-o"></i> Thêm mới</a></li>          
        </ul>
      </li>
      <li class="treeview {{ in_array(\Request::route()->getName(), ['shop-cap-do.index', 'shop-cap-do.create']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>Cấp độ</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array(\Request::route()->getName(), ['shop-cap-do.index', 'shop-cap-do.edit']) ? "class=active" : "" }}><a href="{{ route('shop-cap-do.index') }}"><i class="fa fa-circle-o"></i> Danh sách </a></li>
          <li {{ in_array(\Request::route()->getName(), ['shop-cap-do.create']) ? "class=active" : "" }}><a href="{{ route('shop-cap-do.create') }}"><i class="fa fa-circle-o"></i> Thêm mới</a></li>          
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