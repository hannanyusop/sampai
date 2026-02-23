<div class="pickup-list-container">
    <style>
        .pickup-list-container {
            padding: 0;
        }

        /* Search & Filter Sticky Header */
        .sticky-header {
            background: var(--bg-card, white);
            box-shadow: var(--shadow, 0 2px 10px rgba(0,0,0,0.05));
        }

        /* Search Section */
        .search-section {
            padding: 16px;
            padding-bottom: 8px;
            background: var(--bg-card, white);
        }

        .search-wrap {
            position: relative;
        }

        .search-wrap input {
            width: 100%;
            height: 50px;
            padding: 14px 16px 14px 48px;
            border: 2px solid var(--border-color, #e5e5e5);
            background: var(--input-bg, #f5f6fa);
            border-radius: 14px;
            font-size: 0.95rem;
            color: var(--text-primary, #333);
            transition: all 0.2s;
        }

        .search-wrap input::placeholder {
            color: var(--text-muted, #999);
        }

        .search-wrap input:focus {
            outline: none;
            border-color: var(--accent-color, #667eea);
            background: var(--bg-card, white);
            box-shadow: 0 0 0 3px var(--accent-light, rgba(102, 126, 234, 0.1));
        }

        .search-wrap .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted, #999);
            font-size: 1.25rem;
        }

        .search-wrap .clear-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--border-color, #ddd);
            border: none;
            color: var(--text-secondary, #666);
            font-size: 0.8rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Filter Tabs */
        .filter-section {
            padding: 16px;
            padding-top: 12px;
            background: var(--bg-card, white);
        }

        .filter-tabs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding-bottom: 4px;
        }

        .filter-tabs::-webkit-scrollbar {
            display: none;
        }

        .filter-tab {
            flex: 0 0 auto;
            padding: 10px 18px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            background: var(--input-bg, #f5f6fa);
            color: var(--text-secondary, #666);
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .filter-tab:hover {
            background: var(--border-color, #eef0f8);
        }

        .filter-tab.active {
            background: linear-gradient(135deg, var(--accent-color, #667eea) 0%, var(--gradient-end, #764ba2) 100%);
            color: white;
        }

        /* Active Filters */
        .active-filters {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 16px 12px;
            background: var(--bg-card, white);
            flex-wrap: wrap;
        }

        .active-filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: var(--accent-light, rgba(102, 126, 234, 0.1));
            color: var(--accent-color, #667eea);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .active-filter-tag button {
            background: none;
            border: none;
            color: var(--accent-color, #667eea);
            cursor: pointer;
            padding: 0;
            font-size: 1rem;
            line-height: 1;
        }

        .clear-all-btn {
            background: none;
            border: none;
            color: #e53e3e;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            padding: 6px 12px;
        }

        /* Sort Options */
        .sort-section {
            padding: 0 16px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sort-label {
            font-size: 0.8rem;
            color: var(--text-muted, #888);
        }

        .sort-btn {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            background: var(--input-bg, #f5f6fa);
            color: var(--text-secondary, #666);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .sort-btn.active {
            background: var(--accent-light, rgba(102, 126, 234, 0.1));
            color: var(--accent-color, #667eea);
        }

        .sort-btn i {
            font-size: 0.7rem;
        }

        /* Pickup Cards */
        .pickup-cards {
            padding: 0 16px 100px;
        }

        .pickup-card {
            background: var(--bg-card, white);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: var(--shadow, 0 2px 12px rgba(0,0,0,0.06));
            display: block;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
        }

        .pickup-card:hover {
            text-decoration: none;
            color: inherit;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg, 0 4px 20px rgba(0,0,0,0.1));
        }

        .pickup-card:active {
            transform: scale(0.98);
        }

        .pickup-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .pickup-code {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary, #1a1a2e);
            margin-bottom: 4px;
        }

        .pickup-trip {
            font-size: 0.8rem;
            color: var(--text-muted, #888);
        }

        .pickup-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .pickup-status.pending { background: rgba(255, 193, 7, 0.15); color: #d39e00; }
        .pickup-status.ready { background: rgba(23, 162, 184, 0.15); color: #117a8b; }
        .pickup-status.processing { background: rgba(102, 126, 234, 0.15); color: #667eea; }
        .pickup-status.delivered { background: rgba(40, 167, 69, 0.15); color: #28a745; }

        .pickup-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .pickup-detail {
            display: flex;
            align-items: center;
        }

        .detail-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--input-bg, #f5f6fa);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: var(--accent-color, #667eea);
            font-size: 1rem;
        }

        .detail-content {
            flex: 1;
            min-width: 0;
        }

        .detail-label {
            font-size: 0.7rem;
            color: var(--text-muted, #999);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .detail-value {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-primary, #1a1a2e);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Results Count */
        .results-count {
            padding: 0 16px 12px;
            font-size: 0.85rem;
            color: var(--text-muted, #888);
        }

        .results-count strong {
            color: var(--text-primary, #1a1a2e);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--input-bg, #f5f6fa);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            color: var(--text-muted, #ccc);
        }

        .empty-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary, #1a1a2e);
            margin-bottom: 8px;
        }

        .empty-text {
            font-size: 0.9rem;
            color: var(--text-muted, #888);
            margin-bottom: 24px;
        }

        .empty-btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--accent-color, #667eea) 0%, var(--gradient-end, #764ba2) 100%);
            color: white;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            gap: 8px;
        }

        .empty-btn:hover {
            color: white;
            text-decoration: none;
        }

        /* Pagination */
        .pagination-wrap {
            padding: 16px;
        }

        .pagination-wrap .pagination {
            justify-content: center;
        }

        .pagination-wrap .page-link {
            border-radius: 10px;
            margin: 0 4px;
            border: none;
            background: var(--input-bg, #f5f6fa);
            color: var(--accent-color, #667eea);
        }

        .pagination-wrap .page-item.active .page-link {
            background: linear-gradient(135deg, var(--accent-color, #667eea) 0%, var(--gradient-end, #764ba2) 100%);
            color: white;
        }

        /* Desktop */
        @media (min-width: 768px) {
            .pickup-list-container {
                max-width: 800px;
                margin: 0 auto;
            }

            .pickup-details {
                grid-template-columns: repeat(4, 1fr);
            }

            .pickup-card {
                padding: 20px;
            }
        }
    </style>

    <!-- Sticky Header (Search + Filter) -->
    <div class="sticky-header">
        <!-- Search Section -->
        <div class="search-section">
            <div class="search-wrap">
                <i class="ni ni-search search-icon"></i>
                <input type="text"
                       wire:model.debounce.300ms="code"
                       placeholder="{{ __('Search by pickup code...') }}"
                       autocomplete="off"
                       autocorrect="off"
                       autocapitalize="off"
                       spellcheck="false">
                @if($code)
                    <button type="button" wire:click="$set('code', '')" class="clear-btn">
                        <i class="ni ni-cross"></i>
                    </button>
                @endif
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-section">
            <div class="filter-tabs">
                <button type="button"
                        wire:click="$set('status', '')"
                        class="filter-tab {{ $status === '' ? 'active' : '' }}">
                    {{ __('All') }}
                </button>
                @foreach($statuses as $statusId => $statusName)
                    <button type="button"
                            wire:click="$set('status', {{ $statusId }})"
                            class="filter-tab {{ $status == $statusId ? 'active' : '' }}">
                        {{ $statusName }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    @if($code || $status !== '')
        <div class="active-filters">
            @if($code)
                <span class="active-filter-tag">
                    <i class="ni ni-search"></i> "{{ $code }}"
                    <button type="button" wire:click="$set('code', '')"><i class="ni ni-cross"></i></button>
                </span>
            @endif
            @if($status !== '')
                <span class="active-filter-tag">
                    <i class="ni ni-filter"></i> {{ $statuses[$status] ?? '' }}
                    <button type="button" wire:click="$set('status', '')"><i class="ni ni-cross"></i></button>
                </span>
            @endif
            <button type="button" wire:click="clearFilters" class="clear-all-btn">
                {{ __('Clear All') }}
            </button>
        </div>
    @endif

    <!-- Sort Options -->
    <div class="sort-section">
        <span class="sort-label">{{ __('Sort by:') }}</span>
        <button type="button" wire:click="sortBy('status')" class="sort-btn {{ $sortField === 'status' ? 'active' : '' }}">
            {{ __('Status') }}
            @if($sortField === 'status')
                <i class="ni ni-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-fill"></i>
            @endif
        </button>
        <button type="button" wire:click="sortBy('created_at')" class="sort-btn {{ $sortField === 'created_at' ? 'active' : '' }}">
            {{ __('Date') }}
            @if($sortField === 'created_at')
                <i class="ni ni-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-fill"></i>
            @endif
        </button>
        <button type="button" wire:click="sortBy('code')" class="sort-btn {{ $sortField === 'code' ? 'active' : '' }}">
            {{ __('Code') }}
            @if($sortField === 'code')
                <i class="ni ni-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-fill"></i>
            @endif
        </button>
    </div>

    <!-- Results Count -->
    @if($pickups->total() > 0)
        <div class="results-count">
            {{ __('Showing') }} <strong>{{ $pickups->firstItem() }}-{{ $pickups->lastItem() }}</strong> {{ __('of') }} <strong>{{ $pickups->total() }}</strong> {{ __('pickups') }}
        </div>
    @endif

    <!-- Pickup Cards -->
    <div class="pickup-cards">
        @forelse($pickups as $pickup)
            <a href="{{ route('frontend.user.pickup.show', encrypt($pickup->id)) }}" class="pickup-card">
                <div class="pickup-header">
                    <div>
                        <div class="pickup-code">{{ $pickup->code }}</div>
                        <div class="pickup-trip">{{ __('Trip') }}: {{ $pickup->trip->code ?? '-' }}</div>
                    </div>
                    @php
                        $statusClass = match($pickup->status) {
                            1 => 'pending',
                            2 => 'ready',
                            3 => 'delivered',
                            4 => 'processing',
                            default => 'pending'
                        };
                    @endphp
                    <span class="pickup-status {{ $statusClass }}">{{ $pickup->status_label }}</span>
                </div>
                <div class="pickup-details">
                    <div class="pickup-detail">
                        <div class="detail-icon">
                            <i class="ni ni-map-pin"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">{{ __('Drop Point') }}</div>
                            <div class="detail-value">{{ $pickup->dropPoint->code ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="pickup-detail">
                        <div class="detail-icon">
                            <i class="ni ni-building"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">{{ __('Office') }}</div>
                            <div class="detail-value">{{ $pickup->dropPoint->name ?? '-' }}</div>
                        </div>
                    </div>
                    @if($pickup->pickup_name)
                    <div class="pickup-detail">
                        <div class="detail-icon">
                            <i class="ni ni-user"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">{{ __('Pickup By') }}</div>
                            <div class="detail-value">{{ $pickup->pickup_name }}</div>
                        </div>
                    </div>
                    @endif
                    @if($pickup->pickup_datetime)
                    <div class="pickup-detail">
                        <div class="detail-icon">
                            <i class="ni ni-calendar"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">{{ __('Pickup Date') }}</div>
                            <div class="detail-value">{{ $pickup->pickup_datetime }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </a>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="ni ni-package"></i>
                </div>
                <div class="empty-title">{{ __('No Pickups Found') }}</div>
                <div class="empty-text">
                    @if($code || $status !== '')
                        {{ __('No pickups match your search criteria.') }}
                    @else
                        {{ __('You don\'t have any pickups yet.') }}
                    @endif
                </div>
                @if($code || $status !== '')
                    <button type="button" wire:click="clearFilters" class="empty-btn">
                        <i class="ni ni-reload"></i>
                        {{ __('Clear Filters') }}
                    </button>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($pickups->hasPages())
        <div class="pagination-wrap">
            {{ $pickups->links() }}
        </div>
    @endif

    <!-- SweetAlert for Success/Error Messages -->
    @if(session('flash_success') || session('success') || session('flash_danger') || session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('flash_success') || session('success'))
            Swal.fire({
                icon: 'success',
                title: '{{ __("Success") }}',
                text: '{{ session("flash_success") ?? session("success") }}',
                confirmButtonColor: '#667eea'
            });
        @endif

        @if(session('flash_danger') || session('error'))
            Swal.fire({
                icon: 'error',
                title: '{{ __("Error") }}',
                text: '{{ session("flash_danger") ?? session("error") }}',
                confirmButtonColor: '#667eea'
            });
        @endif
    </script>
    @endif
</div>
