<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = array('id');
// 以下を追記
    public static $rules = array(
      'name' => 'required',
      'gender' => 'required',
      'hobby' => 'required',
      'introduction' => 'required',
    );

    // Profileモデルに関連付けを行う
    public function backgrounds()
    {
        return $this->hasMany('App\Background');

    }
}
