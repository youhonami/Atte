@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endsection

@section('content')
<h1>ユーザー一覧</h1>
<table class="user__table">
    <tr>
        <th>ユーザー名</th>
        <th>勤怠実績</th>
    </tr>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>
            <a href="{{ route('users.attendance', $user->id) }}">勤怠実績を見る</a>
        </td>
    </tr>
    @endforeach
</table>

<div class="pagination">
    {{ $users->links('pagination::bootstrap-4') }}
</div>
@endsection