<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => [
            'create',
            'update',
            'delete'
        ]]);
    }

    public function showAll()
    {
        return response()->json(Article::all());
    }

    public function showOne($id)
    {
        return response()->json(Article::find($id));
    }

    public function showTags($id)
    {
        return response()->json(Article::find($id)->tags()->get());
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);

        try {
            /*$article = new Article();
            $article->title = $request->input('title');
            $article->content = $request->input('content');*/

            $user = $request->user();
            $article = $user->articles()->create([
                'title' => $request->input('title'),
                'content' => $request->input('content')
            ]);

            $tags = explode(',', $request->input('tags'));
            $article->tags()->attach($tags);

            $article->save();

            return response()->json($article, 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }        
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password_old' => 'required',
            'password' => 'required'
        ]);

        try {
            $user = User::findOrFail($id);
            if (Hash::check($request->input('password_old'), $user->password)) {
                try {
                    $hasher = app()->make('hash');
                    $password = $hasher->make($request->input('password'));

                    $user->update([
                        'username' => $request->input('username'),
                        'password' => $password
                    ]);
                    return response()->json($user, 200);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json(['message' => $e->getMessage()], 500);
                }
            } else {
                return response()->json(['message' => 'Incorrect username or password.'], 422);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        Article::findOrFail($id)->delete();
        return response('Deleted successfully', 200);
    }
}