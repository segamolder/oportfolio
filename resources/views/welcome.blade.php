@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row mt-3">
                    <div class="col-md-auto">
                        <div class="self-photo"></div>
                    </div>
                    <div class="col-md-auto mt-2 text-block-photo">
                        <p class="mb-0">My name is Sergey.</p>
                        <p class="mb-0">I am Junior Developer.</p>
                        <p class="mb-0">Work status: <span class="status">working <i class="fas fa-circle"></i></span>
                        </p>
                        <p>Work: C# .Net developer</p>
                    </div>
                </div>
                <div class="row work-exp">
                    <h1 class="mb-5 mt-5">Work experience</h1>
                    <timer></timer>
                </div>
            </div>
            <div class="col-md-6">
                {{--<img style="height: 80vh" src="/images/way.svg" alt="">--}}
                <object
                        class="way"
                        style="height: 80vh"
                        type="image/svg+xml"
                        data="/images/way.svg">
                    <img
                            src="/images/way.svg">
                </object>
            </div>
        </div>
    </div>
@endsection
