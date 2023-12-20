@auth
<x-layout>
    <x-card>

        <div>
            <h3 class="text-3xl font-bold mb-4 text-center">All Projects</h3>
            <p class="text-md mb-4 text-center">Projects are sorted by unassigned locations first.</p>
        </div>

        <div class="mb-2 mx-4 flex justify-between">
            <div class="flex items-center gap-1 mb-2">
                <div class="border-2 border-red-500 p-2 w-[20px]"></div>
                <p class="font-bold">Unassigned Locations</p>
            </div>
            <div  class="flex items-center gap-1 mb-2">
                <div class="border-2 border-blue-500 p-2 w-[20px]"></div>
                <p class="font-bold">Assigned Locations</p>
            </div>
        </div>
        <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

            @unless(count($projects) == 0)
        
            @foreach($projects as $project)
            <x-project-card :project="$project" :bg="($project->isAssigned())? 'border-blue-500':'border-red-500' "/>
            @endforeach
        
            @else
            <p>No listings found</p>
            @endunless
        
          </div>

    </x-card>
</x-layout>
@endauth
