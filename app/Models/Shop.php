<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Shop extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shop';	

	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                            'address', 
                            'street',
                            'location',
                            'phone', 
                            'ward_id',
                            'shop_name',
                            'namer', 
                            'type_id',
                            'user_id',
                            'add_time', 
                            'slug',
                            'status',
                            'condition_id', 
                            'full_address',
                            'district_id',
                            'province_id'
                            ];
   
}
