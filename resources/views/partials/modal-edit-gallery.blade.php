<input type="hidden" id="route_get_image_thumbnail" value="{{ route('get-image-thumbnail') }}">
	<input type="hidden" id="route_gallery" value="{{ route('gallery') }}">
	<input type="hidden" id="route_edit_fe" value="{{ route('edit-shop-fe') }}">
	
	<input type="hidden" id="default_image" value="{{ config('app.url').'/assets/images/no-image.png' }}">
	
<!-- Modal -->
<div class="modal fade" id="myModalShop" tabindex="-1" role="dialog" aria-labelledby="myModalShopLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalShopLabel">Edit shop</h4>
      </div>
      <div class="modal-body" id="content_edit_shop"> 
        
      </div>     
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModalGallery" tabindex="-1" role="dialog" aria-labelledby="myModalGalleryLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body" id="content_gallery">
        	
      </div>      
    </div>
  </div>
</div>