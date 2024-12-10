<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Enums\MethodEnum;

class SettingController extends Controller
{
    public function edit(Request $request)
    {
        $userSetting = UserSetting::where('user_id', $request->user()->id)->first();
        return Inertia::render('Settings', [
            'currentMethod' => $userSetting->method ?? 'sms',
            'methods' => MethodEnum::getValues(),
        ]); 
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $userSetting = UserSetting::updateOrCreate(
            ['user_id' => $user->id],
            ['method' => $request->input('method')]
        );
    }
}