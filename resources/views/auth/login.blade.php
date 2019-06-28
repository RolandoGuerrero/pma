@extends('layouts.app')

@section('content')
    <div class="flex items-center content-center mt-20">
        <div class="md:w-1/3 mx-auto">
            <div class="card">
                <form method="POST" action="{{ route('login') }}" class="w-full max-w-sm">
                    @csrf
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="label" for="email">
                               E-mail Address
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input class="input @error('email') border-red-500 @enderror" id="email" type="email" name="email">

                            @error('email')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3">
                            <label class="label" for="password">
                                Password
                            </label>
                        </div>
                        <div class="md:w-2/3">
                            <input class="input" id="password" type="password" placeholder="******************" name="password">
                            
                        </div>
                    </div>
                    <div class="md:flex md:items-center mb-6">
                        <div class="md:w-1/3"></div>
                        <label class="md:w-2/3 block text-gray-500 font-bold">
                            <input class="mr-2 leading-tight" type="checkbox">
                            <span class="text-sm">
                                {{ __('Remember Me') }}
                            </span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <button class="button" type="submit">
                            Sign In
                        </button>
                        <a class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-600" href="#">
                            Forgot Password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
