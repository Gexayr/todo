<!-- create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="card col-md-8 col-md-offset-2">
        <div class="card-header">
            Add Task
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
                <form method="post" action="{{ route('tasks.store') }}">
                <div class="form-group">
                    {{ csrf_field() }}
                    <label for="name">Title:</label>
                    <input type="text" class="form-control" name="title" value="{{Request::old('title')}}"/>
                </div>
                <div class="form-group">
                    <label for="price">Description :</label>
                    <textarea class="form-control" name="description">{{Request::old('description')}} </textarea>
                </div>

                <div class="form-group" >
                    <label for="performers">Performer :</label>
                    <span>(multiple)</span>
                    <select name="performers[]" class="form-control" id="performers" multiple>
                    @foreach ($developers as $id => $dev)
                        @if (Request::old('performers'))
                            @if (in_array($id, Request::old('performers')))
                                <option value="{{$id}}" selected>{{$dev}}</option>
                            @else
                                <option value="{{$id}}">{{$dev}}</option>
                            @endif
                        @else
                            <option value="{{$id}}">{{$dev}}</option>
                        @endif
                    @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="datetime">Deadline :</label>
{{--                    <input type="date" id="datetime" class="form-control" name="deadline" value="{{Request::old('deadline')}}" />--}}
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" name="deadline" data-target="#datetimepicker1"  value="{{Request::old('deadline')}}" />
                        <span class="input-group-addon" data-target="#datetimepicker1" data-toggle="datetimepicker">
                            <span class="fa fa-calendar"></span>
                        </span>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Create Task</button>
            </form>
                @else
                    <div class="card-header">
                        Only managers can create tasks
                    </div>
                @endif

{{--                <script type="text/javascript">--}}
{{--                    $(function() {--}}
{{--                        $('#datetimepicker1').datetimepicker({--}}

{{--                        });--}}
{{--                    });--}}
{{--                </script>--}}

        </div>
    </div>
@endsection