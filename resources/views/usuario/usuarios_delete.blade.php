@extends('layouts.layouts')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h1 class="display-4">Error</h1>
                    <p class="lead">{{ $message }}</p>
                    <hr class="my-4">
                    <div class="col-sm-8">
                        <a href="javascript:history.back()" class="btn btn-dark btn-lg btn-block">
                            Regresar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
