<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserProvince extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_province';	

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
                            'user_id', 
                            'province_id'
                            ];
   
}
