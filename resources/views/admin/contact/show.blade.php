<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-start">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $message->subject }}</h1>
            <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-600">
                <span class="flex items-center">
                    <span class="font-medium mr-1 text-gray-400">From:</span> {{ $message->name }}
                </span>
                <span class="flex items-center">
                    <span class="font-medium mr-1 text-gray-400">Email:</span>
                    <a href="mailto:{{ $message->email }}"
                        class="text-blue-600 hover:underline">{{ $message->email }}</a>
                </span>
                @if($message->phone)
                    <span class="flex items-center">
                        <span class="font-medium mr-1 text-gray-400">Phone:</span> {{ $message->phone }}
                    </span>
                @endif
            </div>
        </div>
        <div class="flex flex-col items-end gap-2">
            <span
                class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $message->read_at ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                {{ $message->read_at ? 'Read' : 'New Message' }}
            </span>
            <time class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</time>
        </div>
    </div>

    <div class="p-8 bg-gray-50/50">
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Message Body</h3>
        <div class="text-gray-700 leading-relaxed whitespace-pre-wrap text-lg">
            {{ $message->message }}
        </div>
    </div>

    <div class="px-6 py-4 bg-white border-t border-gray-100 flex justify-between text-xs text-gray-500 italic">
        <span>Received on {{ $message->created_at->format('F j, Y \a\t g:i A') }}</span>
        @if($message->read_at)
            <span>Opened on {{ $message->read_at->format('F j, Y \a\t g:i A') }}</span>
        @endif
    </div>
</div>