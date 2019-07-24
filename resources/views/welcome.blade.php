@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-6">
                        <div class="self-photo"></div>
                    </div>
                    <div class="col-6 text-block-photo">
                        <p class="mb-0">My name is Sergey.</p>
                        <p class="mb-0">I am Junior Developer.</p>
                        <p class="mb-0">Work status: <span class="status">working <i class="fas fa-circle"></i></span>
                        </p>
                        <p>Work: C# .Net developer</p>
                    </div>
                </div>
                <div class="row work-exp">
                    <h1>Work experience</h1>
                    <timer></timer>
                </div>
            </div>
            <div class="col-6">
                <img style="height: 80vh" src="/images/way.svg" alt="">
            </div>
        </div>
    </div>
@endsection
