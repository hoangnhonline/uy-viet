<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ShopSelectCondition extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shop_select_condition';	

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
                            'shop_id', 
                            'potential_id',
                            'cap_do_1480213548_id',
                            'tiem_nang1480213595_id',
                            'quy_mo1480440358_id',
                            'von1484471015_id'                          
                            ];
   
}
