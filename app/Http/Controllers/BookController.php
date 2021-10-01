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
            $books = Book::with('genres')->get()->all();

            return response()->json([
                'data' => $books,
                'success' => true
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
     * Store a newly created resource in storage.
     *
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function store(BookRequest $request): JsonResponse
    {
        try {
            $book = Book::query()->create($request->validated());

            $genresIds = $request->input('genre');

            $book->genres()->attach($genresIds);

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
            $book = Book::query()->findOrFail($id);

            return response()->json([
                'data' => $book,
                'success' => true
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
     * Update the specified resource in storage.
     *
     * @param BookRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(BookRequest $request, int $id): JsonResponse
    {
        try {
            $book = Book::query()->findOrFail($id);

            if (!$book) {
                return response()->json([
                    'data' => null,
                    'success' => false,
                    'message' => 'Book doesnt found'
                ]);
            }

            $book->update($request->validated());

            return response()->json([
                'data' => $book,
                'success' => true
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $book = Book::query()->findOrFail($id);

            if (!$book) {
                return response()->json([
                    'data' => null,
                    'success' => false,
                    'message' => 'Book doesnt found'
                ]);
            }

            $book->delete();

            return response()->json([
                'data' => null,
                'success' => true
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
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = Book::with('genres');

        if ($request->input('name')) {
            $query->where('name', 'LIKE', $request->input('name'));
        }

        if ($request->input('author')) {
            $query->where('author', 'LIKE', $request->input('author'));
        }

        if ($request->input('publisher')) {
            $query->where('publisher', 'LIKE', $request->input('publisher'));
        }

        if ($request->input('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('name', 'like', $request->input('genre'));
            }
            );
        }

        $result = $query->paginate();

        return response()->json([
            'data' => $result,
            'success' => true,
        ]);
    }
}
