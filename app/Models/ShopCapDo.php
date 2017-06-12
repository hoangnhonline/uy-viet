<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ShopCapDo extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shop_cap_do_1480213548';	

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
                            'color',
                            'col_order',
                            'status'                         
                            ];
    public function shops()
    {
        return $this->hasMany('App\Models\ShopSelectCondition', 'cap_do_1480213548_id');
    }
}
