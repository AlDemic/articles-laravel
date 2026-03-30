<?php

namespace App\Services;

use App\Models\User;
use App\Models\Rank;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function registration($validated) {
        //add user to db
        User::create([
            'nick' => $validated['nick'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);

        //send answer
        return 'Registration is successfully';
    }

    public function login($validated) {
        //check login
        if(Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password']
        ])) {
            //update user's session
            request()->session()->regenerate();

            return true;
        }

        //false if wrong
        return false;
    }

    public function logout(Request $request) {
        //clear user's session
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return true;
    }

    //check promotion and collect stats
    public function getPromotionStats() {
        //user
        $user = Auth::user();

        //take stats
        $approvedCounter = $user->articles()->articleStatus('approved')->count();
        $declinedCounter = $user->articles()->articleStatus('declined')->count();
        $onModCounter = $user->articles()->articleStatus('moderation')->count();

        $canPromote = false;

        $ranksArray = Rank::all();
        foreach($ranksArray as $rank) {
            if($approvedCounter >= $rank->promotion_need && $user->rank_id < $rank->id) {
                $canPromote = true;
            }
        }

        $msg = $canPromote ? 'You can be promoted!' : 'You can\'t take promotion.';
        
        return [
            'approvedCounter' => $approvedCounter,
            'declinedCounter' => $declinedCounter,
            'onModCounter' => $onModCounter,
            'canPromote' => $canPromote,
            'user' => $user,
            'msg' => $msg
        ];
    }

    //get promotion
    public function getPromotion() {
        //get user
        $user = Auth::user();

        //take stats
        $approvedCounter = $user->articles()->articleStatus('approved')->count();

        $ranksArray = Rank::all();
        foreach($ranksArray as $rank) {
            if($approvedCounter >= $rank->promotion_need && $user->rank_id < $rank->id) {
                $user->update(['rank_id' => $rank->id]);

                $rankTitle = $rank->title;
                return "You promoted to $rankTitle!";
            }
        }
    }

    //avatar change
    public function changeAvatar($validated) {
        //save pic and take url
        $avaUrl = $validated['avatar']->store('avatars', 'public');

        $user = Auth::user();

        //save old ava url
        $avaUrlOld = $user->avatar;

        //update by new
        $user->update(['avatar' => $avaUrl]);

        //delete old pic
        if($avaUrlOld) {
            Storage::disk('public')->delete($avaUrlOld);
        }

        //answer to user
        return 'Your avatar is changed!';
    }
}
