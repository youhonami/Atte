@php
use App\Models\Attendance;
use Carbon\Carbon;

$todayAttendance = Attendance::where('user_id', Auth::id())
->whereDate('created_at', Carbon::today())
->first();
@endphp

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/punch.css') }}">
@endsection

@section('content')

<body>
    <div class="container my-5">

        <!-- ログインしたユーザー名の表示 -->
        <div class="text-end mb-4">
            <p>{{ Auth::user()->name }} さんお疲れ様です！</p>
        </div>

        <!-- 成功・エラーメッセージ -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <!-- 勤務開始・勤務終了ボタンの行 -->
        <div class="button-row">
            <form action="/attendance/start" method="POST">
                @csrf
                <button type="submit"
                    {{ $todayAttendance ? 'disabled' : '' }}
                    class="btn btn-success">
                    勤務開始
                </button>
            </form>
            <form action="/attendance/end" method="POST">
                @csrf
                <button type="submit"
                    {{ !$todayAttendance || $todayAttendance->end_time || $todayAttendance->break_start_time ? 'disabled' : '' }}
                    class="btn btn-danger">
                    勤務終了
                </button>
            </form>
        </div>

        <!-- 休憩開始・休憩終了ボタンの行 -->
        <div class="button-row">
            <form action="/attendance/break/start" method="POST">
                @csrf
                <button type="submit"
                    {{ !$todayAttendance || $todayAttendance->end_time || $todayAttendance->break_start_time ? 'disabled' : '' }}
                    class="btn btn-warning">
                    休憩開始
                </button>
            </form>
            <form action="/attendance/break/end" method="POST">
                @csrf
                <button type="submit"
                    {{ !$todayAttendance || $todayAttendance->end_time || !$todayAttendance->break_start_time ? 'disabled' : '' }}
                    class="btn btn-info">
                    休憩終了
                </button>
            </form>
        </div>

    </div>
</body>

@endsection