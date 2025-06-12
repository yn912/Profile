<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Profile;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        $this->validate($request, Profile::$rules);

        $profile = new Profile;
        $form = $request->all();

        // フォームから画像が送信されてきたら、保存して、$news->image_path に画像のパスを保存する
        if (isset($form['image'])) {
            $path = $request->file('image')->store('public/image');
            $profile->image_path = basename($path);
        } else {
            $profile->image_path = null;
        }

        // フォームから送信されてきた_tokenを削除する
        unset($form['_token']);
        // フォームから送信されてきたimageを削除する
        unset($form['image']);

        // データベースに保存する
        $profile->fill($form);
        $profile->save();
        // admin/profile/createにリダイレクトする
        return redirect('admin/profile/create');
    }

    public function edit(Request $request)
    {
        {
            // News Modelからデータを取得する
            $profile = Profile::find($request->id);
            if (empty($profile)) {
                abort(404);
            }
        return view('admin.profile.edit', ['profile_form' => $profile]);
      }
    }

    public function update(Request $request)
    {
        return redirect('admin/profile/edit');
    }

}