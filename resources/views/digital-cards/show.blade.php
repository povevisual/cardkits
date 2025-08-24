@extends('layouts.app')

@section('title', $digitalCard->name . ' - Digital Card')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $digitalCard->name }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $digitalCard->title }} @if($digitalCard->company)• {{ $digitalCard->company }}@endif</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('digital-cards.edit', $digitalCard) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Card
                    </a>
                    <a href="{{ $digitalCard->public_url }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View Public
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Card Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-500">Total Views</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ number_format($digitalCard->view_count) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-500">Components</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $digitalCard->components->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-500">Appointments</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $appointments->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-500">Status</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        @if($digitalCard->is_active)
                                            <span class="text-green-600">Active</span>
                                        @else
                                            <span class="text-gray-600">Inactive</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Preview -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-medium text-gray-900">Card Preview</h2>
                        <div class="flex space-x-2">
                            <button type="button" id="desktop-preview" class="px-3 py-1 text-sm font-medium text-indigo-600 bg-indigo-100 rounded-md">Desktop</button>
                            <button type="button" id="mobile-preview" class="px-3 py-1 text-sm font-medium text-gray-600 bg-gray-100 rounded-md">Mobile</button>
                        </div>
                    </div>
                    
                    <div id="preview-container" class="border border-gray-200 rounded-lg overflow-hidden">
                        <div id="desktop-view" class="w-full">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-8">
                                <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
                                    @if($digitalCard->cover_photo)
                                        <div class="h-32 bg-cover bg-center" style="background-image: url('{{ $digitalCard->cover_photo_url }}')"></div>
                                    @endif
                                    
                                    <div class="p-6">
                                        <div class="flex items-center mb-4">
                                            @if($digitalCard->profile_photo)
                                                <img class="h-16 w-16 rounded-full object-cover" src="{{ $digitalCard->profile_photo_url }}" alt="{{ $digitalCard->name }}">
                                            @else
                                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <svg class="h-8 w-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <h3 class="text-xl font-bold text-gray-900">{{ $digitalCard->name }}</h3>
                                                <p class="text-gray-600">{{ $digitalCard->title }}</p>
                                                @if($digitalCard->company)
                                                    <p class="text-sm text-gray-500">{{ $digitalCard->company }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        @if($digitalCard->bio)
                                            <p class="text-gray-700 mb-4">{{ $digitalCard->bio }}</p>
                                        @endif
                                        
                                        <div class="space-y-2">
                                            @if($digitalCard->email)
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                    </svg>
                                                    {{ $digitalCard->email }}
                                                </div>
                                            @endif
                                            
                                            @if($digitalCard->phone)
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                    </svg>
                                                    {{ $digitalCard->phone }}
                                                </div>
                                            @endif
                                            
                                            @if($digitalCard->website)
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                                    </svg>
                                                    {{ $digitalCard->website }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="mobile-view" class="hidden w-full">
                            <div class="bg-gray-900 p-4">
                                <div class="w-64 mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
                                    @if($digitalCard->cover_photo)
                                        <div class="h-24 bg-cover bg-center" style="background-image: url('{{ $digitalCard->cover_photo_url }}')"></div>
                                    @endif
                                    
                                    <div class="p-4">
                                        <div class="text-center mb-4">
                                            @if($digitalCard->profile_photo)
                                                <img class="h-16 w-16 rounded-full object-cover mx-auto" src="{{ $digitalCard->profile_photo_url }}" alt="{{ $digitalCard->name }}">
                                            @else
                                                <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center mx-auto">
                                                    <svg class="h-8 w-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $digitalCard->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $digitalCard->title }}</p>
                                        </div>
                                        
                                        @if($digitalCard->bio)
                                            <p class="text-xs text-gray-700 text-center mb-4">{{ Str::limit($digitalCard->bio, 100) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Components Management -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-medium text-gray-900">Card Components</h2>
                        <button type="button" id="add-component" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Component
                        </button>
                    </div>
                    
                    @if($digitalCard->components->count() > 0)
                        <div class="space-y-4">
                            @foreach($digitalCard->components->sortBy('order') as $component)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            @if($component->icon)
                                                <i class="{{ $component->icon }} text-lg text-gray-600"></i>
                                            @else
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $component->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $component->type_label }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $component->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $component->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <div class="flex items-center space-x-1">
                                            <button type="button" class="text-gray-400 hover:text-gray-600" onclick="editComponent({{ $component->id }})">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button type="button" class="text-red-400 hover:text-red-600" onclick="deleteComponent({{ $component->id }})">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No components yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Add components to make your digital card more interactive.</p>
                        </div>
                    @endif
                </div>

                <!-- Recent Appointments -->
                @if($appointments->count() > 0)
                <div class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-6">Recent Appointments</h2>
                    <div class="space-y-4">
                        @foreach($appointments->take(5) as $appointment)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $appointment->title }}</h4>
                                    <p class="text-sm text-gray-500">{{ $appointment->client_name }} • {{ $appointment->start_time->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $appointment->status === 'completed' ? 'bg-green-100 text-green-800' : ($appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('appointments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">View all appointments →</a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('digital-cards.edit', $digitalCard) }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Card
                        </a>
                        
                        <button type="button" onclick="duplicateCard({{ $digitalCard->id }})" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            Duplicate Card
                        </button>
                        
                        <a href="{{ $digitalCard->public_url }}" target="_blank" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            View Public
                        </a>
                    </div>
                </div>

                <!-- Card Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Card Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="text-sm text-gray-900">{{ $digitalCard->created_at->format('M j, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="text-sm text-gray-900">{{ $digitalCard->updated_at->format('M j, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Template</dt>
                            <dd class="text-sm text-gray-900">{{ $digitalCard->template ? $digitalCard->template->name : 'Custom' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="text-sm text-gray-900">
                                @if($digitalCard->is_active)
                                    <span class="text-green-600">Active</span>
                                @else
                                    <span class="text-gray-600">Inactive</span>
                                @endif
                            </dd>
                        </div>
                        @if($digitalCard->is_password_protected)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Password Protected</dt>
                            <dd class="text-sm text-gray-900">Yes</dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Share & Embed -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Share & Embed</h3>
                    <div class="space-y-3">
                        <div>
                            <label for="public-url" class="block text-sm font-medium text-gray-700 mb-1">Public URL</label>
                            <div class="flex">
                                <input type="text" id="public-url" value="{{ $digitalCard->public_url }}" readonly class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md text-sm">
                                <button type="button" onclick="copyToClipboard('public-url')" class="px-3 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md text-sm text-gray-700 hover:bg-gray-200">
                                    Copy
                                </button>
                            </div>
                        </div>
                        
                        <div>
                            <label for="qr-code" class="block text-sm font-medium text-gray-700 mb-1">QR Code</label>
                            <div class="text-center">
                                @if($digitalCard->qr_code_url)
                                    <img src="{{ $digitalCard->qr_code_url }}" alt="QR Code" class="w-32 h-32 mx-auto">
                                @else
                                    <div class="w-32 h-32 bg-gray-100 rounded mx-auto flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2.01M8 4h2m-2 0h.01M7 20h2m-2 0h.01M4 12h.01M4 8h.01M4 4h.01"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Preview toggle functionality
document.getElementById('desktop-preview').addEventListener('click', function() {
    document.getElementById('desktop-view').classList.remove('hidden');
    document.getElementById('mobile-view').classList.add('hidden');
    document.getElementById('desktop-preview').classList.add('text-indigo-600', 'bg-indigo-100');
    document.getElementById('mobile-preview').classList.remove('text-indigo-600', 'bg-indigo-100');
    document.getElementById('mobile-preview').classList.add('text-gray-600', 'bg-gray-100');
});

document.getElementById('mobile-preview').addEventListener('click', function() {
    document.getElementById('mobile-view').classList.remove('hidden');
    document.getElementById('desktop-view').classList.add('hidden');
    document.getElementById('mobile-preview').classList.add('text-indigo-600', 'bg-indigo-100');
    document.getElementById('desktop-preview').classList.remove('text-indigo-600', 'bg-indigo-100');
    document.getElementById('desktop-preview').classList.add('text-gray-600', 'bg-gray-100');
});

// Copy to clipboard functionality
function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    element.setSelectionRange(0, 99999);
    document.execCommand('copy');
    
    // Show feedback
    const button = element.nextElementSibling;
    const originalText = button.textContent;
    button.textContent = 'Copied!';
    button.classList.add('bg-green-100', 'text-green-700');
    
    setTimeout(() => {
        button.textContent = originalText;
        button.classList.remove('bg-green-100', 'text-green-700');
    }, 2000);
}

// Component management functions
function editComponent(componentId) {
    // Implement component editing functionality
    console.log('Edit component:', componentId);
}

function deleteComponent(componentId) {
    if (confirm('Are you sure you want to delete this component?')) {
        fetch(`/card-components/${componentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting component: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting component');
        });
    }
}

// Duplicate card functionality
function duplicateCard(cardId) {
    if (confirm('Are you sure you want to duplicate this card?')) {
        fetch(`/digital-cards/${cardId}/duplicate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect_url;
            } else {
                alert('Error duplicating card: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error duplicating card');
        });
    }
}

// Add component functionality
document.getElementById('add-component').addEventListener('click', function() {
    // Implement add component functionality
    console.log('Add component clicked');
    // You can redirect to a component creation page or show a modal
});
</script>
@endpush