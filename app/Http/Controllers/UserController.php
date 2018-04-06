<?php

namespace App\Http\Controllers;

use App\Mail\ProfileCreated;
use Illuminate\Http\Request;
use App\User;
use App\Skills;
use App\Country;
use App\City;
use App\UserInfo;
use Illuminate\Support\Facades\Mail;


class UserController extends Controller
{
    public function edit($id)
    {
        $cities = [];
        $user = User::whereId($id)->firstOrFail();
        $cityes = City::all();
        $userInfo = UserInfo::where('user_id',$id)->first();
        foreach ($cityes as $citye) {
            $cities[$citye->id] = $citye->city_name .' '.$citye->country->name;
        }


        return view('user.edit',
            [
                'user' => $user,
                'cites' => $cities,
                'userInfo' => $userInfo,
            ]);
    }

    public function skillsAjax()
    {
        return Skills::where('name', 'LIKE', '%'.request('q').'%')->paginate(10);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'patronomyc' => 'required|string',
            'cities' => 'required'
        ]);
        $user = User::whereId($id)->firstOrFail();
        if(UserInfo::where('user_id', $id)->first() != NULL){
           $model = UserInfo::where('user_id', $id)->first();
           $model->firsname = $request->firstname;
           $model->lastname = $request->lastname;
           $model->patronomyc = $request->patronomyc;
           $model->city_id = $request->cities;

        } else {
            $userInfo = new UserInfo(['firstname' => $request->firstname, 'lastname' => $request->lastname, 'patronomyc' => $request->patronomyc]);
            $userInfo->city_id = $request->cities;
            $user->userInfo()->save($userInfo);
            Mail::to($user)->send(new ProfileCreated($user));
        }
        $skillsId = [];
        foreach ($request->skill_id as $item) {
            if(Skills::where('id',$item)->first()){
                $skill = Skills::where('id',$item)->first();
                $skillsId[] = $skill->id;
                continue;
            }
            $skill = new Skills();
            $skill->name = $item;
            $skill->save();
            $skillsId[] = $skill->id;
        }
        $user->skill()->sync($skillsId);
        $request->session()->flash('message', 'Ваш профиль был обновлен!');
        return redirect()->back();
    }
}
