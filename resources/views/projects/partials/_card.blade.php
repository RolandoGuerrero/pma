<div class="card flex flex-col" style="height:200px">
    <h3 class="font-normal text-xl py-3 -ml-5 border-l-4 border-purple-500 pl-4">
        <a href="{{ $project->path()}}">{{ $project->title}}</a>    
    </h3>
    
    <div class="text-gray-500 mb-10 flex-1">{{ str_limit($project->description,100) }}</div>

    @can('manage', $project)
        <footer>
            <form action="{{ $project->path() }}" method="POST" class="text-right">
                @csrf
                @method("DELETE")
                <button type="submit" class="text-xs ">Delete</button>
            </form>
        </footer>
    @endcan
    
</div>