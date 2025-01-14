<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::query();

        // 日付が選択されている場合、created_at を基準に絞り込む
        if ($request->has('date') && $request->date) {
            $date = Carbon::parse($request->date); // 選択された日付
            $query->whereDate('created_at', $date);
        } else {
            // 日付が選択されていない場合は、当日の日付で絞り込む
            $query->whereDate('created_at', Carbon::today());
        }
        // ページネーションを使用して5件ずつ取得
        $attendances = $query->paginate(5); // 1ページあたり5件


        return view('attendance', compact('attendances'));
    }

    public function startAttendance(Request $request)
    {
        // 現在の時刻を取得
        $currentTime = Carbon::now();
        $todayDate = Carbon::today()->toDateString(); // 今日の日付（タイムゾーン考慮）

        // 当日の出勤データを検索
        $existingAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('created_at', $todayDate)
            ->first();

        // 既存のレコードがある場合は出勤済みとみなす
        if ($existingAttendance) {
            return redirect()->back()->with('error', '本日は既に出勤済みです。');
        }

        // 新しい出勤レコードを作成
        Attendance::create([
            'user_id' => Auth::id(),
            'start_time' => $currentTime,
            'created_at' => $currentTime, // 明示的に作成日時を設定
            'updated_at' => $currentTime // 更新日時も設定
        ]);

        return redirect('/')->with('success', '今日も一日頑張りましょう！');
    }


    public function end(Request $request)
    {
        // 現在のユーザーの当日の出勤データを取得
        $todayDate = Carbon::today()->toDateString(); // 今日の日付
        $attendance = Attendance::where('user_id', Auth::id())
            ->whereDate('created_at', $todayDate) // 出勤データの日付で判定
            ->whereNull('end_time') // 退勤未登録のものを取得
            ->first();

        if (!$attendance) {
            // 出勤データが存在しない、または既に退勤済みの場合はエラーを返す
            return redirect()->back()->with('error', '退勤打刻ができません。出勤していないか、既に退勤済みです。');
        }

        // 勤務終了時刻を現在の時刻に設定
        $endTime = Carbon::now();
        $attendance->end_time = $endTime;

        // 勤務時間を計算
        $startTime = Carbon::parse($attendance->start_time);
        $workDurationInMinutes = $startTime->diffInMinutes($endTime);

        // 休憩時間が設定されている場合、その分を差し引く
        if ($attendance->break_duration) {
            list($breakHours, $breakMinutes, $breakSeconds) = explode(':', $attendance->break_duration);
            $breakDurationInMinutes = $breakHours * 60 + $breakMinutes;
            $workDurationInMinutes -= $breakDurationInMinutes;
        }

        // 勤務時間を時:分:秒形式に変換
        $hours = floor($workDurationInMinutes / 60);
        $minutes = $workDurationInMinutes % 60;
        $seconds = 0; // 秒は0とする

        // 'H:i:s'形式に整形
        $workDurationFormatted = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        // work_timeに勤務時間を保存
        $attendance->work_time = $workDurationFormatted;
        $attendance->save();

        return redirect()->back()->with('success', 'お疲れ様でした！');
    }




    public function showUserAttendance()
    {
        // ログインユーザーの勤務実績を取得
        $attendances = Attendance::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');


        return view('my_attendance', compact('attendances'));
    }

    public function showAttendance(Request $request)
    {
        // 現在のサーバー日付を取得
        $currentDate = Carbon::now()->toDateString();

        // リクエストの日付がない場合、または過去の日付の場合は現在の日付を使う
        $date = $request->input('date', $currentDate);

        if ($date !== $currentDate) {
            // 日付が今日と異なる場合、現在の日付にリダイレクト
            return redirect()->route('attendance', ['date' => $currentDate]);
        }

        // 該当の日付の勤怠データを取得
        $attendances = Attendance::whereDate('created_at', $date)->get();

        return view('attendance.index', compact('attendances', 'date'));
    }
}
