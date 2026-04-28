@extends('admin.layout')

@section('title', 'Contact Messages - Admin')

@section('content')
    <div class="min-h-screen py-8 px-6" style="background: var(--background-color);">
        <div class="max-w-7xl mx-auto">

            <!-- Header Section -->
            <div class="mb-8 fade-in">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <img src="{{ asset('storage/black -06.svg') }}" alt="Icon" class="w-10 h-10">
                            <h1 class="text-4xl font-light tracking-tight text-theme-text">
                                Contact Messages
                            </h1>
                        </div>
                        <p class="text-lg font-light"
                            style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                            Manage and respond to customer inquiries
                        </p>
                    </div>

                    <!-- Stats Cards -->
                    <div class="flex gap-4">
                        <div class="px-6 py-4 rounded-xl"
                            style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                            <div class="text-sm font-medium uppercase tracking-wider"
                                style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">New</div>
                            <div class="text-2xl font-light text-theme-primary mt-1">{{ $newCount }}</div>
                        </div>
                        <div class="px-6 py-4 rounded-xl"
                            style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                            <div class="text-sm font-medium uppercase tracking-wider"
                                style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Total</div>
                            <div class="text-2xl font-light text-theme-text mt-1">{{ $totalCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl flex items-center gap-3 fade-in"
                    style="background: color-mix(in srgb, #10b981 10%, transparent); border-left: 4px solid #10b981;">
                    <svg class="w-6 h-6" style="color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-theme-text font-light">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl flex items-center gap-3 fade-in"
                    style="background: color-mix(in srgb, #ef4444 10%, transparent); border-left: 4px solid #ef4444;">
                    <svg class="w-6 h-6" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-theme-text font-light">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Filter and Search Bar -->
            <div class="mb-6 fade-in">
                <form method="GET" action="{{ route('admin.contact.index') }}" class="flex flex-col md:flex-row gap-4">
                    <!-- Search Input -->
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by name, email, subject, or message..."
                            class="w-full px-6 py-4 border-2 border-transparent bg-transparent text-theme-text focus:outline-none transition-all duration-300 rounded-xl"
                            style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);"
                            onfocus="this.style.borderColor='var(--primary-color)'"
                            onblur="this.style.borderColor='transparent'">
                    </div>

                    <!-- Status Filter -->
                    <select name="status"
                        class="px-6 py-4 border-2 border-transparent bg-transparent text-theme-text focus:outline-none transition-all duration-300 rounded-xl"
                        style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);"
                        onchange="this.form.submit()" onfocus="this.style.borderColor='var(--primary-color)'"
                        onblur="this.style.borderColor='transparent'">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Messages</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                    </select>

                    <!-- Search Button -->
                    <button type="submit" class="px-8 py-4 text-white font-medium rounded-xl transition-all duration-300"
                        style="background: var(--primary-color);"
                        onmouseover="this.style.background='var(--secondary-color)'; this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.background='var(--primary-color)'; this.style.transform='translateY(0)'">
                        Search
                    </button>

                    <!-- Export Button -->
                    <a href="{{ route('admin.contact.export', request()->query()) }}"
                        class="px-8 py-4 text-theme-text font-medium rounded-xl transition-all duration-300 text-center"
                        style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);"
                        onmouseover="this.style.background='var(--primary-color)'; this.style.color='white'"
                        onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'; this.style.color='var(--text-color)'">
                        Export CSV
                    </a>
                </form>
            </div>

            <!-- Bulk Actions Bar -->
            <div id="bulkActionsBar" class="mb-6 p-4 rounded-xl hidden fade-in"
                style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                <div class="flex items-center justify-between">
                    <span class="text-theme-text font-light">
                        <span id="selectedCount">0</span> messages selected
                    </span>
                    <div class="flex gap-3">
                        <button onclick="bulkMarkAsRead()"
                            class="px-6 py-2 text-white font-medium rounded-lg transition-all duration-300"
                            style="background: var(--primary-color);"
                            onmouseover="this.style.background='var(--secondary-color)'"
                            onmouseout="this.style.background='var(--primary-color)'">
                            Mark as Read
                        </button>
                        <button onclick="bulkDelete()"
                            class="px-6 py-2 text-white font-medium rounded-lg transition-all duration-300"
                            style="background: #ef4444;" onmouseover="this.style.background='#dc2626'"
                            onmouseout="this.style.background='#ef4444'">
                            Delete Selected
                        </button>
                    </div>
                </div>
            </div>

            <!-- Messages Table -->
            <div class="rounded-2xl overflow-hidden fade-in"
                style="background: color-mix(in srgb, var(--primary-color) 3%, transparent);">
                @if($messages->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr style="background: color-mix(in srgb, var(--primary-color) 8%, transparent);">
                                    <th class="px-6 py-4 text-left">
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"
                                            class="w-5 h-5 rounded cursor-pointer">
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                        Name</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                        Email</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                        Subject</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                        Date</th>
                                    <th
                                        class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y"
                                style="border-color: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                                @foreach($messages as $message)
                                    <tr class="message-row hover:bg-opacity-50 transition-all duration-300"
                                        style="background: transparent;"
                                        onmouseover="this.style.background='color-mix(in srgb, var(--primary-color) 5%, transparent)'"
                                        onmouseout="this.style.background='transparent'">
                                        <td class="px-6 py-4">
                                            <input type="checkbox" value="{{ $message->id }}"
                                                class="message-checkbox w-5 h-5 rounded cursor-pointer"
                                                onchange="updateBulkActions()">
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($message->status === 'new')
                                                <span class="px-3 py-1 text-xs font-medium rounded-full"
                                                    style="background: color-mix(in srgb, #10b981 20%, transparent); color: #10b981;">
                                                    New
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-medium rounded-full"
                                                    style="background: color-mix(in srgb, var(--text-color) 10%, transparent); color: var(--text-color);">
                                                    Read
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-theme-text font-medium">{{ $message->name }}</div>
                                            @if($message->phone)
                                                <div class="text-sm font-light"
                                                    style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                                                    {{ $message->phone }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-theme-text font-light">{{ $message->email }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-theme-text font-light max-w-xs truncate">{{ $message->subject }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-theme-text font-light">
                                            {{ $message->created_at->format('M d, Y') }}
                                            <div class="text-sm"
                                                style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                                                {{ $message->created_at->format('h:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-2">
                                                <!-- View Button -->
                                                <button onclick="viewMessage({{ $message->id }})"
                                                    class="p-2 rounded-lg transition-all duration-300"
                                                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);"
                                                    onmouseover="this.style.background='var(--primary-color)'; this.querySelector('svg').style.color='white'"
                                                    onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'; this.querySelector('svg').style.color='var(--primary-color)'"
                                                    title="View Message">
                                                    <svg class="w-5 h-5 transition-colors" style="color: var(--primary-color);"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 rounded-lg transition-all duration-300"
                                                        style="background: color-mix(in srgb, #ef4444 10%, transparent);"
                                                        onmouseover="this.style.background='#ef4444'; this.querySelector('svg').style.color='white'"
                                                        onmouseout="this.style.background='color-mix(in srgb, #ef4444 10%, transparent)'; this.querySelector('svg').style.color='#ef4444'"
                                                        title="Delete Message">
                                                        <svg class="w-5 h-5 transition-colors" style="color: #ef4444;" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4" style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                        {{ $messages->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <svg class="w-24 h-24 mx-auto mb-4"
                            style="color: color-mix(in srgb, var(--text-color) 30%, transparent);" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-2xl font-light text-theme-text mb-2">No messages found</h3>
                        <p class="font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                            @if(request('search'))
                                Try adjusting your search criteria
                            @else
                                Messages will appear here when customers contact you
                            @endif
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Message View Modal -->
    <div id="messageModal" class="fixed inset-0 z-50 hidden items-center justify-center p-6"
        style="background: rgba(0, 0, 0, 0.5);" onclick="if(event.target === this) closeModal()">
        <div class="max-w-3xl w-full rounded-2xl overflow-hidden" style="background: var(--background-color);"
            onclick="event.stopPropagation()">
            <div id="modalContent">
                <!-- Content loaded via JavaScript -->
            </div>
        </div>
    </div>

    <!-- Bulk Action Forms (Hidden) -->
    <form id="bulkReadForm" action="{{ route('admin.contact.mark-multiple-read') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="message_ids" id="bulkReadIds">
    </form>

    <form id="bulkDeleteForm" action="{{ route('admin.contact.destroy-multiple') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <input type="hidden" name="message_ids" id="bulkDeleteIds">
    </form>

    <style>
        /* Animations */
        .fade-in {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom Checkbox Styling */
        input[type="checkbox"] {
            accent-color: var(--primary-color);
        }

        /* Modal Animation */
        #messageModal.show {
            display: flex !important;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>

    <script>
        // Select All Checkboxes
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('.message-checkbox');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
            updateBulkActions();
        }

        // Update Bulk Actions Bar
        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.message-checkbox:checked');
            const bulkBar = document.getElementById('bulkActionsBar');
            const selectedCount = document.getElementById('selectedCount');

            selectedCount.textContent = checkboxes.length;

            if (checkboxes.length > 0) {
                bulkBar.classList.remove('hidden');
            } else {
                bulkBar.classList.add('hidden');
            }
        }

        // Bulk Mark as Read
        function bulkMarkAsRead() {
            const checkboxes = document.querySelectorAll('.message-checkbox:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);

            if (ids.length === 0) return;

            document.getElementById('bulkReadIds').value = ids;
            document.getElementById('bulkReadForm').submit();
        }

        // Bulk Delete
        function bulkDelete() {
            const checkboxes = document.querySelectorAll('.message-checkbox:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);

            if (ids.length === 0) return;

            if (confirm(`Are you sure you want to delete ${ids.length} message(s)?`)) {
                document.getElementById('bulkDeleteIds').value = ids;
                document.getElementById('bulkDeleteForm').submit();
            }
        }

        // View Message Modal
        function viewMessage(id) {
            const modal = document.getElementById('messageModal');
            const modalContent = document.getElementById('modalContent');

            // Show loading state
            modalContent.innerHTML = `
                            <div class="p-12 text-center">
                                <div class="w-12 h-12 border-4 border-t-transparent rounded-full animate-spin mx-auto" style="border-color: var(--primary-color); border-top-color: transparent;"></div>
                                <p class="mt-4 text-theme-text font-light">Loading message...</p>
                            </div>
                        `;

            modal.classList.add('show');

            // Fetch message details
            fetch(`/admin/contact/show/${id}`)
                .then(response => response.text())
                .then(html => {
                    modalContent.innerHTML = html;
                })
                .catch(error => {
                    modalContent.innerHTML = `
                                    <div class="p-12 text-center">
                                        <p class="text-red-500">Error loading message</p>
                                    </div>
                                `;
                });
        }

        // Close Modal
        function closeModal() {
            const modal = document.getElementById('messageModal');
            modal.classList.remove('show');
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>

@endsection