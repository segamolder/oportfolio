@extends('layouts.app')

@section('content')
    <blog-post-view id="{{isset($id) ? $id : 0 }}"></blog-post-view>
@endsection
