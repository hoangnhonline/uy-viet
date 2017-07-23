<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Hash, Auth;
use App\Models\Company;

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
			
			$view->with([				
				'loginType' => Auth::user()->type,
				'loginId'   => Auth::user()->id
			]);
			
		});
	}
	
}
