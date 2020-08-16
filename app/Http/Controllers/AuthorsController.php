<?php

namespace App\Http\Controllers;

use App\Authors;
use Mockery\Exception;

class AuthorsController extends Controller
{


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $response = Authors::paginate(10);
        } catch (Exception $e) {
            return response()->json(['error' => 'no_authors_detected'], $e->getCode());
        }

        return response()->json([$response],200);

    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $response = Authors::with('books')->where('id', $id)->first();

        if (!$response) {
            return response()->json(['error' => 'no_such_author'],404);
        }
        return response()->json([$response],200);
    }

}
