<?php

namespace BtyBugHook\CmsLogin\Http\Controllers;

use App\Http\Controllers\Controller;
use Btybug\User\Repository\UserRepository;
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


        $http = new \GuzzleHttp\Client();

        $response = $http->post('http://forms.albumbugs.com/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => '9',
                'client_secret' => 'NZVkuE15N4v2MpGSzxOZsPp0xJoYohR7RhX56mnu',
                'redirect_uri' => url('bty-login/cms-callback'),
                'code' => $request->code,
            ],
        ]);
        $authResponse = json_decode((string)$response->getBody(), true);
        $response = $http->request('GET', 'http://forms.albumbugs.com/bty-api/user', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => $authResponse['token_type'].' ' . $authResponse['access_token'],
            ],
        ]);
        $auth=json_decode((string)$response->getBody(), true);
        $userData = $auth['user'];
        $authResponse = $request->get('authResponse');
        if (count($userData)) {
            $user = $userRepository->findBy('email', $userData['email']);
            if (!$user) {
                $password = '123123';
                \DB::table('users')->insert([
                    'username' => $userData['email'],
                    'email' => $userData['email'],
                    'f_name' => $userData['f_name'],
                    'l_name' => $userData['l_name'],
                    'password' => \Hash::make($password),
                    'status' => 'active',
                    'membership_id' => 1,
                    'remember_token' => str_random(60)
                ]);

                $user = $userRepository->findBy('email', $userData['email']);
            }


            if ($user) {
                $account = $accountRepository->updateOrCreate(['provider' => 'btybug',
                    'user_id' => $user->id,], [
                    'access_token' => $authResponse['access_token'],
                    'exp_date' => $authResponse['expires_in'],
                    'refresh_token' => $authResponse['refresh_token'],
                    'provider' => 'btybug',
                    'user_id' => $user->id,
                ]);
                \Auth::loginUsingId($user->id, true);
                return \Response::json(['error' => false, 'message' => 'User Logged IN', 'login' => $account->access_token]);
            }

        }


        return \Response::json(['error' => true, 'message' => 'Login Faild !!!']);
    }

    public function getSettings()
    {
        $data = json_decode(BBgetApiSettings('Cmslogin')->val, true);
        return view('apiuser::fbapi', compact('data'));
    }

    public function postSettings(Request $request)
    {
        BBeditApisettings('Cmslogin', $request->except('_token'));
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