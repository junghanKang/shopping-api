<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    public function getUser(Request $request)
    {
        $email = $request->input('email');
        $user = DB::table('users')
                ->select('id', 'name', 'nickname', 'phone', 'email', 'gender')
                ->where('email', $email)
                ->first();

        if ($user) {
            return response()->json(['user' => $user], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function getOrder($userId)
    {
        $orders = DB::table('orders')
            ->select('order_number', 'product_name', 'purchase_datetime', 'created_at', 'updated_at')
            ->where('user_id', $userId)
            ->get();

        if ($orders) {
            return response()->json($orders);
        }

        return response()->json(['message' => 'Order not found'], 404);
    }

    public function getUsersWithConditions(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search');

        $query = DB::table('users')
            ->select('id', 'name', 'email', 'gender')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'asc');

        if (!$query) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $result = $query->paginate($perPage, ['*'], 'page', $page);

        $users = $result->items();

        foreach ($users as &$user) {
            $lastOrder = DB::table('orders')
                ->select('order_number', 'product_name', 'purchase_datetime')
                ->where('user_id', $user->id)
                ->orderBy('purchase_datetime', 'desc')
                ->first();
            $user->last_order = $lastOrder;
        }

        return response()->json($result);
    }
}
