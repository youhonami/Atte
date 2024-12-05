<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;

class UserController extends Controller
{
    // ユーザー一覧
    public function index()
    {
        $users = User::paginate(5); // ページネーションを追加
        return view('users.users', compact('users'));
    }


    public function attendance(User $user, Request $request)
    {
        $currentMonth = $request->input('month', now()->format('Y-m'));

        // 月の開始日と終了日を取得
        $startOfMonth = \Carbon\Carbon::parse($currentMonth)->startOfMonth();
        $endOfMonth = \Carbon\Carbon::parse($currentMonth)->endOfMonth();

        // 月の日付リストを生成
        $dateRange = collect();
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateRange->push($date->format('Y-m-d'));
        }

        // 該当月の出勤データを取得
        $attendances = Attendance::where('user_id', $user->id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->keyBy(function ($attendance) {
                return $attendance->created_at->format('Y-m-d');
            });

        // 各日付に対応する出勤データをマッピング
        $attendanceData = $dateRange->map(function ($date) use ($attendances) {
            return [
                'date' => $date,
                'attendance' => $attendances->get($date, null),
            ];
        });

        return view('users.users_attendance', compact('user', 'attendanceData', 'currentMonth'));
    }
}
