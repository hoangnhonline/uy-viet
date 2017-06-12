<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ShopSize extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shop_size';	

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
                            'type', 
                            'icon_url',
                            'col_order',
                            'status'
                            ];
    
    public function shops()
    {
        return $this->hasMany('App\Models\ShopSelectCondition', 'von1484471015_id');
    }
}
