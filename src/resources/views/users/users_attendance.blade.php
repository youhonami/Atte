@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users_attendance.css') }}">
@endsection

@section('content')
<h1 class="attendance-title">{{ $user->name }}さんの勤務実績</h1>

<div class="month-switch-form">
    <form action="{{ route('user.attendance', ['id' => $user->id]) }}" method="GET" class="month-switch-form__prev">
        <input type="hidden" name="month" value="{{ \Carbon\Carbon::parse($currentMonth)->subMonth()->format('Y-m') }}">
        <button type="submit" class="month-switch-form__button">&lt;</button>
    </form>
    <span class="month-switch-form__current">
        {{ \Carbon\Carbon::parse($currentMonth)->format('Y年m月') }}
    </span>
    <form action="{{ route('user.attendance', ['id' => $user->id]) }}" method="GET" class="month-switch-form__next">
        <input type="hidden" name="month" value="{{ \Carbon\Carbon::parse($currentMonth)->addMonth()->format('Y-m') }}">
        <button type="submit" class="month-switch-form__button">&gt;</button>
    </form>
</div>

<table class="attendance-table">
    <thead class="attendance-table__head">
        <tr class="attendance-table__row">
            <th class="attendance-table__header">日付</th>
            <th class="attendance-table__header">勤務開始</th>
            <th class="attendance-table__header">勤務終了</th>
            <th class="attendance-table__header">休憩時間</th>
            <th class="attendance-table__header">勤務時間</th>
        </tr>
    </thead>
    <tbody class="attendance-table__body">
        @foreach($attendanceData as $data)
        <tr class="attendance-table__row">
            <td class="attendance-table__cell">{{ $data['date'] }}</td>
            <td class="attendance-table__cell">{{ isset($data['attendance']) && $data['attendance']->start_time ? \Carbon\Carbon::parse($data['attendance']->start_time)->format('H:i:s') : '-' }}</td>
            <td class="attendance-table__cell">{{ isset($data['attendance']) && $data['attendance']->end_time ? \Carbon\Carbon::parse($data['attendance']->end_time)->format('H:i:s') : '-' }}</td>
            <td class="attendance-table__cell">{{ isset($data['attendance']) && $data['attendance']->break_duration ? $data['attendance']->break_duration : '-' }}</td>
            <td class="attendance-table__cell">{{ isset($data['attendance']) && $data['attendance']->work_time ? $data['attendance']->work_time : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection