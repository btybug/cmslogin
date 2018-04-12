<?php

namespace BtyBugHook\CmsLogin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PhpJsonParser;
use Btybug\User\Repository\UserRepository;
use BtyBugHook\ApiUser\Models\SocialAccount;
use BtyBugHook\ApiUser\Repository\SocialAccountRepository;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function getIndex()
    {
        return view('cmslogin::index', compact(''));
    }

    public function getCallback(Request $request, UserRepository $userRepository, SocialAccountRepository $accountRepository)
    {
        $userData = json_decode($request->get('userData'), true);
        $authResponse = $request->get('authResponse');
        if (count($userData)) {
            $user = $userRepository->findBy('email', $userData['email']);
            if (!$user) {
                $password = '123123';
                \DB::table('users')->insert([
                    'username' => $userData['email'],
                    'email' => $userData['email'],
                    'f_name' => $userData['first_name'],
                    'l_name' => $userData['last_name'],
                    'password' => \Hash::make($password),
                    'status' => 'active',
                    'membership_id' => 1,
                    'remember_token' => str_random(60)
                ]);

                $user = $userRepository->findBy('email', $userData['email']);
            }


            if ($user) {
                $account = $accountRepository->updateOrCreate(['provider' => 'facebook',
                    'user_id' => $user->id,], [
                    'access_token' => $authResponse['accessToken'],
                    'exp_date' => $authResponse['expiresIn'],
                    'refresh_token' => $authResponse['signedRequest'],
                    'provider' => 'facebook',
                    'user_id' => $user->id,
                ]);

                return \Response::json(['error' => false, 'message' => 'User Logged IN', 'login' => $account->access_token]);
            }

        }


        return \Response::json(['error' => true, 'message' => 'Login Faild !!!']);
    }

    public function getSettings()
    {
        $data = json_decode(BBgetApiSettings('FBlogin')->val, true);
        return view('apiuser::fbapi', compact('data'));
    }

    public function postSettings(Request $request)
    {
        BBeditApisettings('FBlogin', $request->except('_token'));
        return redirect()->back()->with('message', 'Saved');
    }

    public function getLogin($token, SocialAccountRepository $accountRepository)
    {
        $account = $accountRepository->findBy('access_token', $token);
        if ($account) {
            \Auth::loginUsingId($account->user_id, true);
            return redirect('/');
        }
//       dd($account,\Auth::loginUsingId($account->user_id,true));
        abort(404);
    }
}