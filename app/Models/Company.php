<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Company extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'company';	

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
                            'company_name', 
                            'ftp_host',
                            'ftp_name',
                            'ftp_pass',
                            'phone',
                            'address',
                            'manager_id'
                            ];
   
}
