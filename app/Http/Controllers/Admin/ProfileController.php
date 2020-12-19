<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;

class ProfileController extends Controller
{
  public function add()
  {
    return view('admin.profile.create');
  }

  public function create(Request $request)
  {
     // Varidationを行う
     $this->validate($request, Profile::$rules);

     $profile = new Profile;
     $form = $request->all();

    // データベースに保存する
    $profile->fill($form);
    $profile->save();

     return redirect('admin/profile/create');
  }

  public function edit()
  {
    return view('admin.profile.edit');
  }

  public function update()
  {
    return redirect('admin/profile/edit');
  }

  // 4-17にて追記
  public function index(Request $request)
  {
    $cond_name = $request->cond_name;
    if ($cond_name != '') {
        // 検索されたら検索結果を取得する
        $posts = Profile::where('name', $cond_name)->get();
    } else {
        // それ以外はすべてのプロフィールを取得する
        $posts = Profile::all();
    }
    return view('admin.profile.index', ['posts' => $posts, 'cond_name' => $cond_name]);
  }

}
