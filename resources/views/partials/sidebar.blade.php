<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img src="{{ URL::asset('public/assets/images/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>Hi , {{ Auth::user()->fullname }}</p>
				<a href="{{ route('logout') }}" title="Logout" style="color:red"><i class="fa fa-circle text-danger"></i> Logout</a>
			</div>					
		</div><!-- /.user-panel -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="active treeview menu-open">
				<a href="javascript:void(0)" title="">
					<i class="fa fa-th"></i>
					<span>Danh mục cửa hàng</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu list-group checked-list-box check-list-box filter_type">
					<li class="active filter_all" data-filter="filter_type">
						<a href="javascript:void(0)" title="" value="" data-col="type_id">							
							<span><img src="{{ URL::asset('public/assets/images/all.png') }}" alt="Tất cả"></span>Tất cả
						</a>
					</li>
					@foreach($shopType as $type)		                        
                        <li class="active filter_type" data-filter="filter_type"><a href="javascript:void(0)" title="" value="{{ $type->id }}" data-col="type_id">
							<span><img src="{{ Helper::showImage($type->icon_url) }}" alt="{!! $type->type !!}"></span>
							{!! $type->type !!}
						</a></li>
                    @endforeach							
				</ul>
			</li><!-- /.treeview -->
			@foreach($conditionList as $condition)
			<li class="treeview">
				<a href="#" title="">
					<i class="fa fa-th"></i>
					<span>{!! $condition->display_name !!}</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<?php 
				$dataList = DB::table('shop_'. $condition->name)->where('status', 1)->get();
				?>
				<ul class="list-group checked-list-box treeview-menu treeview-border check-list-box filter_{{ $condition->name }}">
					<li class="active  filter_all" data-filter="filter_{{ $condition->name }}"><a href="#" title="" value="" data-col="{{ $condition->name }}_id" style="border-color: #41ADFF">Tất cả</a></li>
					@foreach($dataList as $data)
						<li class="active filter_{{ $condition->name }}" data-filter="filter_{{ $condition->name }}"><a href="#" title="" value="{{ $data->id }}" data-col="{{ $condition->name }}_id" style="border-color: {{ $data->color }};">{{ $data->type }}</a></li>
	                @endforeach
				</ul>
				
			</li><!-- /.treeview -->
			@endforeach		
			<li style="padding-left:10px;padding-top:20px">
				
				<label style="color:red">
					<input type="checkbox" id="check_show_label" {{ $settingArr['show_label'] == 1 ? "checked" : "" }}> Hiển thị tên shop
				</label>
				
			</li>			
		</ul>
	</section><!-- /.sidebar -->
</aside><!-- /main-sidebar -->