@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users_attendance.css') }}">
@endsection

@section('content')
<h1>{{ $user->name }}さんの勤務実績</h1>

<!-- 月次切り替えフォーム -->
<div class="month-switch-form">
    <form action="{{ route('user.attendance', ['id' => $user->id]) }}" method="GET">
        <input type="hidden" name="month" value="{{ \Carbon\Carbon::parse($currentMonth)->subMonth()->format('Y-m') }}">
        <button type="submit">&lt;</button>
    </form>
    <span>
        {{ \Carbon\Carbon::parse($currentMonth)->format('Y年m月') }}
    </span>
    <form action="{{ route('user.attendance', ['id' => $user->id]) }}" method="GET">
        <input type="hidden" name="month" value="{{ \Carbon\Carbon::parse($currentMonth)->addMonth()->format('Y-m') }}">
        <button type="submit">&gt;</button>
    </form>
</div>

<table class="attendance__table">
    <tr>
        <th>日付</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
    </tr>
    @foreach($attendanceData as $data)
    <tr>
        <td>{{ $data['date'] }}</td>
        <td>{{ isset($data['attendance']) && $data['attendance']->start_time ? \Carbon\Carbon::parse($data['attendance']->start_time)->format('H:i:s') : '-' }}</td>
        <td>{{ isset($data['attendance']) && $data['attendance']->end_time ? \Carbon\Carbon::parse($data['attendance']->end_time)->format('H:i:s') : '-' }}</td>
        <td>{{ isset($data['attendance']) && $data['attendance']->break_duration ? $data['attendance']->break_duration : '-' }}</td>
        <td>{{ isset($data['attendance']) && $data['attendance']->work_time ? $data['attendance']->work_time : '-' }}</td>
    </tr>
    @endforeach
</table>

@endsection