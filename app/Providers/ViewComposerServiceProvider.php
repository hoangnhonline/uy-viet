<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Hash, Auth;
use App\Models\Company;
use App\Models\Account;


class ViewComposerServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//Call function composerSidebar
		$this->composerMenu();	
		
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Composer the sidebar
	 */
	private function composerMenu()
	{
		
		view()->composer( '*' , function( $view ){		
			$userListId = $userIdChild = $userListLevel = [];
			$loginType = $loginId = 0;
			if(Auth::check()){
				$loginType = Auth::user()->type;
				$loginId = Auth::user()->id;
				$tmpUser = Account::getUserIdChild($loginId, $loginType);				
				$userListLevel = $tmpUser['userList'];
				$userIdChild = $tmpUser['userId'];
			}
			$tmp = Account::where('status', 1)->get();
			foreach($tmp as $user){
				$userListId[$user->id] = $user;
			}			

			$view->with(
				[		
				'userListLevel' => $userListLevel,		
				'loginType' => $loginType,
				'loginId'   => $loginId,
				'userListId' => $userListId,
				'userIdChild' => $userIdChild,
				
			]);
			
		});
	}
	
}
