<?php

namespace App\Http\Controllers;

use App\Authors;
use App\Http\Resources\AuthorResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorsController extends Controller
{

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return AuthorResource::collection(Authors::paginate(25));

    }

    public function show($id)
    {
        try {
            $result =new AuthorResource(Authors::findOrFail($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 404, 'message' => 'Author not found']);
        }

        return $result;
    }
}
