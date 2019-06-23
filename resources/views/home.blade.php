@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="panel-heading">
                        @if (Auth::user()->position == 'manager')
                          Welcome to "Task Manager". Here you can <a href="/tasks/create">create</a> or <a href="/tasks">view</a> already created tasks.
                        @else
                            Welcome to "Task Manager". <a href="/tasks">Here</a> you can see your tasks.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
