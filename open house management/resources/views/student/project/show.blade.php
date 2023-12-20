<x-layout>
    <h2 class="text-2xl font-bold mb-4 text-center">FYP Group Project</h2>
    <x-card>
        @if($project)
        <div class="flex flex-col items-center justify-center text-center">
            <img class="w-48 mr-6 mb-6"
          src="{{$project->picture ? asset('storage/' . $project->picture) : asset('/images/no-image.png')}}" alt="" />
    
            <h3 class="text-2xl mb-2">
              {{$project->title}}
            </h3>
  
            <x-project-tags :tags="$project->tags" />

              <h3 class="text-xl mb-2">Total Ratings: 
                {{$project->evaluations?count($project->evaluations):0}}
              </h3>
              
            <div class="border border-gray-200 w-full mb-6"></div>
            <div>
              <h3 class="text-3xl font-bold mb-4">Project Description</h3>
              <div class="text-lg space-y-6">
                {{$project->description}}

              </div>
            </div>
          </div>
        @else

            <form method="POST" action="/student/project" enctype="multipart/form-data">
                @csrf          
                <div class="mb-6">
                  <label for="title" class="inline-block text-lg mb-2">Title</label>
                  <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
                    placeholder="Example: Open House Management System" value="{{old('title')}}" />
          
                  @error('title')
                  <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                  @enderror
                </div>

          
                <div class="mb-6">
                  <label for="tags" class="inline-block text-lg mb-2">
                    Keywords (Comma Separated)
                  </label>
                  <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
                    placeholder="Example: Laravel, Backend, Postgres, etc" value="{{old('tags')}}" />
          
                  @error('tags')
                  <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                  @enderror
                </div>
          
                <div class="mb-6">
                  <label for="picture" class="inline-block text-lg mb-2">
                    Project Picture
                  </label>
                  <input type="file" class="border border-gray-200 rounded p-2 w-full" name="picture" />
          
                  @error('picture')
                  <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                  @enderror
                </div>
          
                <div class="mb-6">
                  <label for="description" class="inline-block text-lg mb-2">
                    Project Description
                  </label>
                  <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
                >{{old('description')}}</textarea>
          
                  @error('description')
                  <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                  @enderror
                </div>
          
                <div class="mb-6">
                  <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                    Create Project
                  </button>
          
                  <a href="/" class="text-black ml-4"> Back </a>
                </div>
              </form>
        @endif
    </x-card>
</x-layout>
