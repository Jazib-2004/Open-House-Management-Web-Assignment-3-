<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
          <h2 class="text-2xl font-bold uppercase mb-1">Update Your Preferences</h2>
        </header>
    
        <form method="POST" action="/guest/preferences" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-6">
            <label for="company" class="inline-block text-lg mb-2">Your Preferences</label>
            <input type="text" class="border border-gray-200 rounded p-2 w-full" name="keywords" value="{{ implode(',', $tags) }}"/>
    
            @error('keywords')
            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
            @enderror
          </div>
    
          <div class="mb-6">
            <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
              Update
            </button>
    
            <a href="/guest/preferences" class="text-black ml-4"> Back </a>
          </div>
        </form>
      </x-card>
  </x-layout>
  