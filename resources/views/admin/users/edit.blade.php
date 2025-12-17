@extends('admin.layout')

@section('title', 'Edit Admin User')

@section('content')
<!-- Page Header -->
<div class="pt-8 pb-12 px-6">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.users.index') }}" 
               class="p-2 hover:bg-slate-100 rounded-lg transition-colors">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-light text-slate-900 tracking-tight">
                    Edit Admin User
                </h1>
                <p class="text-slate-600 text-sm font-light mt-1">
                    Update administrator account details
                </p>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white border border-slate-200 rounded-lg p-8">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-900 mb-2">
                        Full Name
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-900 mb-2">
                        Email Address
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Section Divider -->
                <div class="pt-6 border-t border-slate-200">
                    <h3 class="text-lg font-medium text-slate-900 mb-4">Change Password</h3>
                    <p class="text-sm text-slate-600 mb-6">Leave blank to keep the current password</p>

                    <!-- New Password Field -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-slate-900 mb-2">
                            New Password
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-900 mb-2">
                            Confirm New Password
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all"
                               placeholder="••••••••">
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                    <div class="text-sm text-slate-600 space-y-1">
                        <p><span class="font-medium">Account Created:</span> {{ $user->created_at->format('F j, Y') }}</p>
                        <p><span class="font-medium">Last Updated:</span> {{ $user->updated_at->format('F j, Y') }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-3 border-2 border-slate-200 text-slate-900 font-medium rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-slate-900 text-white font-medium rounded-lg hover:bg-slate-800 transition-colors">
                        Update Admin User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection