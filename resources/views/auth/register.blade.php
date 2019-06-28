@extends('layouts.app')

@section('content')
<div class="flex items-center content-center mt-20">
    <div class="md:w-1/3 mx-auto">
        <div class="card">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="label" for="name">
                            Name
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="input @error('name') border-red-500 @enderror" id="name" type="text" name="name">

                        @error('name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

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
                        <label class="label" for="inline-username">
                            Password
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="input @error('password') border-red-500 @enderror" id="inline-username" type="password" placeholder="******************" name="password">
                        
                        @error('password')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="label" for="inline-username">
                            Confirm Password
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="input" id="inline-username" type="password" placeholder="******************" name="password_confirmation">
                    </div>
                </div>

                <div class="flex items-center justify-center">
                    <button class="button" type="submit">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
