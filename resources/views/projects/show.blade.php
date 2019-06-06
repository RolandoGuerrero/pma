@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">  
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-500 text-sm font-normal">
               <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>
            
            <a href="#" class="button">Add Task</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-gray-500 text-base font-normal mb-3">My Projects</h2>

                    {{-- tasks --}}
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $task->path() }}" method="POST">
                                @method('PATCH')
                                @csrf

                                <div class="flex items-center">
                                    <input name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-500 line-through' : '' }}">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>                                                                                  
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks'}}" method="POST">
                            @csrf
                            <input type="text" name="body" class="w-full" placeholder="Add task...">
                        </form>
                    </div>  
                </div>
                
                <div>
                    <h2 class="text-gray-500 text--base font-normal mb-3">General Notes</h2>

                    {{-- General Notes --}}

                    <textarea class="card w-full" style="min-height:200px">Lorem ipsum.</textarea>
                </div>
                
            </div>
            
            <div class="lg:w-1/4 px-3 ss">
                @include('projects.partials._card')
            </div>
        </div>
    </main>

@endsection
