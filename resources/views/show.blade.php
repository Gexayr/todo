<!-- edit.blade.php -->

@extends('layouts.app')

@section('content')
    <?php
//        dd($task['performers']);
    ?>
    <div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif

                <div>
                <div class="form-group">
                    <label for="name">Title:</label>
                    <p>{{$task->title}}</p>

                </div>
                <div class="form-group">
                    <label for="price">Description :</label>
                    <p>{{$task->description}}</p>
                </div>
                <div class="form-group">
                    <label for="datetime">Deadline :</label>
                    <p>{{$task->deadline}}</p>
                </div>
            </div>

        </div>
    </div>
@endsection