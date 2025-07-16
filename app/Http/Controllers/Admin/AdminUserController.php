<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\library\Lib;
use App\Models\Admin\ClientUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminUserController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!$request->session()->get('clientUser')) {
                return redirect()->route('admin_logout')->with('error', 'Ваша сессия недействительна. Пожалуйста, войдите в систему еще раз.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'title';
        $condition = [];
        $userList = ClientUser::listUser($condition,\Config::get('constants.admin_pagination'));
        return view('admin.admin.index', compact('title', 'userList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create User';
        try {
            $roleList = Role::roleArr([['status','Active']]);
            $countryList = Country::ListData();
            return view('admin.admin.create', compact('title', 'roleList', 'countryList'));
        } catch (\Exception $e) {
            echo "something wrong   =>" . $e->getMessage() . "and get line is " . $e->getLine();
            die;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
                'name' => 'required',
                'image' => 'required|image'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $requestArr = $request->all();
            $insertId = ClientUser::storeUser($requestArr);
            return redirect(route('admin'))->with('success', 'Админ создает успешный!!!');
        } catch (\Exception $e) {
            echo "something wrong   =>" . $e->getMessage() . "and get line is " . $e->getLine();
            die;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'User Details';
        $condition = [['id',$id]];
        $user = ClientUser::getUser($condition);
        return view('admin.admin.show', compact('title', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit User';
        $condition = [['id',$id]];
        $user = ClientUser::getUser($condition);
        $roleList = Role::roleArr([['status','Active']]);
        $countryList = Country::ListData();
        $stateList = State::ListData([['country_id', $user['address_country']]]);
        $cityList = City::ListData([['country_id', $user['address_country']],['state_id', $user['address_state']]]);
        return view('admin.admin.edit', compact('title', 'user', 'roleList', 'countryList', 'stateList', 'cityList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $requestArr = $request->all();
        $insertId = ClientUser::updateUser($requestArr);
        return redirect(route('admin'))->with('success', 'Обновление администратора прошло успешно!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ClientUser::deleteUser($id);
        return redirect(route('admin'))->with('success', 'Отключение администратора прошло успешно!!!');
    }

    public function resetPassword(Request $request)
    {
        $title = 'Reset Password';
        $adminUser = Session::get('clientUser');
        return view('admin.admin.resetPassword', compact('title', 'adminUser'));
    }

    public function resetPasswordSuccess(Request $request)
    {
        $requestArr = $request->all();
        $adminUser = Session::get('clientUser');
        ClientUser::resetPassword($requestArr);

        $details = [
            'title' => $adminUser->name . ', Подтверждение сброса пароля',
            'username' => $adminUser->email,
            'password' => $requestArr['password'],
            'subject' => $adminUser->name . ', Подтверждение сброса пароля'
        ];

        Mail::to($adminUser->email)->send(new \App\Mail\MyTestMail($details));

        return redirect(route('admin_logout'));
    }

    public function forgotPassword(Request $request)
    {
        $title = 'Forgot Password';
        return view('admin.login.forgot_password', compact('title'));
    }

    public function forgotPasswordSuccess(Request $request)
    {
        $requestArr = $request->all();

        $adminUser = ClientUser::getUser([['email',$requestArr['email']]]);

        $requestArr['client_user_id'] = $adminUser->id;
        if(!$requestArr['password']) {
            $requestArr['password'] = Lib::getToken(8);
        }

        ClientUser::resetPassword($requestArr);

        $details = [
            'title' => $adminUser->name,
            'username' => $adminUser->email,
            'password' => $requestArr['password'],
            'subject' => $adminUser->name
        ];

        Mail::to($adminUser->email)->send(new \App\Mail\MyTestMail($details));

        return redirect(route('admin_login'));
    }
}
