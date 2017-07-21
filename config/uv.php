<?php 
return [    
    'paging' => 100, // number rows for paging
    'uploads' => [
        'storage' => 'local',
        'webpath' => '/media/uploads'
    ],    

    'num_alert' => 10, // number rows for alert on top menu
    'upload_path' => public_path() . '/uploads/', // media_upload_path   
	'upload_thumbs_path' => public_path() . '/uploads/thumbs/', // media_upload_path    
    'upload_url' => $url . '/uploads/', // image path,
    'image_url' => config('app.url'),
    'upload_path_shop' => public_path() . '/', // media_upload_path   
    'upload_url_shop' => $url . '/', // image path,
    'max_size_upload' => 8000000    
];
?>
