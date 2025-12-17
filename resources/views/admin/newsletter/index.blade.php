@extends('admin.layout')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="flex justify-between items-center mb-8 fade-in">
    <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
        <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        Newsletter Subscribers
    </h2>

    <span class="text-slate-600 font-medium">
        Total: {{ $subscribers->count() }}
    </span>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-2xl flex items-center gap-3 fade-in">
    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

<div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm fade-in">
    @if($subscribers->isEmpty())
        <div class="text-center py-16 text-slate-500 font-light">
            No subscribers yet.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b-2 border-slate-200 text-slate-700">
                        <th class="py-4 px-3 font-medium">#</th>
                        <th class="py-4 px-3 font-medium">Email</th>
                        <th class="py-4 px-3 font-medium">Subscribed At</th>
                        <th class="py-4 px-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscribers as $subscriber)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                            <td class="py-4 px-3 text-slate-600">{{ $subscriber->id }}</td>

                            <td class="py-4 px-3 font-light text-slate-900">
                                {{ $subscriber->email }}
                            </td>

                            <td class="py-4 px-3 text-slate-600">
                                {{ \Carbon\Carbon::parse($subscriber->created_at)->format('d M Y, H:i') }}
                            </td>

                            <td class="py-4 px-3 text-right">
                                <form action="{{ route('admin.newsletter.delete', $subscriber->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this subscriber?')"
                                      class="inline-block">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm font-medium">
                                <!-- Heroicon: Trash -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>

                                Delete
                            </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
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
