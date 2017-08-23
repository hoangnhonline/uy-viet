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
                            'updated_user',
                            'company_user_id',
                            'executive_user_id',
                            'operator_user_id',
                            'supervisor_user_id'
                            ];
    public function shops()
    {
        return $this->hasMany('App\Models\Shop', 'user_id');
    }

    public static function getUserIdChild($user_id, $user_type, $company_id){
        $userId = $user_type == 1 ?  [] : [$user_id];
        $userList = [];
        switch ($user_type) {
              case 2:
                $column = 'company_user_id';
                break;
              case 3:
                $column = 'operator_user_id';
                break;
              case 4:
                $column = 'executive_user_id';
                break;
              case 5:
                $column = 'supervisor_user_id';
                break;
              default:
                $column = null;
                break;
            }            
        $query = Account::where('type', '>', $user_type)->where('company_id', $company_id);
        if($column){
            $query->where($column, '=', $user_id);
        }
        $lists = $query->orderBy('type', 'asc')->get();
        if($lists->count() > 0){
            foreach($lists as $user){
                if($user->type == 6){
                    $userList['sale'][] = $user;
                }elseif($user->type == 5){
                    $userList['supervisor'][] = $user;
                }elseif($user->type == 4){
                    $userList['executive'][] = $user;
                }elseif($user->type == 3){
                    $userList['operator'][] = $user;
                }elseif($user->type == 2){
                    $userList['company'][] = $user;
                }
                $userId[] = $user->id;
            }
        }
        return ['userList' => $userList, 'userId' => $userId];

    }

}
