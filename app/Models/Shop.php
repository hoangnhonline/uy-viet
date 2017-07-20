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
                            'province_id',
                            'company_id'
                            ];
    public function province()
    {
        return $this->belongsTo('App\Models\Province', 'province_id');
    }
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }
    public function district()
    {
        return $this->belongsTo('App\Models\District', 'district_id');
    }
    public function ward()
    {
        return $this->belongsTo('App\Models\Ward', 'ward_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function type()
    {
        return $this->belongsTo('App\Models\ShopType', 'type_id');
    }   
}
