@props(['project','bg'])

  <div class="flex border-2 {{$bg}} rounded-lg p-4">
    <a href="/projects/{{$project->id}}">
      <img class="w-48 mr-6 mb-6"
      src="{{$project->picture ? asset('storage/' . $project->picture) : asset('/images/no-image.png')}}" alt="" />
    </a>
    <div>
      <a href="/projects/{{$project->id}}">
      <h3 class="text-2xl">
        {{$project->title}}
      </h3>
    </a>
      <x-project-tags :tags="$project->tags" />
      <div class="text-lg mt-4 flex justify-between">
        @if(isset($project->location))
        <div>
          <i class="fa-solid fa-location-dot"></i> {{$project->location}}
        </div>
        
        @endif

        @if(auth()->user()->role=='guest' && $project->getUserRating($project->id)!=null)
        <div>
          <i class="fa fa-star"></i>
          {{$project->getUserRating($project->id)}} 
        </div>
                 
        @endif
      </div>
    </div>
  </div>