<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 以下を追記することでProfile Modelが扱えるようになる
use App\Profile;

// 4-19以下を追記
use App\Background;
use Carbon\Carbon;

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

    // 4-18で追記
  public function edit(Request $request)
  {
    // Profile Modelからデータを取得する
    $profile = Profile::find($request->id);
    if (empty($profile)) {
        abort(404);
    }
    return view('admin.profile.edit', ['profile_form' => $profile]);
  }

  // 4-18で追記
  public function update(Request $request)
  {
    // Validationをかける
    $this->validate($request, Profile::$rules);
    // Profile Modelからデータを取得する
    $profile = Profile::find($request->id);
    // 送信されてきたフォームデータを格納する
    $profile_form = $request->all();
    unset($profile_form['_token']);

    // 該当するデータを上書きして保存する
    $profile->fill($profile_form)->save();

    // 4-19追記
    $background = new Background;
    $background->profile_id = $profile->id;
    $background->edited_at = Carbon::now();
    $background->save();

    return redirect('admin/profile');
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

  // 以下を追記(4-18)
  public function delete(Request $request)
  {
      // 該当するProfile Modelを取得
      $profile = Profile::find($request->id);
      // 削除する
      $profile->delete();
      return redirect('admin/profile/');
  }

}
