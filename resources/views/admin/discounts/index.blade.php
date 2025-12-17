@extends('admin.layout')
@section('title', 'Discounts')

@section('content')
<div class="flex justify-between items-center mb-8 fade-in">
    <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
        <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
        </svg>
        Discount Codes
    </h2>

    <a href="{{ route('admin.discounts.create') }}" 
       class="flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-full font-medium
              hover:bg-slate-800 transition-all duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Create Discount
    </a>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-2xl">
    <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm overflow-hidden fade-in">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 border-b-2 border-slate-200">
                <tr>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Code</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Name</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Type</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Value</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Usage</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Valid Until</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Status</th>
                    <th class="py-4 px-6 text-center text-sm font-medium text-slate-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($discounts as $discount)
                <tr class="hover:bg-slate-50 transition-colors duration-200">
                    <td class="py-4 px-6">
                        <code class="bg-slate-100 px-3 py-1.5 rounded-lg text-slate-900 font-mono font-medium text-sm border border-slate-200">
                            {{ $discount->code }}
                        </code>
                    </td>
                    <td class="py-4 px-6 text-slate-900 font-medium">{{ $discount->name }}</td>
                    <td class="py-4 px-6 text-slate-700 font-light capitalize">{{ $discount->type }}</td>
                    <td class="py-4 px-6 text-slate-900 font-medium">
                        @if($discount->type === 'percentage')
                            {{ $discount->value }}%
                        @else
                            {{ number_format($discount->value, 2) }} DZD
                        @endif
                    </td>
                    <td class="py-4 px-6 text-slate-700 font-light">
                        {{ $discount->usage_count }}
                        @if($discount->usage_limit)
                            <span class="text-slate-500">/ {{ $discount->usage_limit }}</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-slate-700 font-light">
                        @if($discount->expires_at)
                            {{ $discount->expires_at->format('M d, Y') }}
                        @else
                            <span class="text-slate-500">No expiry</span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex flex-wrap gap-2">
                            @if($discount->is_active)
                                <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-medium border border-green-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 px-3 py-1 rounded-full text-xs font-medium border border-red-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Inactive
                                </span>
                            @endif

                            @if($discount->expires_at && $discount->expires_at->isPast())
                                <span class="inline-flex items-center gap-1.5 bg-orange-50 text-orange-700 px-3 py-1 rounded-full text-xs font-medium border border-orange-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Expired
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.discounts.show', $discount) }}" 
                               class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300"
                               title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            
                            <a href="{{ route('admin.discounts.edit', $discount) }}" 
                               class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300"
                               title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            <form action="{{ route('admin.discounts.toggle', $discount) }}" 
                                  method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="p-2 hover:bg-slate-100 rounded-lg transition-all duration-300"
                                        title="{{ $discount->is_active ? 'Deactivate' : 'Activate' }}">
                                    @if($discount->is_active)
                                        <svg class="w-5 h-5 text-orange-600 hover:text-orange-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-green-600 hover:text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                </button>
                            </form>

                            <form action="{{ route('admin.discounts.destroy', $discount) }}" 
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Delete this discount code?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-300"
                                        title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-12 px-6 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <p class="text-lg font-medium text-slate-900">No discount codes yet</p>
                            <p class="text-sm text-slate-600 font-light">Create your first discount code to get started</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($discounts->hasPages())
<div class="mt-6">
    {{ $discounts->links() }}
</div>
@endif
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