
<x-layout>
    
    <div class="mx-4">
      <x-card class="p-10">
        <div class="flex flex-col items-center justify-center text-center">
          <img class="w-48 mr-6 mb-6" alt="" />
  
          <h3 class="text-2xl mb-2">
            {{$project->title}}
          </h3>

          <x-project-tags :tags="$project->tags" />
            
          <div class="border border-gray-200 w-full mb-6"></div>
          <div>
            <h3 class="text-3xl font-bold mb-4">Project Description</h3>
            <div class="text-lg space-y-6">
              {{$project->description}}

            </div>
          </div>
        </div>
        
        @if(!$project->isAssigned() && auth()->user()->role=="admin")
        <div class="border border-gray-200 w-full mb-6"></div>
        <x-locations :projectId="$project->id" :availableLocations="$availableLocations"></x-locations>
        @elseif($project->isAssigned() && auth()->user()->role=="admin")
        <div class="border border-gray-200 w-full mb-6"></div>
        <p class="text-lg mb-4 text-center">View Project <a class="underline text-blue-500" href="/projects/{{$project->id}}/evaluations">ratings</a>.</p>
        @endif

        @if(auth()->user()->role=="guest" && !$project->getUserRating($project->id))
          <x-rating-form :projectId="$project->id" />
        @endif
      </x-card>
    </div>
    
    

</x-layout>