@extends('layouts.app')

@section('content')
    <div class="flex items-center content-center mt-20">
        <div class="md:w-1/3 mx-auto">
            <div class="card">
                <h1 class="font-normal text-xl text-center py-3">Edit Your Project</h1>

                <form method="POST" action="{{$project->path()}}">
                    @method('PATCH')
                    @include('projects._form', [
                        'button_text' => 'Update',
                        'cancel_url' => $project->path()
                    ])
                </form>
            </div>
        </div>    
    </div>
@endsection
