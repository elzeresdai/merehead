<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\UserResourse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery\Exception;
use App\Http\Resources\BookResource;

use JWTAuth;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }


    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return BookResource::collection(Book::paginate(25));
    }


    /**
     * @param CreateBookRequest $request
     * @return BookResource|\Illuminate\Http\JsonResponse
     */
    public function store(CreateBookRequest $request)
    {
        try {

            if ($request->hasFile('img')) {
                $img = $request->file('img');
                $data = file_get_contents($img);
                $dataString = 'data:image/' . $img->extension() . ';base64,' . base64_encode($data);
            }

            $user = JWTAuth::parseToken()->authenticate();
            $response = Book::create([
                'user_id' => $user->id,
                'author_id' => $request->get('author_id'),
                'pages' => $request->get('pages'),
                'title' => $request->get('title'),
                'annotation' => $request->get('annotation'),
                'img' => isset($dataString) ? $dataString : null
            ]);

        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
        return new BookResource($response);

    }


    public function showByUser()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $result = new UserResourse($user);

        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }

        return $result;
    }

    public function update(UpdateBookRequest $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        try {
            $result = new BookResource(Book::findOrFail($id));

            if ($user->id != $result->user_id) {
                throw new Exception('You are not author of this book!', 403);
            }

            foreach ($request->all() as $key => $value) {
                if ($result->$key) {
                    $result->update([$key => $value]);
                }
            }

        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 404, 'message' => 'Book not found']);
        }

        return $result;
    }


    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();
        try {

            $result = Book::findOrFail($id);

            if ($user->id != $result->user_id) {
                return response()->json(['status' => 403, 'message' => 'You are not author of this book!']);
            }
            $result->delete();

        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 404, 'message' => 'Book not found']);
        }

        return response()->json(['status' => 'ok'], 200);
    }

}
