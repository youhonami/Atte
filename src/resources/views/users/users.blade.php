@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endsection

@section('content')
<h1 class="user-list__title">ユーザー一覧</h1>
<table class="user-table">
    <thead class="user-table__head">
        <tr class="user-table__row">
            <th class="user-table__header">ユーザー名</th>
            <th class="user-table__header">勤怠実績</th>
        </tr>
    </thead>
    <tbody class="user-table__body">
        @foreach($users as $user)
        <tr class="user-table__row">
            <td class="user-table__cell">{{ $user->name }}</td>
            <td class="user-table__cell">
                <a href="{{ route('users.attendance', $user->id) }}" class="user-table__link">勤怠実績を見る</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="pagination">
    {{ $users->links('pagination::bootstrap-4') }}
</div>
@endsection