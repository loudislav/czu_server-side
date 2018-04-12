<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TagController extends Controller
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
        return response()->json(Tag::all());
    }

    public function showOne($id)
    {
        return response()->json(Tag::find($id));
    }

    public function showArticles($id)
    {
        return response()->json(Tag::find($id)->articles()->get());
    }

    public function create(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        try {
            $tag = Tag::create($request->all());
            return response()->json($tag, 201);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }        
    }

    public function update($id, Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        $tag = Tag::findOrFail($id);
        $tag->update($request->all());
        return response()->json($tag, 200);
    }

    public function delete($id)
    {
        Tag::findOrFail($id)->delete();
        return response('Deleted successfully', 200);
    }
}