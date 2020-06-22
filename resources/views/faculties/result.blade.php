@extends('layouts.app')

@section('content')
<result-page :faculty="{{ auth()->user() }}"></result-page>
@endsection
