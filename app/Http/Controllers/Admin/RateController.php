<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RateRequest;
use App\Models\Admin\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function store(RateRequest $request)
    {
        $user_id = Auth::id();

        // Check if the user has already rated this blog
        $existing = Rate::where('user_id', $user_id)->where('blog_id', $request->blog_id)->first();
        
        // If the user has rated before, update the rating
        if ($existing) {
            $existing->update([
                'rate' => $request->rate,
                'created_at' => Carbon::now(),
            ]);
        } else {
            // Otherwise, create a new rating
            Rate::create([
                'blog_id' => $request->blog_id,
                'user_id' => $user_id,
                'rate' => $request->rate,
                'created_at' => Carbon::now(),
            ]);
        }

        // Calculate the average rating and vote count
        $average = Rate::where('blog_id', $request->blog_id)->avg('rate');
        $count = Rate::where('blog_id', $request->blog_id)->count();

        // Return a JSON response with the result
        return response()->json([
            'message' => 'Đánh giá thành công',
            'average' => round($average, 2),
            'votes' => $count,
            'time' => Carbon::now()->toDateTimeString()
        ]);
    }
}
