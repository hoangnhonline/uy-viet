<div class="info-box-wrap" style="padding-top:10px">
   <div class="col-sm-4" style="padding:0px;position:relative">                 
   	<img src="{{ $firstImage }}" class="img-responsive" style="width:100%">        
   	@if($have_image == 1)
   	<a class="btn btn-info btn-sm view-more" data-id="{{ $detail->shop_id }}" style="padding: 4px 10px; margin-top:2px;position:absolute;bottom:0;width:100%" data="{{ $detail->shop_id }}">More</a>
   	@endif
   </div>
   <div class="info-box-text-wrap col-sm-8">
      <h6 class="address" style="font-size:17px;color:#0e609e;margin-bottom:10px">{{ $detail->shop_name }}</h6>
      <div class="action-btns" style="line-height:25px;margin-bottom:20px">                              
      	<i class="fa fa-volume-control-phone"></i>                     
      	<strong>  {{ $detail->phone }}</strong> 
      	<br>
      	<i class="fa fa-user"></i>  <strong>{{ $detail->namer }}</strong>                                          	
      	<br><i class="fa fa-map-marker"></i>                     
      	  <strong>{{ $detail->full_address }}</strong><br>
      </div>
      @foreach($conditionList as $condition)
      <div class="form-group col-md-6" style="padding:0px">
        <label>{!! $condition->display_name !!}</label>
        <?php 
        $dataList = DB::table('shop_'. $condition->name)->where('status', 1)->get();
        $key = $condition->name."_id";
        ?>        
        @foreach($dataList as $data)
        <?php echo $detail->$key == $data->id ? ": <strong style=color:blue>".$data->type."</strong>" : ""; ?>              
        @endforeach
     </div>                     
      @endforeach     
      <div class="row" style="clear:both;text-align:right">
      <a data-toggle="modal" data-target="#modal-edit" class="pull-right edit-shop" data-id="{{ $detail->shop_id }}" title="Cập nhật thông tin">
        <i class="fa fa-pencil-square-o"></i>
      </a>
      <a href="{{ route( 'shop.edit-maps', [ 'id' => $detail->shop_id ]) }}" target="_blank" title="Chỉnh sửa địa điểm">
        <i class="fa fa-map-marker"></i>
      </a>&nbsp;&nbsp;&nbsp;
      </div>
   </div>
</div>