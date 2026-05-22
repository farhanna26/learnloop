<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class LeaderboardController extends Controller
{
    public function index()
    {
        return view('leaderboard');
    }

    public function getData(Request $request)
    {
        $category = $request->query('category', 'pembelajaran'); 
        $time = $request->query('time', 'month'); 

        $dateFilter = null;
        if ($time === 'today') {
            $dateFilter = Carbon::today();
        } elseif ($time === 'week') {
            $dateFilter = Carbon::now()->startOfWeek();
        } elseif ($time === 'month') {
            $dateFilter = Carbon::now()->startOfMonth();
        }

        if ($category === 'portofolio') {
            // JALUR 1: PORTOFOLIO (Hitung jumlah postingan)
            $leaderboard = User::withCount(['posts' => function($q) use ($dateFilter) {
                if ($dateFilter) $q->where('created_at', '>=', $dateFilter);
            }])
            ->get()
            ->filter(function($user) { 
                return $user->posts_count > 0; // Buang yang gak punya post
            })
            ->sortByDesc('posts_count')
            ->values()
            ->take(10)
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'photo' => $user->photo,
                    'score' => (int) $user->posts_count
                ];
            });

        } else {
            // JALUR 2: PEMBELAJARAN (Totalin semua nilai/grade tugas)
            $leaderboard = User::withSum(['submissions' => function($q) use ($dateFilter) {
                if ($dateFilter) $q->where('created_at', '>=', $dateFilter);
            }], 'grade')
            ->get()
            ->filter(function($user) { 
                return $user->submissions_sum_grade > 0; // Buang yang nilainya 0 atau belum dinilai
            })
            ->sortByDesc('submissions_sum_grade')
            ->values()
            ->take(10)
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'photo' => $user->photo,
                    'score' => (int) $user->submissions_sum_grade // Ini bakal ngejumlahin: misal 80 + 90 = 170
                ];
            });
        }

        return response()->json([
            'success' => true, 
            'data' => $leaderboard
        ]);
    }
}