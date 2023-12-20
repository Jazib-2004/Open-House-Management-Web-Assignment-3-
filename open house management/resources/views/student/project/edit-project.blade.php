<x-layout>

    @if($project)
    <h2 class="text-2xl font-bold mb-4 text-center">Update Project</h2>
<x-card>

<form method="POST" action="{{ route('student.project.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-6">
        <label for="title" class="inline-block text-lg mb-2">Title</label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
            placeholder="Example: Senior Laravel Developer" value="{{ old('title', $project->title) }}" />

        @error('title')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="tags" class="inline-block text-lg mb-2">Keywords (Comma Separated)</label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
            placeholder="Example: Laravel, Backend, Postgres, etc" value="{{ old('tags', $project->tags) }}" />

        @error('tags')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="picture" class="inline-block text-lg mb-2">Project Cover</label>
        <input type="file" class="border border-gray-200 rounded p-2 w-full" name="picture" />

        <img class="w-48 mr-6 mb-6"
          src="{{$project->picture ? asset('storage/' . $project->picture) : asset('/images/no-image.png')}}" alt="" />

        @error('picture')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

    <div class="mb-6">
        <label for="description" class="inline-block text-lg mb-2">Project Description</label>
        <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10">
            {{ old('description', $project->description) }}
        </textarea>

        @error('description')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
            Update Project
        </button>

        <a href="{{ route('student.project.show') }}" class="text-black ml-4"> Back </a>
    </div>
</form>

</x-card>
@else
<p class="text-xl mt-4 text-center text-red-500"><a  class="underline text-blue-500" href="/student/project">Add</a> a project first!</p>

@endif
</x-layout>