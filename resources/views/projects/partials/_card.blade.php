<div class="card" style="height:200px">
    <h3 class="font-normal text-xl py-3 -ml-5 border-l-4 border-purple-500 pl-4 mb-3">
        <a href="{{ $project->path()}}">{{ $project->title}}</a>    
    </h3>
    
    <div class="text-gray-500">{{ str_limit($project->description,100) }}</div>
</div>