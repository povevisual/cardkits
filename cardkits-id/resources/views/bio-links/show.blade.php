@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <a href="{{ route('bio-links.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">{{ $bioLink->title }}</h1>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('bio-links.edit', $bioLink) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ $bioLink->full_url }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-external-link-alt mr-2"></i>View Live
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-eye text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Views</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $bioLink->view_count }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-link text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active Links</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $bioLink->items->where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-share-alt text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Social Media</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $bioLink->socialMedia->where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-{{ $bioLink->is_active ? 'green' : 'red' }}-100 text-{{ $bioLink->is_active ? 'green' : 'red' }}-600">
                        <i class="fas fa-{{ $bioLink->is_active ? 'check' : 'times' }} text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Status</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $bioLink->is_active ? 'Active' : 'Inactive' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bio Link Preview -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Preview</h3>
                <p class="text-sm text-gray-600">This is how your bio link will appear to visitors</p>
            </div>
            
            <div class="p-8" style="background: linear-gradient(135deg, {{ $bioLink->theme_color }} 0%, {{ $bioLink->button_color }} 100%);">
                <div class="max-w-md mx-auto text-center">
                    @if($bioLink->profile_photo)
                        <img src="{{ Storage::url($bioLink->profile_photo) }}" alt="Profile" class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-white shadow-lg">
                    @else
                        <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-user text-white text-3xl"></i>
                        </div>
                    @endif
                    
                    <h2 class="text-2xl font-bold text-white mb-2">{{ $bioLink->title }}</h2>
                    @if($bioLink->description)
                        <p class="text-white text-opacity-90 mb-6">{{ $bioLink->description }}</p>
                    @endif
                    
                    <div class="space-y-3">
                        @foreach($bioLink->items->where('is_active', true)->take(3) as $item)
                            <div class="bg-white bg-opacity-20 rounded-lg p-3 text-white">
                                <i class="fas fa-link mr-2"></i>{{ $item->title }}
                            </div>
                        @endforeach
                        @if($bioLink->items->where('is_active', true)->count() > 3)
                            <div class="text-white text-opacity-70 text-sm">
                                +{{ $bioLink->items->where('is_active', true)->count() - 3 }} more links
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Links Management -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Links</h3>
                        <p class="text-sm text-gray-600">Manage the links that appear on your bio link page</p>
                    </div>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>Add Link
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                @if($bioLink->items->count() > 0)
                    <div class="space-y-3">
                        @foreach($bioLink->items->sortBy('order') as $item)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                        @if($item->icon)
                                            <i class="{{ $item->icon }} text-gray-600"></i>
                                        @else
                                            <i class="fas fa-link text-gray-600"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $item->title }}</h4>
                                        <p class="text-sm text-gray-600">{{ Str::limit($item->url, 50) }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $item->click_count }} clicks</span>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-link text-4xl"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">No links yet</h4>
                        <p class="text-gray-600 mb-4">Add your first link to start building your bio link page</p>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-plus mr-2"></i>Add Your First Link
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Social Media -->
        @if($bioLink->show_social_icons)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Social Media</h3>
                        <p class="text-sm text-gray-600">Connect your social media accounts</p>
                    </div>
                    <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>Add Social Media
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                @if($bioLink->socialMedia->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($bioLink->socialMedia->sortBy('order') as $social)
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: {{ $social->platform_color }}">
                                        <i class="{{ $social->platform_icon }} text-white"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 capitalize">{{ $social->platform }}</h4>
                                        <p class="text-sm text-gray-600">@{{ $social->username }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $social->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $social->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 mb-4">
                            <i class="fab fa-instagram text-4xl"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">No social media connected</h4>
                        <p class="text-gray-600 mb-4">Connect your social media accounts to display them on your bio link page</p>
                        <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-plus mr-2"></i>Connect Social Media
                        </button>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Settings -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Settings</h3>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Status</h4>
                        <form action="{{ route('bio-links.toggle-status', $bioLink) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-4 py-2 rounded-lg {{ $bioLink->is_active ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                                <i class="fas fa-{{ $bioLink->is_active ? 'pause' : 'play' }} mr-2"></i>
                                {{ $bioLink->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Share</h4>
                        <div class="flex space-x-2">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($bioLink->full_url) }}&text={{ urlencode('Check out my bio link: ' . $bioLink->title) }}" 
                               target="_blank" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                                <i class="fab fa-twitter mr-2"></i>Twitter
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($bioLink->full_url) }}" 
                               target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                <i class="fab fa-facebook mr-2"></i>Facebook
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection