<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class GroupUser extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'group_user';	

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
                            'company_id', 
                            'manager_id',
                            'name'
                            ];
   
}
