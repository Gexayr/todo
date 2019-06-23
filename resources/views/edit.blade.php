<!-- edit.blade.php -->

@extends('layouts.app')

@section('content')
    <?php
//        dd($task['performers']);
    ?>
    <div class="col-md-8 col-md-offset-2">
        <div class="card-header">
            Edit Task
        </div>
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
                @if (Auth::user()->position == 'manager')

                <form method="post" action="{{ route('tasks.update', $task->id) }}">
                <div class="form-group">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <label for="name">Title:</label>
                    <input type="text" class="form-control" name="title" value="{{$task->title}}"/>

                </div>
                <div class="form-group">
                    <label for="price">Description :</label>
                    <textarea class="form-control" name="description">{{$task->description}}</textarea>
                </div>
                <div class="form-group" >
                    <label for="performers">Performer :</label>
                    <select name="performers[]" class="form-control" id="performers" multiple>
                        @foreach ($developers as $id => $dev)
                            @if (in_array($id, json_decode($task->performers)))
                                <option value="{{$id}}" selected>{{$dev}}</option>
                            @else
                                <option value="{{$id}}">{{$dev}}</option>
                            @endif
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label for="datetime">Deadline :</label>
{{--                    <input type="text" id="datetime" class="form-control" name="deadline" value="{{$task->deadline}}"/>--}}
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" name="deadline" data-target="#datetimepicker1" value="{{$task->deadline}}"/>
                        <span class="input-group-addon" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Task</button>
            </form>
                @else
                    <div class="card-header">
                        Only managers can edit tasks
                    </div>
                @endif

        </div>
    </div>
@endsection