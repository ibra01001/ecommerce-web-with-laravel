
    <div class="p-6 bg-white rounded-xl shadow-md">
        <h1>{{ $message->subject }}</h1>

        <p>{{ $message->name }}</p>
        <p>{{ $message->email }}</p>
        <p>{{ $message->phone }}</p>
        <p>{{ $message->message }}</p>
        <p>{{ $message->created_at->format('Y-m-d H:i:s') }}</p>
        <p>{{ $message->read_at ? $message->read_at->format('Y-m-d H:i:s') : 'Not read'  }}</p>
    </div>

