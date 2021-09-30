<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json();
        } catch (Throwable $exception) {
            return response()->json();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function store(BookRequest $request): JsonResponse
    {
        try {
            $book = new Book();

            $book->author = $request->input('author');
            $book->genre = $request->input('genre');
            $book->publisher = $request->input('publisher');

            $book->save();

            return response()->json([
                'data' => $book,
                'success' => true,
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'data' => null,
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            return response()->json();
        } catch (Throwable $exception) {
            return response()->json();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            return response()->json();
        } catch (Throwable $exception) {
            return response()->json();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            return response()->json();
        } catch (Throwable $exception) {
            return response()->json();
        }
    }
}
