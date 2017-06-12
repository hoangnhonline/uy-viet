<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class User extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';	

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
                            'username', 
                            'password',
                            'fullname',
                            'email',
                            'type',
                            'phone',
                            'create_time',
                            'company_id',
                            'group_user_id'
                            ];
   
}
