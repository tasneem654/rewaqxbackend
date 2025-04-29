<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\User;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of available vouchers.
     */
    public function index()
    {
        $vouchers = Voucher::orderBy('point_cost', 'asc')
            ->get(['voucherid', 'title', 'voucher_code', 'point_cost', 'amount', 'is_available', 'logo']);

        return response()->json([
            'success' => true,
            'data' => $vouchers->map(function ($voucher) {
                return [
                    'voucherid' => $voucher->voucherid,
                    'title' => $voucher->title,
                    'voucher_code' => $voucher->voucher_code, // Added voucher_code
                    'point_cost' => $voucher->point_cost,
                    'value' => number_format($voucher->amount, 2) . ' SAR',
                    'is_available' => $voucher->is_available,
                    'logo' => $voucher->logo,
                ];
            })
        ]);
    }

    /**
     * Redeem a voucher.
     */
    public function redeem(Request $request, $id)
    {
        $userId = 1; // hardcoded for now - consider using auth()->id()
        $user = User::findOrFail($userId);
        $voucher = Voucher::findOrFail($id);

        if (!$voucher->is_available) {
            return response()->json([
                'success' => false,
                'message' => 'This voucher is not available'
            ], 400);
        }

        $userPoints = $user->points;

        if (!$userPoints) {
            return response()->json([
                'success' => false,
                'message' => 'User has no points record'
            ], 400);
        }

        if ($userPoints->totalPoints < $voucher->point_cost) {
            return response()->json([
                'success' => false,
                'message' => 'You don\'t have enough points'
            ], 400);
        }

        // Deduct points
        $userPoints->totalPoints -= $voucher->point_cost;
        $userPoints->save();

        // Mark voucher as unavailable
        $voucher->is_available = false;
        $voucher->save();

        return response()->json([
            'success' => true,
            'message' => 'Voucher redeemed successfully!',
            'data' => [
                'voucher' => [
                    'id' => $voucher->voucherid,
                    'title' => $voucher->title,
                    'code' => $voucher->voucher_code, // Added voucher_code to response
                    'value' => number_format($voucher->amount, 2) . ' SAR'
                ],
                'remaining_points' => $userPoints->totalPoints
            ]
        ]);
    }

    /**
     * Get voucher by code (new method)
     */
    public function getByCode($code)
    {
        $voucher = Voucher::where('voucher_code', $code)->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'voucherid' => $voucher->voucherid,
                'title' => $voucher->title,
                'voucher_code' => $voucher->voucher_code,
                'point_cost' => $voucher->point_cost,
                'value' => number_format($voucher->amount, 2) . ' SAR',
                'is_available' => $voucher->is_available,
                'logo' => $voucher->logo,
            ]
        ]);
    }
}