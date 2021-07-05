<?php

namespace App\Http\Controllers;

use App\Libraries\LibOnApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $libOnApi;

    public function __construct(LibOnApi $libOnApi)
    {
        $this->libOnApi = $libOnApi;
    }

    public function loginView(Request $request)
    {
        if ($request->session()->has('authenticated')) {
            return redirect()->route('home.index');
        }
        return view('user.login');
    }

    public function login(Request $request)
    {
        // dd($request->all());
        try {
            $params = $request->all();

            $validatorArray = [
                'email' => 'required|email',
                'password' => 'required',
            ];
            $messages = [
                'email.required' => 'Thiếu địa chỉ email',
                'email.email' => 'Địa chỉ email không hợp lệ',
                'password.required' => 'Thiếu mật khẩu',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $data = $this->libOnApi->login($params);
            if (!empty($data->errors)) {
                return redirect()->back()->withInput()->withErrors($data->errors);
            }

            $request->session()->put('authenticated', $data->result->access_token);
            $request->session()->put('email', $data->result->email);
            $request->session()->put('fullname', $data->result->fullname);
            $request->session()->put('userId', $data->result->id);

            return redirect()->route('home.index')->with(['success' => 'Đăng nhập thành công']);
        } catch (\Throwable $th) {
            Log::error('[Login]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function signup(Request $request)
    {
        try {
            $params = $request->all();

            $validatorArray = [
                'fullname' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'phone' => 'required|numeric',
                'card' => 'required|numeric',
                'organ' => 'required',
                'career' => 'required',
                'code' => 'required|numeric',
            ];
            $messages = [
                'fullname.required' => 'Thiếu họ và tên',
                'email.required' => 'Thiếu địa chỉ email',
                'email.email' => 'Địa chỉ email không hợp lệ',
                'password.required' => 'Thiếu mật khẩu',
                'password.confirmed' => 'Mật khẩu và mật khẩu xác nhận không trùng nhau',
                'password_confirmation.required' => 'Thiếu mật khẩu xác nhận',
                'phone.required' => 'Thiếu số điện thoại',
                'phone.numeric' => 'Số điện thoại phải là số',
                'card.required' => 'Thiếu số CMT, CCCD',
                'card.numeric' => 'Số CMT, CCCD phải là số',
                'organ.required' => 'Thiếu lựa chọn tổ chức',
                'career.required' => 'Thiếu lựa chọn nghề nghiệp',
                'code.required' => 'Thiếu MSSV, MCB',
                'code.numeric' => 'MSSV, MCB phải là số',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $data = $this->libOnApi->signup($params);
            if (!empty($data->errors)) {
                return redirect()->back()->withInput()->withErrors($data->errors);
            }

            return redirect()->route('user.login')->with(['success' => 'Đăng ký thành công']);
        } catch (\Throwable $th) {
            Log::error('[Signup]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('home.index')->with(['success' => 'Đăng xuất thành công']);
    }

    public function signupView(Request $request)
    {
        if ($request->session()->has('authenticated')) {
            return redirect()->route('home.index');
        }
        $data = $this->libOnApi->getOrganAll();
        $organs = $data->result->organ;
        return view('user.signup', compact('organs'));
    }
}
