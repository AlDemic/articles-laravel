<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//MODELS
use App\Models\User;

//SERVICE
use App\Services\UserService;

//REQUESTS
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\ChangeAvatarRequest;

class UserController extends BaseController
{
    //registration
    public function registration(UserRegistrationRequest $request, UserService $service) {
        //check user's form
        $validated = $request->validated();

        //registration logic
        $result = $service->registration($validated);

        //answer
        return redirect('/user/reg')->with('msg', $result);
    }

    //login
    public function login(UserLoginRequest $request, UserService $service) {
       //check user's form
        $validated = $request->validated();

        //login logic
        $result = $service->login($validated);
        
        //return user to main page if ok
        if($result) {
            return redirect('/')->with('msg', 'Successfully!');
        }

        //if wrong password
        return back()->with('error', 'Wrong password')->withInput();
    }

    //logout
    public function logout(Request $request, UserService $service) {
        $result = $service->logout($request); 

        //return user to main page if ok
        if($result) {
            return redirect('/')->with('msg', 'Successfully logout!');
        }

        //if wrong
        return back();
    }

    //promotion stats
    public function getPromotionStats(UserService $service) {
        //get stats and if render btn
        $resultArray = $service->getPromotionStats();

        return view('user.promotion', $resultArray);
    }

    //get promotion
    public function getPromotion(UserService $service) {
        //get promotion
        $result = $service->getPromotion();

        return back()->with('msg', $result);
    }

    //change avatar
    public function changeAvatar(ChangeAvatarRequest $request, UserService $service) {
        $validated = $request->validated();

        //main logic
        $result = $service->changeAvatar($validated);

        //inform user
        return back()->with('msg', $result);
    }
}
