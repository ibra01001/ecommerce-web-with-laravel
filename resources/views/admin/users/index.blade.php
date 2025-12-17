@extends('admin.layout')

@section('title', 'Admin Users')

@section('content')
<!-- Page Header -->
<div class="pt-8 pb-12 px-6 fade-in">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between">
            <div class="space-y-2">
                <h1 class="text-4xl md:text-5xl font-light text-slate-900 tracking-tight">
                    Admin Users
                </h1>
                <p class="text-slate-600 text-lg font-light">
                    Manage administrator accounts
                </p>
            </div>
            <a href="{{ route('admin.users.create') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white font-medium rounded-lg hover:bg-slate-800 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Admin
            </a>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="px-6 pb-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-green-50 border-2 border-green-200 rounded-lg p-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="px-6 pb-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-red-50 border-2 border-red-200 rounded-lg p-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Admin Users List -->
<div class="px-6 pb-12 fade-in">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="text-left py-4 px-8 text-slate-600 text-xs font-medium uppercase tracking-wider">Name</th>
                            <th class="text-left py-4 px-8 text-slate-600 text-xs font-medium uppercase tracking-wider">Email</th>
                            <th class="text-left py-4 px-8 text-slate-600 text-xs font-medium uppercase tracking-wider">Created</th>
                            <th class="text-right py-4 px-8 text-slate-600 text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="py-5 px-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-900 text-white rounded-full flex items-center justify-center font-medium">
                                        {{ substr($admin->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-medium">{{ $admin->name }}</p>
                                        @if($admin->id === auth()->id())
                                            <span class="text-xs text-slate-500">(You)</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-5 px-8 text-slate-900">
                                {{ $admin->email }}
                            </td>
                            <td class="py-5 px-8 text-slate-600 text-sm">
                                {{ $admin->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-5 px-8">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $admin->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-2 bg-slate-100 text-slate-900 rounded-lg hover:bg-slate-200 transition-colors text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    
                                    @if($admin->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $admin->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this admin user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1 px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm font-medium">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center">
                                <div class="space-y-4">
                                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 text-lg font-medium">No admin users</p>
                                        <p class="text-slate-600 text-sm font-light">Create your first admin user to get started</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
@endsection