<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Mockery\Exception;

use JWTAuth;

class BookController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = Book::paginate(10);
        if (!$response) {
            return response()->json(['error' => 'no_books'], 404);
        }
        return response()->json(['status' => 'ok', $response], 200);
    }


    /**
     * @param CreateBookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateBookRequest $request)
    {

        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $data = file_get_contents($img);
            $dataString = 'data:image/' . $img->extension() . ';base64,' . base64_encode($data);
        }

        try {
            $response = Book::create([
                'user_id' => $request->get('user_id'),
                'author_id' => $request->get('author_id'),
                'pages' => $request->get('pages'),
                'title' => $request->get('title'),
                'annotation' => $request->get('annotation'),
                'img' => isset($dataString) ? $dataString : null
            ]);

        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
        return response()->json(['status' => 'ok', $response], 200);

    }


    public function showByUser()
    {
        try {
            $userID = $this->user->id;
            $result = Book::where('user_id', $userID)->get();

            if (empty($result)) {
                return response()->json(['error' => 'no_books_added_by_this_user'], 404);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }

        return response()->json(['status' => 'ok', $result], 200);
    }

    public function update(UpdateBookRequest $request, $id)
    {
        try {
            $result = Book::findOrFail($id);

            if ($this->user->id != $result->user_id) {
                throw new Exception('You are not author of this book!', 403);
            }

            foreach ($request->all() as $key => $value) {
                if ($result->$key) {
                    $result->update([$key => $value]);
                }
            }

        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }

        return response()->json(['status' => 'ok', $result], 200);
    }


    public function destroy($id)
    {
        try {

            $result = Book::find($id);

            if ($this->user->id != $result->user_id) {
                throw new Exception('You are not author of this book!', 403);
            }
            $result->delete();

        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }

        return response()->json(['status' => 'ok'], 200);
    }

}
