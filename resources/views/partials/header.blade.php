<header class="main-header">
	<a href="{{ route('home') }}" class="logo">
        <!-- mini logo -->
        <span class="logo-mini"><b>U</b>V</span>
        <!-- logo -->
        <span class="logo-lg"> <center><img src="{{ URL::asset('assets/images/logo.png') }}" width="100px"></center></span>
    </a><!-- /.logo -->
    <div id="search_icon">
    	<button type="button" class="btn btn-primary"><span class="fa fa-search"></span></button>
    </div><!-- /#search -->
    <nav class="navbar navbar-static-top">
    	<a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a><!-- /.sidebar-toggle -->
        <div class="row">
        	<form class="row form-select">
                <div class="col-sm-12 group-list-drop-down">
                	@if($loginType == 1)
                    <div class="form-group col-sm-2 list-drop-down">
                        <label class="col-sm-2 control-label" for="">Công Ty</label>
                        <div class="col-sm-10">
							<select id="company" name="company" class="selectpicker custom-select form-control" data-live-search="true">
								<option value="">Tất cả</option>
								@foreach($companyList as $com)
			                    <option value="{{ $com->id }}">{{ $com->company_name }}</option>
			                    @endforeach
							</select>
						</div>
                    </div>
                    @else
                    <input type="hidden" id="company" value="{{ Auth::user()->company_id }}">
                    @endif
                    <div class="form-group col-sm-3 list-drop-down">                            
                        <label class="col-sm-2 control-label" for="">Tỉnh / Thành Phố</label>
                        <div class="col-sm-10">
						<select id="province" class="selectpicker custom-select form-control"  title="Chọn tỉnh/thành" data-live-search="true" onchange="getListDistrict()">
							 @foreach($listProvince as $province)
		                    <option value="{{$province->id}}" {{ (isset($province_id) && $province_id == $province->id)  ? "selected"  : "" }}>{{$province->name}}</option>
		                    @endforeach
						</select>
					</div>
                    </div>
                    <div class="form-group col-sm-3 list-drop-down">
                        <label class="col-sm-2 control-label" for="">Quận / Huyện</label>
                        <div class="col-sm-10">
                            <select id='district' name='district' class="selectpicker custom-select form-control" data-live-search="true" title="Chọn quận/huyện" onchange="getListWard()">      
                            <option value='0'>Tất cả</option>                                 
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-3 list-drop-down">
                        <label class="col-sm-2 control-label" for="">Xã / Phường</label>
                        <div class="col-sm-10">
                            <select id='ward' name='standard' title="Chọn phường/xã" class="selectpicker custom-select form-control" data-live-search="true">
                                <option value='0'>Tất cả</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-3 list-drop-down">
                        <label class="col-sm-2 control-label" for="">Tên shop</label>
                        <div class="col-sm-10" id="ward">
                            <input type="text" name="name" value="" placeholder="Tên shop..." class="form-control">
                        </div>
                    </div><!-- /list-drop-down -->
                    <div class="form-group col-sm-1 btn-search-max">
                        <button type="button" style="width: 100%;" id="search"><span class="fa fa-search"></span></button>
                    </div>
                </div>
            </form>
        </div><!-- /.row -->
    </nav><!-- /nav -->
</header><!-- /header -->