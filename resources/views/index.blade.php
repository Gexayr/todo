<!-- index.blade.php -->

@extends('layouts.app')

@section('content')

<div>
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div><br />
    @endif
    @if (Auth::user()->position == 'manager')

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Assigned</a></li>
            <li><a data-toggle="tab" href="#menu2">Created</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <h3>Assigned tasks</h3>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Title</td>
                        <td>Description</td>
                        <td>Deadline</td>
                        <td>Performers</td>
                        <td>Status</td>
                        <td colspan="2">Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        @if($task->status != 'created')
                            <tr>
                                <td>{{$task->id}}</td>
                                <td>{{$task->title}}</td>
                                <td><a href="/tasks/{{$task->id}}">{{str_limit($task->description, 35)}}</a></td>
                                <td>{{$task->deadline}}</td>
                                <td>
                                    @foreach(json_decode($task->performers) as $dev)
                                        @if($dev != null)
                                            {{$developers[$dev]}}<br>
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$task->status}}</td>
                                <td><a href="{{ route('tasks.edit',$task->id)}}" class="btn btn-primary">Edit</a></td>
                                <td>
                                    <form action="{{ route('tasks.destroy', $task->id)}}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div id="menu2" class="tab-pane fade">
                <h3>Not assigned tasks</h3>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>ID</td>
                        <td>Title</td>
                        <td>Description</td>
                        <td>Deadline</td>
                        <td>Performers</td>
                        <td>Status</td>
                        <td colspan="2">Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        @if($task->status == 'created')
                            <tr>
                            <td>{{$task->id}}</td>
                            <td>{{$task->title}}</td>
                            <td><a href="/tasks/{{$task->id}}">{{str_limit($task->description, 35)}}</a></td>
                            <td>{{$task->deadline}}</td>
                            <td>
                                @foreach(json_decode($task->performers) as $dev)
                                    @if($dev != null)
                                        {{$developers[$dev]}}<br>
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$task->status}}</td>
                            <td><a href="{{ route('tasks.edit',$task->id)}}" class="btn btn-primary">Edit</a></td>
                            <td>
                                <form action="{{ route('tasks.destroy', $task->id)}}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
            <h3>Your tasks</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Title</td>
                    <td>Description</td>
                    <td>Deadline</td>
                    <td>Status</td>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                        <tr>
                            <td>{{$task->id}}</td>
                            <td>{{$task->title}}</td>
                            <td><a href="/tasks/{{$task->id}}">{{str_limit($task->description, 35)}}</a></td>
                            <td>{{$task->deadline}}</td>
                            <td>
                                <select class="form-control status">
                                    <option {{($task->status == 'assigned')?'selected':''}}>assigned</option>
                                    <option {{($task->status == 'in progress')?'selected':''}}>in progress</option>
                                    <option {{($task->status == 'done')?'selected':''}}>done</option>
                                </select>
                                <a href="#" class="btn btn-primary save" onclick="changeStatus('{{$task->id}}', this)">Save</a>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection