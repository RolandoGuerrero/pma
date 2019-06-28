@extends('layouts.app')

@section('content')
    <div class="flex items-center content-center mt-20">
        <div class="md:w-1/3 mx-auto">
            <div class="card">
                <h1 class="font-normal text-xl text-center py-3">Create a Project</h1>

                <form method="POST" action="/projects">
                    @csrf

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="label" for="title">
                                Title
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input class="input @error('title') border-red-500 @enderror" id="title" type="text" name="title">

                            @error('title')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="label" for="description">
                                Description
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <textarea class="input @error('description') border-red-500 @enderror" id="description" type="text" name="description">
                            </textarea>

                            @error('description')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button class="button" type="submit">
                            Create
                        </button>
                        <a class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-600" href="/projects">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>    
    </div>
@endsection
