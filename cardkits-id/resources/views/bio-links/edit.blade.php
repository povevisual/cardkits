@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('bio-links.show', $bioLink) }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Bio Link</h1>
        </div>

        <form action="{{ route('bio-links.update', $bioLink) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Basic Information</h3>
                    
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $bioLink->title) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $bioLink->description) }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="custom_domain" class="block text-sm font-medium text-gray-700 mb-2">Custom Domain (Optional)</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                https://
                            </span>
                            <input type="text" name="custom_domain" id="custom_domain" value="{{ old('custom_domain', $bioLink->custom_domain) }}"
                                   placeholder="yourdomain.com"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        @error('custom_domain')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Media Uploads -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Media</h3>
                    
                    <div>
                        <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                        @if($bioLink->profile_photo)
                            <div class="mb-3">
                                <img src="{{ Storage::url($bioLink->profile_photo) }}" alt="Current Profile Photo" class="w-20 h-20 rounded-full object-cover">
                                <p class="text-sm text-gray-500 mt-1">Current photo</p>
                            </div>
                        @endif
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-user text-gray-400 text-3xl mb-2"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="profile_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                        <span>Upload a file</span>
                                        <input id="profile_photo" name="profile_photo" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        @error('profile_photo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="background_photo" class="block text-sm font-medium text-gray-700 mb-2">Background Photo</label>
                        @if($bioLink->background_photo)
                            <div class="mb-3">
                                <img src="{{ Storage::url($bioLink->background_photo) }}" alt="Current Background Photo" class="w-full h-24 object-cover rounded">
                                <p class="text-sm text-gray-500 mt-1">Current background</p>
                            </div>
                        @endif
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-image text-gray-400 text-3xl mb-2"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="background_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                        <span>Upload a file</span>
                                        <input id="background_photo" name="background_photo" type="file" class="sr-only" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        @error('background_photo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Customization -->
            <div class="mt-8 space-y-6">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Customization</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="theme_color" class="block text-sm font-medium text-gray-700 mb-2">Theme Color</label>
                        <input type="color" name="theme_color" id="theme_color" value="{{ old('theme_color', $bioLink->theme_color) }}"
                               class="w-full h-10 border border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="text_color" class="block text-sm font-medium text-gray-700 mb-2">Text Color</label>
                        <input type="color" name="text_color" id="text_color" value="{{ old('text_color', $bioLink->text_color) }}"
                               class="w-full h-10 border border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="button_color" class="block text-sm font-medium text-gray-700 mb-2">Button Color</label>
                        <input type="color" name="button_color" id="button_color" value="{{ old('button_color', $bioLink->button_color) }}"
                               class="w-full h-10 border border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="button_text_color" class="block text-sm font-medium text-gray-700 mb-2">Button Text Color</label>
                        <input type="color" name="button_text_color" id="button_text_color" value="{{ old('button_text_color', $bioLink->button_text_color) }}"
                               class="w-full h-10 border border-gray-300 rounded-md">
                    </div>
                </div>

                <div>
                    <label for="font_family" class="block text-sm font-medium text-gray-700 mb-2">Font Family</label>
                    <select name="font_family" id="font_family" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Inter" {{ old('font_family', $bioLink->font_family) == 'Inter' ? 'selected' : '' }}>Inter</option>
                        <option value="Roboto" {{ old('font_family', $bioLink->font_family) == 'Roboto' ? 'selected' : '' }}>Roboto</option>
                        <option value="Open Sans" {{ old('font_family', $bioLink->font_family) == 'Open Sans' ? 'selected' : '' }}>Open Sans</option>
                        <option value="Lato" {{ old('font_family', $bioLink->font_family) == 'Lato' ? 'selected' : '' }}>Lato</option>
                        <option value="Poppins" {{ old('font_family', $bioLink->font_family) == 'Poppins' ? 'selected' : '' }}>Poppins</option>
                    </select>
                </div>
            </div>

            <!-- Options -->
            <div class="mt-8 space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Options</h3>
                
                <div class="flex items-center">
                    <input type="checkbox" name="show_social_icons" id="show_social_icons" value="1" {{ old('show_social_icons', $bioLink->show_social_icons) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="show_social_icons" class="ml-2 block text-sm text-gray-900">
                        Show social media icons
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="show_analytics" id="show_analytics" value="1" {{ old('show_analytics', $bioLink->show_analytics) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="show_analytics" class="ml-2 block text-sm text-gray-900">
                        Enable analytics tracking
                    </label>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('bio-links.show', $bioLink) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update Bio Link
                </button>
            </div>
        </form>
    </div>
</div>
@endsection