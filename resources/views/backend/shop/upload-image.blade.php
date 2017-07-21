@if( !empty( $rsUpload ))
	@foreach( $rsUpload as $tmp)
	<div class="col-md-3" style="border:1px solid #CCC">
		<div style="height:150px;overflow-y:hidden">
          <img class="img-thumbnail" src="{{ Helper::showImageShop($tmp['image_path']) }}" style="width:100%">
        </div>
		<div class="checkbox">
	    <button class="btn btn-danger btn-sm remove-image" type="button" data-value="{{ $tmp['image_dir'] }}" ><span class="glyphicon glyphicon-trash"></span></button>
	  </div>
	</div>
	@endforeach
@endif