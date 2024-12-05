@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user-list.css') }}" />
@endsection

@section('content')
<div class="date-navigation">
    <h2>従業員一覧</h2>
</div>

<table>
    <thead>
        <tr>
            <th>従業員ID</th>
            <th>名前</th>
            <th>月間勤務状況</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
            <tr>
                <td>{{ $employee->id }}</td>
                <td>{{ $employee->name }}</td>
                <td>
                    <a href="{{ route('employees.attendance', ['id' => $employee->id]) }}">
                        月間勤務状況
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection