@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">  
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-500 text-sm font-normal">
               <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>
            
            <div class="flex item-center">
                @foreach ($project->members as $member)
                    <img 
                        src="{{ gravatar_url($member->url)}}" 
                        alt="{{ $member->name}}'s avatar"
                        class="rounded-full w-8 h-8 mr-2"    
                    >    
                @endforeach

                <img 
                    src="{{ gravatar_url($project->owner->email)}}" 
                    alt="{{ $project->owner->email}}'s avatar"
                    class="rounded-full w-8 h-8 mr-2"    
                >

                <a href="{{ $project->path() . '/edit'}}" class="button ml-4">Edit Project</a>
            </div>
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
                                    <input name="body" value="{{ $task->body }}" class="bg-card w-full {{ $task->completed ? 'text-gray-500 line-through' : '' }}">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>                                                                                  
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks'}}" method="POST">
                            @csrf
                            <input type="text" name="body" class="bg-card w-full" placeholder="Add task..." autocomplete="off">
                        </form>
                    </div>  
                </div>
                
                <div>
                    <h2 class="text-gray-500 text--base font-normal mb-3">General Notes</h2>

                    {{-- General Notes --}}
                    <form action="{{ $project->path() }}" method="POST">
                        @csrf
                        @method('PATCH')
                      
                        <textarea 
                            class="card w-full mb-4" 
                            style="min-height:200px" 
                            placeholder="Add Notes..."
                            name="notes"
                        >{{ $project->notes }}</textarea>

                        <button type="submit" class="button">Update</button>
                    </form>

                    @include('errors')
                </div>
                
            </div>
            
            <div class="lg:w-1/4 px-3 ss">
                @include('projects.partials._card')
            
                @include('projects.partials._activity')

                @can('manage', $project)
                    @include('projects.partials._invite')                
                @endcan
            </div>
        </div>
    </main>

@endsection
