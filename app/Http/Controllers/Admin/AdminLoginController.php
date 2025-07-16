<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\ClientUser;

class AdminLoginController extends Controller
{
    public function Login(Request $request) {
        $title='Login';
        $requestArr = $request->all();
        try {

            $adminUser = Session::get('clientUser');
            if($adminUser) {
                return redirect(route('news'));
            }

            return view('admin.login.Login', compact('title', 'requestArr'));
        } catch (\Exception $e) {
            echo "something wrong   =>" . $e->getMessage() . "and get line is " . $e->getLine();
            die;
        }
    }

    public function LoginSuccess(Request $request) {

        try {
            $validator = \Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return redirect()->route('admin_login')->with('error', 'Please log in to the system again.');
            }

            $requestArr = $request->all();
            $clientUser = ClientUser::ValidateUser($requestArr);
            $request->session()->put('clientUser',$clientUser);

            /*$client_role = Role::getRole([['id', $clientUser['role_id']]]);

            $submenuAccess = [];
            foreach($client_role->ClientRoleAccess as $clientRoleAccess) {
                $submenuAccess[] = $clientRoleAccess->SubMenuAccess->menu_access_key;
            }
            $request->session()->put('capability', $submenuAccess);*/
            return redirect(route('news'));
        } catch (\Exception $e) {
            return redirect()->route('admin_login')->with('error', 'Please log in to the system again.');
        }
    }

    public function logout(Request $request) {
        $adminUser = Session::get('clientUser');
        if($adminUser) {
            Session::forget('clientUser');
        }
        return redirect(route('admin_login'));
    }
}
