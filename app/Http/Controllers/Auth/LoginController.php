<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Handles authenticating users for the manager panel.
 * The controller uses a trait to conveniently provide its functionality to applications
 */
class LoginController extends Controller
{
	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/manager';

	public function username()
	{
		return 'name';
	}

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}
}
