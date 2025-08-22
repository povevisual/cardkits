@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">My Bio Links</h1>
        <a href="{{ route('bio-links.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Create New Bio Link
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($bioLinks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($bioLinks as $bioLink)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if($bioLink->background_photo)
                        <div class="h-32 bg-cover bg-center" style="background-image: url('{{ Storage::url($bioLink->background_photo) }}')"></div>
                    @else
                        <div class="h-32 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            @if($bioLink->profile_photo)
                                <img src="{{ Storage::url($bioLink->profile_photo) }}" alt="Profile" class="w-16 h-16 rounded-full mr-4">
                            @else
                                <div class="w-16 h-16 bg-gray-300 rounded-full mr-4 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 text-xl"></i>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $bioLink->title }}</h3>
                                <p class="text-gray-600 text-sm">{{ Str::limit($bioLink->description, 50) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-eye mr-1"></i>{{ $bioLink->view_count }} views
                            </span>
                            <span class="px-2 py-1 text-xs rounded-full {{ $bioLink->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $bioLink->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="flex space-x-2">
                            <a href="{{ route('bio-links.show', $bioLink) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                            <a href="{{ $bioLink->full_url }}" target="_blank" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-4 rounded">
                                <i class="fas fa-external-link-alt mr-2"></i>View
                            </a>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">
                                    <i class="fas fa-link mr-1"></i>{{ $bioLink->items->count() }} links
                                </span>
                                <form action="{{ route('bio-links.destroy', $bioLink) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this bio link?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $bioLinks->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-link text-6xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Bio Links Yet</h3>
            <p class="text-gray-600 mb-6">Create your first bio link to start sharing all your important links in one place.</p>
            <a href="{{ route('bio-links.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">
                <i class="fas fa-plus mr-2"></i>Create Your First Bio Link
            </a>
        </div>
    @endif
</div>
@endsection