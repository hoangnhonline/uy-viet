<body>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<nav class="navbar navbar-default" >
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Uy Việt</a>
        </div>
        <?php if(session()->has('userId')): ?>
        <ul class="nav navbar-nav" style="margin-left: 16%">
            <li class="selectnav">
                <select id="province" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Chọn tỉnh/thành phố" onchange="getListDistrict()">
                    <?php $__currentLoopData = $listProvince; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <option value="<?php echo e($province->id); ?>"><?php echo e($province->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </select>
            </li>
            <li class="selectnav">
                <select id='district' name='district' class='selectpicker' data-live-search="true" data-live-search-style="begins" title="Chọn quận/huyện" onchange="getListWard()">
                    <option value='0'>Tất cả</option>
                </select>
            </li>
            <li class="selectnav">
                <select id='ward' name='standard' class='selectpicker' title="Chọn phường/xã" >
                    <option value='0'>Tất cả</option>
                </select>
            </li>
            <li class="selectnav">
                <button class="btn btn-info btn-lg" type="button" style="padding: 4px 12px;" id="search">
                    <i class="glyphicon glyphicon-search"></i>
                </button>
            </li>
        </ul>
        <div class="pull-right">
            <label style="font-weight: bold; margin-top: 12px">Xin chào , <?php echo e(session('fullname')); ?></label>
            <button class="btn btn-info btn-md" onclick="window.location.href='/logout'">Logout</button>
        </div>
        <?php else: ?>
        <a class="pull-right btn btn-info btn-md selectnav " href="#" data-toggle="modal" data-target="#login-modal">Login</a>
        <?php endif; ?>

    </div>
</nav>
<div class="col-md-3 nav-side-menu" style="position: relative;">
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
            <li  data-toggle="collapse" data-target="#check-list-box" class="collapsed active">
                <a href="#"><i class="fa fa-gift fa-lg"></i> Danh mục cửa hàng <span class="arrow"></span></a>
            </li>
                <ul id="check-list-box" class="list-group checked-list-box sub-menu collapse">
                    <?php $__currentLoopData = $shopType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <li class="list-group-item" value="<?php echo e($type->id); ?>"><?php echo e($type->type); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </ul>
            <ul class="sub-menu collapse" id="products">

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
                <?php $__currentLoopData = $tiemnang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tiemnang_item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li class="active"><a href="#"><?php echo e($tiemnang_item->type); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </ul>
            <li data-toggle="collapse" data-target="#quymo" class="collapsed">
                <a href="#"><i class="fa fa-industry fa-lg"></i> Quy Mô <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="quymo">
                <?php $__currentLoopData = $quymo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quymo_item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <li class="active"><a href="#"><?php echo e($quymo_item->type); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
</ul>
</ul>
</div>
</div>
<div id="map" class="col-md-9"></div>
<?php if(session()->has('userId')): ?>
<script>
var userId = <?php echo e(session('userId')); ?>;
</script>
<?php endif; ?>
<?php if(!empty($init_location)): ?>
    <script>
        var updatePosition = '<?php echo e($init_location->location); ?>';
        var updateShopId = <?php echo e($init_location->id); ?>;
    </script>
<?php else: ?>
    <script>
        var updatePosition = '15.961533, 107.856976';
    </script>
<?php endif; ?>
<script src="/js/home.js"></script>
<!-- EDIT INFO MODAL -->
<div class="modal fade" id="modal-edit" role="dialog">
<div class="modal-dialog modal-md">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Edit Shop</h4>
</div>
<div class="modal-body">
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
        <div class="form-group">
            <label class="controller-label col-sm-2 text-right">Cấp độ</label>
            <div class="col-sm-9">
                <select class="form-control" name="level">
                    <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <option value="<?php echo e($level->id); ?>"><?php echo e($level->type); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="controller-label col-sm-2 text-right">Quy Mô</label>
            <div class="col-sm-9">
                <select class="form-control" name="quymo">
                    <?php $__currentLoopData = $quymo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quymo_item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <option value="<?php echo e($quymo_item->id); ?>"><?php echo e($quymo_item->type); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="controller-label col-sm-2 text-right">Tiềm năng</label>
            <div class="col-sm-9">
                <select class="form-control" name="tiemnang">
                    <?php $__currentLoopData = $tiemnang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tiemnang_item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <option value="<?php echo e($tiemnang_item->id); ?>"><?php echo e($tiemnang_item->type); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </select>
            </div>
        </div>
    </div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" class="btn btn-info" onclick="editMarkerPosition()">Chỉnh marker</button>
<button type="button" class="btn btn-primary" onclick="editMarker()">Save</button>
</div>
</div>
</div>
</div>
<!-- END EDIT INFO MODAL -->

<!-- SIGNIN MODAL -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="loginmodal-container">
        <h1>Đăng nhập</h1><br>
            <form >
            <input type="text" name="userLog" placeholder="Username" required>
            <input type="password" name="passLog" placeholder="Password" required>
            <input type="button" name="login" class="login loginmodal-submit" value="Login" onclick="doLogin()">
                <p name="loginFail" style="color:red" class="alert-warning" hidden>Tên đăng nhập hoặc mật khẩu không đúng !</p>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>