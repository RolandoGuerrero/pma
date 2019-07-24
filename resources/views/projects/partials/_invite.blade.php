<div class="card flex flex-col mt-3">
    <h3 class="font-normal text-xl py-3 -ml-5 border-l-4 border-purple-500 pl-4">
        Invite a User   
    </h3>
    
    <form action="{{$project->path() . '/invitations'}}" method="POST">
        @csrf

        <div class="mb-3">
            <input type="email" name="email" class="input py-2 px-3" placeholder="Email Address">
        </div>

        <button type="submit" class="button">Invite</button>
    </form>

    @include('errors', ['bag' => 'invitations'])
</div>