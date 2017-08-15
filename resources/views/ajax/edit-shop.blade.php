 <section class="content">      
      <form role="form" method="POST" action="{{ route('shop.update') }}" id="formData">
         <input type="hidden" name="id" value="{{ $detail->id }}">
         <div class="row">
            <!-- left column -->
            <div class="col-md-12">
               <!-- general form elements -->
               <div class="box box-primary">                 
                  <!-- /.box-header -->               
                  {!! csrf_field() !!}
                  <div class="box-body">
                     @if (count($errors) > 0)
                     <div class="alert alert-danger">
                        <ul>
                           @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                     </div>
                     @endif            
                     <div class="form-group col-md-6">
                        <label>Company <span class="red-star">*</span></label>
                        <select class="form-control" name="company_id" id="company_id">
                           <option value="" >--Chọn--</option>
                           @foreach($companyList as $com)
                           <option value="{{ $com->id }}" {{ $com->id == $detail->company_id ? "selected" : "" }}>{{ $com->company_name }}</option>
                           @endforeach
                        </select>
                     </div>
                     <!-- text input -->
                     <div class="form-group col-md-6">
                        <label>Loại shop <span class="red-star">*</span></label>
                        <select class="form-control" name=" type_id" id=" type_id">
                           <option value="" >--Chọn--</option>
                           @foreach($shopTypeList as $com)
                           <option value="{{ $com->id }}" {{ $com->id == $detail->type_id ? "selected" : "" }}>{{ $com->type }}</option>
                           @endforeach
                        </select>
                     </div>
                     <!-- text input -->
                     <div class="form-group col-md-4">
                        <label> Tỉnh/Thành <span class="red-star">*</span></label>
                        <select class="form-control" name="province_id" id="province_id">
                           <option value="" >--Chọn--</option>
                           @foreach($provinceList as $province)
                           <option value="{{$province->id}}" {{ $province->id == $detail->province_id ? "selected" : "" }}>{{$province->name}}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group col-md-4">
                        <label> Quận/Huyện <span class="red-star">*</span></label>
                        <select class="form-control" name="district_id" id="district_id">
                           <option value="" >--Chọn--</option>
                           @foreach($districtList as $district)
                           <option value="{{$district->id}}" {{ $district->id == $detail->district_id ? "selected" : "" }}>{{$district->name}}</option>
                           @endforeach
                        </select>
                     </div>
                     <input type="hidden" name="update_maps" value="0">
                     <div class="form-group col-md-4">
                        <label> Phường/Xã <span class="red-star">*</span></label>
                        <select class="form-control" name="ward_id" id="ward_id">
                           <option value="" >--Chọn--</option>
                           @foreach($wardList as $ward)
                           <option value="{{$ward->id}}" {{ $ward->id == $detail->ward_id ? "selected" : "" }}>{{$ward->name}}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="form-group col-md-12">
                        <label>Tên shop <span class="red-star">*</span></label>
                        <input type="text" class="form-control" name="shop_name" id="shop_name" value="{{ old('shop_name', $detail->shop_name) }}">
                     </div>
                     <div class="form-group col-md-6">
                        <label>Địa chỉ <span class="red-star">*</span></label>
                        <input type="text" class="form-control" name="address" id="address" value="{{ old('address', $detail->address) }}">
                     </div>
                     <div class="form-group col-md-6">
                        <label>Đường phố </label>
                        <input type="text" class="form-control" name="street" id="street"  value="{{ old('street', $detail->street) }}">
                     </div>
                     <div class="form-group col-md-12">                        
                        <label>Địa chỉ đầy đủ </label>
                        <?php $full_address = $detail->address. ", ". $detail->street. ", ". $detail->ward->name. ", ". $detail->district->name. ", ". $detail->province->name ; ?>
                        <input type="text" class="form-control" name="full_address" id="full_address" value="{{ $full_address }}" readonly="readonly">
                     </div>
                     <div class="form-group col-md-6">
                        <label>Người liên hệ </label>
                        <input type="text" class="form-control" name="namer" id="namer"  value="{{ old('namer', $detail->namer) }}">
                     </div>
                     <div class="form-group col-md-6">
                        <label>Số điện thoại </label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $detail->phone) }}">
                     </div>
                     <div class="form-group col-md-12">
                        <label>Trạng thái</label>
                        <select class="form-control" name="status" id="status">                                      
                        <option value="1" {{ old('status', $detail->status) == 1 ? "selected" : "" }}>Hiện </option>                  
                        <option value="2" {{ old('status', $detail->status) == 2 ? "selected" : "" }}>Ẩn</option>                  
                        </select>
                     </div>
                     @foreach($conditionList as $condition)
                      <div class="form-group col-md-6">
                        <label>{!! $condition->display_name !!}</label>
                        <?php 
                        $dataList = DB::table('shop_'. $condition->name)->where('status', 1)->get();
                        $key = $condition->name."_id";
                        ?>
                        <select class="form-control" name="cond[{{ $key }}]" id="{{ $condition->name }}_id">                                      
                        @foreach($dataList as $data)
                        <option value="{{ $data->id }}" {{ old('cond[$key]', $detail->$key ) == $data->id ? "selected" : "" }}>{{ $data->type }} </option>                  
                        @endforeach
                        </select>
                     </div>                     
                      @endforeach                       
                  </div>
                  <?php 
                     $tmp = explode(",",$detail->location);
                     $latt = $tmp[0] ? $tmp[0] : '10.7860332';
                     $longt = $tmp[1] ? $tmp[1] : '106.6950147';      
                     ?>
                  <input type="hidden" name="latt" id="latt" value="{{ $latt }}">
                  <input type="hidden" name="longt" id="longt" value="{{ $longt }}">
                  <input type="hidden" name="curr_url" id="current_url_update" value="">
                  <div class="box-footer " style="text-align:right">
                     <div class="col-md-12">                        
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
               <!-- /.box -->     
            </div>          
         </div>
         <!--/.col (left) -->      
</div>
</form>
<!-- /.row -->
</section>
<style type="text/css">
   span.red-star{
      color:red;
   }

</style>