<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BreakController extends Controller
{
    // 休憩開始時刻を登録する
    public function breakStart(Request $request)
    {
        $todayDate = Carbon::today()->toDateString(); // 今日の日付

        // 勤務開始のレコードを取得
        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('created_at', $todayDate) // 打刻当日を基準
            ->whereNull('end_time') // 勤務が終了していない
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', '勤務を開始していません。');
        }

        // 既に休憩を開始している場合はエラー
        if ($attendance->break_start_time) {
            return redirect()->back()->with('error', 'すでに休憩中です。');
        }

        // 現在時刻を休憩開始時刻として登録
        $attendance->break_start_time = Carbon::now()->format('H:i:s');
        $attendance->save();

        return redirect()->back()->with('success', '休憩いってらっしゃい！');
    }


    public function breakEnd(Request $request)
    {
        $todayDate = Carbon::today()->toDateString(); // 今日の日付

        // 勤務中かつ休憩開始済みのレコードを取得
        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('created_at', $todayDate) // 打刻当日を基準
            ->whereNotNull('break_start_time') // 休憩が開始されている
            ->whereNull('break_end_time') // 休憩終了していない
            ->whereNull('end_time') // 勤務終了していない
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', '休憩を開始していません。');
        }

        // 現在時刻を休憩終了時刻として登録
        $breakEndTime = Carbon::now();
        $attendance->break_end_time = $breakEndTime->format('H:i:s');

        // 休憩時間を計算
        $breakStartTime = Carbon::parse($attendance->break_start_time);
        $breakDurationInMinutes = $breakStartTime->diffInMinutes($breakEndTime);

        // 既存の休憩累積時間を取得
        $currentBreakDuration = $attendance->break_duration
            ? Carbon::parse($attendance->break_duration)->diffInMinutes(Carbon::createFromTime(0, 0, 0))
            : 0;

        // 累積休憩時間を更新
        $totalBreakDurationInMinutes = $currentBreakDuration + $breakDurationInMinutes;
        $hours = floor($totalBreakDurationInMinutes / 60);
        $minutes = $totalBreakDurationInMinutes % 60;
        $seconds = 0;

        // 累積休憩時間を 'H:i:s' 形式で保存
        $attendance->break_duration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        // 休憩開始/終了時刻をリセット
        $attendance->break_start_time = null;
        $attendance->break_end_time = null;
        $attendance->save();

        return redirect()->back()->with('success', '休憩終了！おかえりなさい。');
    }
}
