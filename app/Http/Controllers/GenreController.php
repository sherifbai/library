<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Illuminate\Http\JsonResponse;
use Throwable;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $genres = Genre::all();

            return response()->json([
                'data' => $genres,
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
     * @param GenreRequest $request
     * @return JsonResponse
     */
    public function store(GenreRequest $request): JsonResponse
    {
        try {
            $genre = Genre::query()->create($request->validated());

            return response()->json([
                'data' => $genre,
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
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $genre = Genre::query()->findOrFail($id);

            return response()->json([
                'data' => $genre,
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
     * @param GenreRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(GenreRequest $request, int $id): JsonResponse
    {
        try {
            $genre = Genre::query()->findOrFail($id);

            $genre->update($request->validated());

            return response()->json([
                'data' => $genre,
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
            $genre = Genre::query()->findOrFail($id);

            $genre->delete();

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
}
