@extends('layouts.app')

@section('content')
    <div class="flex items-center content-center mt-20">
        <div class="md:w-1/3 mx-auto">
            <div class="card">
                <h1 class="font-normal text-xl text-center py-3">Create a Project</h1>

                @include('projects._form', [
                    'project' => new App\Models\Project,
                    'button_text' => 'Create',
                    'cancel_url' => '/projects'                    
                ])                
            </div>
        </div>    
    </div>
@endsection
