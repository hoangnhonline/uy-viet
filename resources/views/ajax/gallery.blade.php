<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <?php $i = 0; ?>
    @foreach($arr as $img)

    <li data-target="#carousel-example-generic" data-slide-to="{{ $i }}" @if($i==0) class="active" @endif></li>
    <?php $i ++; ?>
    @endforeach
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php $i = 0; ?>
    @foreach($arr as $img)
    <div class="item @if($i==0) active @endif">
      <img src="{{ $img }}" style="max-width:600px">      
    </div>   
    <?php $i ++; ?>
    @endforeach
  </div>
  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<style type="text/css">
  .modal-header {
      padding: 6px; 
      padding-right: 15px;
      padding-bottom: 0px;
      border-bottom: none;
  }
  .carousel-control.right, .carousel-control.left{
    background-image: none;
  }
</style>