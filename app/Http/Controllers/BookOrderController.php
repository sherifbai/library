<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class BookOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $orders = BookOrder::with('books')->where('user_id', '=', auth()->user()->id)->get();

            return response()->json([
                'data' => $orders,
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $book = Book::query()->findOrFail($request->input('book_id'));

            $isTaken = BookOrder::query()->where('book_id', '=', $book->id)->first();

            if (!empty($isTaken)) {
                return response()->json([
                    'data' => null,
                    'success' => false,
                    'message' => 'Book already taken'
                ]);
            }

            $order = BookOrder::query()->create([
                'book_id' => $book->id,
                'user_id' => auth()->user()->id
            ]);

            return response()->json([
                'data' => $order,
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
            $order = BookOrder::query()->findOrFail($id);

            if (!($order->user_id == auth()->user()->id)) {
                return response()->json([
                    'data' => null,
                    'success' => false,
                    'message' => 'You are not reserved this book'
                ]);
            }

            return response()->json([
                'data' => $order,
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
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $book = Book::query()->findOrFail($request->input('book_id'));

            $isTaken = BookOrder::query()->where('book_id', '=', $book->id)->first();

            $order = BookOrder::query()->findOrFail($id);

            if ($order->user_id != auth()->user()->id) {
                return response()->json([
                    'data' => null,
                    'success' => false,
                    'message' => 'You are not reserved this book'
                ]);
            }

            if (!empty($isTaken)) {
                return response()->json([
                    'data' => null,
                    'success' => false,
                    'message' => 'Book already taken'
                ]);
            }

            $order->update([
                'book_id' => $book->id,
                'user_id' => auth()->user()->id
            ]);

            return response()->json([
                'data' => $order,
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $order = BookOrder::query()->findOrFail($id);

            if (!($order->user_id == auth()->user()->id)) {
                return response()->json([
                    'data' => null,
                    'success' => false,
                    'message' => 'You are not reserved this book'
                ]);
            }

            $order->delete();

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
