@props(['tags'])

@php
$tagsarray = explode(',', $tags);
@endphp

<ul class="flex my-4">
  @foreach($tagsarray as $tag)
  <li class="flex items-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs">
    <a href="/?tag={{$tag}}">{{$tag}}</a>
  </li>
  @endforeach
</ul>