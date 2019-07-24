
@extends('layouts.adminLayout')

@section('content')
<new-post id="{{isset($id) ? $id : 0 }}"></new-post>
@endsection