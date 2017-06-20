<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Account extends Model  {

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
    public $timestamps = true;
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
                            'group_user_id',
                            'created_user',
                            'updated_user'
                            ];
    public function shops()
    {
        return $this->hasMany('App\Models\Shop', 'user_id');
    }
}
