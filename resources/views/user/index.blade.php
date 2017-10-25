@extends('layouts.app')

@section('content')


{{$user_role->role_name}}

{{Auth::user()->role->role_name}}


@endsection