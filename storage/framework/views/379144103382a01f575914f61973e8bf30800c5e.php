<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Uy Việt</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/bootstrap-select.css">
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-select.js"></script>
    <style type="text/css">
        .style1 {background-color:#ffffff;font-weight:bold;border:2px #006699 solid;}
    </style>
</head>
<body>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<nav class="navbar navbar-default" >
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Uy Việt</a>
        </div>
        <ul class="nav navbar-nav">
                <li class="active">
                    <select id="province" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Chọn tỉnh/thành phố">
                        <?php $__currentLoopData = $listProvince; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <option value="<?php echo e($province->id); ?>"><?php echo e($province->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </select>
                </li>
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
                <li><a href="#">Page 3</a></li>

        </ul>
    </div>
</nav>
<div class="nav-side-menu col-md-3" style="position: relative;">
    <div class="brand">Tìm kiếm</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">
            <li>
                <div class="input-group col-md-12">
                    <input type="text" class="form-control input-lg" placeholder="Nhập nội dung tìm kiếm" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </li>
            <li  data-toggle="collapse" data-target="#products" class="collapsed active">
                <a href="#"><i class="fa fa-gift fa-lg"></i> Danh mục cửa hàng <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="products">
                <?php $__currentLoopData = $shopType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <li class="active"><a href="#"><?php echo e($type->type); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </ul>


            <li data-toggle="collapse" data-target="#service" class="collapsed">
                <a href="#"><i class="fa fa-industry fa-lg"></i> Cấp độ <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="service">
                <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li class="active"><a href="#"><?php echo e($level->type); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </ul>


            <li data-toggle="collapse" data-target="#new" class="collapsed">
                <a href="#"><i class="fa fa-industry fa-lg"></i> Tiềm năng <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="new">
                <?php $__currentLoopData = $tiemnang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li class="active"><a href="#"><?php echo e($level->type); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </ul>

            <li>
                <a href="#">
                    <i class="fa fa-industry fa-lg"></i> Quy mô
                </a>
            </li>
        </ul>
    </div>
</div>
<div id="map" class="col-md-9"></div>
<script src="/js/home.js"></script>
<button type="button" id="button">test</button>
<div class="modal fade" id="modal-edit" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Shop</h4>
            </div>
            <div class="box box-warning">
                <form action="" class="form-horizontal" method="post">
                    <div class="box-body ">
                        <input type="hidden" name="id">
                        <input type="hidden" name="condition_id">
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="shop_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Namer</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="namer" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Status</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="status">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Full Address</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="full_address" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Phone</label>
                            <div class="col-sm-9">
                                <input type="tel" class="form-control" name="phone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="controller-label col-sm-2 text-right">Company</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="company_name" value="" readonly required>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                    <div class="box-footer">
                        <button type="button" class="col-xs-2 btn btn-default pull-right" data-dismiss="modal">Close</button>
                        <button type="submit" class="col-xs-2 btn btn-primary pull-right">Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAo3ykqb8xloOHX36rgPXSd1zBQilLqy98&callback=initMap"></script>
</body>