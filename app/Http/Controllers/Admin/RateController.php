<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest;
use App\Models\Admin\Rate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class RateController extends Controller
{
    public function store(RateRequest $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Vui lòng đăng nhập để đánh giá'
            ], 401);
        }

        $user_id = Auth::id();
        $blog_id = $request->blog_id;
        $rating = $request->rate;

        // Lưu hoặc cập nhật đánh giá
        Rate::updateOrCreate(
            [
                'user_id' => $user_id,
                'blog_id' => $blog_id
            ],
            [
                'rate' => $rating,
                'updated_at' => Carbon::now()
            ]
        );

        // Lấy thống kê
        $stats = Rate::where('blog_id', $blog_id)
                    ->selectRaw('AVG(rate) as average, COUNT(*) as votes')
                    ->first();

        return response()->json([
            'message' => 'Đánh giá thành công',
            'average' => round($stats->average, 2),
            'votes' => $stats->votes,
            'user_rate' => $rating,
            'time' => now()->toDateTimeString()
        ]);
    }
}
