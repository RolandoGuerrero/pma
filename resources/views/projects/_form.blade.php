
@csrf
<div class="md:flex md:items-center mb-6">
    <div class="md:w-1/3">
        <label class="label" for="title">
            Title
        </label>
    </div>
    <div class="md:w-2/3">
        <input class="input @error('title') border-red-500 @enderror" id="title" type="text" name="title" 
        value="{{$project->title}}">

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
        <textarea class="input @error('description') border-red-500 @enderror" 
        id="description" 
        type="text" 
        name="description"
        rows="8"
        >{{$project->description}}
        </textarea>

        @error('description')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-between">
    <button class="button" type="submit">
        {{ $button_text }}
    </button>
    <a class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-600" href="{{$cancel_url}}">
        Cancel
    </a>
</div>