<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['verified', 'can:manage_tag']);
    }

    public function index()
    {
        $tag_count = Tag::count();
        $tags = Tag::get();

        return view('tags.index', ['tags' => $tags, 'count' => $tag_count]);
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);

        return json_encode(['status'=>'success', 'html'=>view('tags.partials.edit-row', ['tag'=>$tag])->render()]);
    }

    public function new()
    {
        $inputs = request()->all();
        $validator = Validator::make($inputs, $this->validationRules());

        if ($validator->fails()) {
            return json_encode(['status' => 'failed', 'errors' => $validator->errors()]);
        }

        $tag = Tag::create($inputs);

        return json_encode(['status' => 'success', 'html' => '<li class="list-group-item" id="tag-row-'.$tag->id.'">'.view('tags.partials.detail-row', ['tag' => $tag])->render().'</li>', 'count' => Tag::count()]);
    }

    public function update($id)
    {
        $tag = Tag::findOrFail($id);

        $inputs = request()->all();
        $validator = Validator::make($inputs, $this->validationRules());

        if ($validator->fails()) {
            return json_encode(['status' => 'failed', 'errors' => $validator->errors()]);
        }

        $tag->update($inputs);

        return json_encode(['status' => 'success', 'html' => view('tags.partials.detail-row', ['tag' => $tag])->render()]);
    }

    public function delete($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return json_encode(['status' => 'success', 'count' => Tag::count()]);
    }

    public function sync()
    {
        $inputs = request()->all();
        $validator = Validator::make($inputs, [
            'userId' => 'required',
            'tags' => 'array'
        ]);

        if ($validator->fails()) {
            return json_encode(['status' => 'failed']);
        }

        $user = \App\Models\User::findOrFail($inputs['userId']);

        $user->tags()->sync($inputs['tags'] ?? []);

        return json_encode(['status' => 'success', 'user' => $user->id, 'html' => view('tags.partials.badge-row', ['tags' => $user->tags])->render(), 'tags' => implode('|',$user->tags()->pluck('id')->toArray())]);
    }

    private function validationRules()
    {
        $rules = [
            'label' => 'required|string|max:30',
            'description' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'is_partner' => 'required|boolean',
        ];

        return $rules;
    }
}