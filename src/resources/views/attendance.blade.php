@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')

<h1 class="page-title">日別勤怠画面</h1>

<!-- 日付選択フォーム -->
<form action="{{ route('attendance') }}" method="GET" id="custom-date-form" class="date-navigation__form">
    <!-- 非表示の date フィールド -->
    <input type="date" id="date" name="date" value="{{ request('date', \Carbon\Carbon::today()->toDateString()) }}" class="date-navigation__input">

    <!-- カスタムUI -->
    <div class="date-navigation__controls">
        <button type="button" id="prev-date" class="date-navigation__button date-navigation__button--prev">&lt;</button>
        <span id="display-date" class="date-navigation__date">{{ request('date', \Carbon\Carbon::today()->toDateString()) }}</span>
        <button type="button" id="next-date" class="date-navigation__button date-navigation__button--next">&gt;</button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        const displayDate = document.getElementById('display-date');
        const prevDateButton = document.getElementById('prev-date');
        const nextDateButton = document.getElementById('next-date');
        const form = document.getElementById('custom-date-form');

        // 日付を更新してフォームを送信する関数
        function updateDate(newDate) {
            const formattedDate = newDate.toISOString().split('T')[0];
            dateInput.value = formattedDate;
            displayDate.textContent = formattedDate;
        }

        // 「<」ボタンをクリックした場合
        prevDateButton.addEventListener('click', function() {
            const newDate = new Date(dateInput.value || new Date());
            newDate.setDate(newDate.getDate() - 1);
            updateDate(newDate);
            form.submit();
        });

        // 「>」ボタンをクリックした場合
        nextDateButton.addEventListener('click', function() {
            const newDate = new Date(dateInput.value || new Date());
            newDate.setDate(newDate.getDate() + 1);
            updateDate(newDate);
            form.submit();
        });

        // 入力フィールドを直接変更した場合
        dateInput.addEventListener('change', function() {
            const newDate = new Date(dateInput.value || new Date());
            updateDate(newDate);
            form.submit();
        });
    });
</script>

<table class="attendance-table">
    <tr class="attendance-table__row">
        <th class="attendance-table__label">名前</th>
        <th class="attendance-table__label">勤務開始</th>
        <th class="attendance-table__label">勤務終了</th>
        <th class="attendance-table__label">休憩時間</th>
        <th class="attendance-table__label">勤務時間</th>
    </tr>

    @foreach($attendances as $attendance)
    <tr class="attendance-table__row">
        <td class="attendance-table__data">{{$attendance->user->name}}</td>
        <td class="attendance-table__data">{{$attendance->start_time}}</td>
        <td class="attendance-table__data">{{$attendance->end_time}}</td>
        <td class="attendance-table__data">{{$attendance->break_duration}}</td>
        <td class="attendance-table__data">{{$attendance->work_time}}</td>
    </tr>
    @endforeach
</table>

<!-- ページネーション -->
<div class="pagination">
    {{ $attendances->appends(['date' => request('date')])->links('pagination::bootstrap-4') }}
</div>

@endsection