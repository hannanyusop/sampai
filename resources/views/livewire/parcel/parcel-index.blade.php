<div class="parcel-list-container">
    <style>
        .parcel-list-container {
            padding: 0;
        }

        /* Search & Filter Sticky Header */
        .sticky-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        /* Search Section */
        .search-section {
            padding: 16px;
            padding-bottom: 8px;
            background: white;
            display: block !important;
        }

        .search-wrap {
            position: relative;
            display: block !important;
            min-height: 50px;
        }

        .search-wrap input {
            width: 100%;
            height: 50px;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e5e5e5 !important;
            background: #f5f6fa !important;
            border-radius: 14px;
            font-size: 0.95rem;
            color: #333 !important;
            transition: all 0.2s;
            -webkit-appearance: none;
            appearance: none;
        }

        .search-wrap input::placeholder {
            color: #999 !important;
            opacity: 1;
        }

        .search-wrap input:focus {
            outline: none;
            background: #eef0f8;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-wrap .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
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
            background: #ddd;
            border: none;
            color: #666;
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
            background: white;
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
            background: #f5f6fa;
            color: #666;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .filter-tab:hover {
            background: #eef0f8;
        }

        .filter-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        /* Active Filters */
        .active-filters {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 16px 12px;
            background: white;
        }

        .active-filter-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .active-filter-tag button {
            background: none;
            border: none;
            color: #667eea;
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

        /* Staff Scan Button */
        .scan-btn-wrap {
            padding: 0 16px 16px;
        }

        .scan-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 14px;
            font-weight: 600;
            text-decoration: none;
            gap: 8px;
        }

        .scan-btn:hover {
            color: white;
            text-decoration: none;
            opacity: 0.95;
        }

        /* Parcel Cards */
        .parcel-cards {
            padding: 0 16px 100px;
        }

        .parcel-card {
            background: white;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            display: block;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
        }

        .parcel-card:hover {
            text-decoration: none;
            color: inherit;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .parcel-card:active {
            transform: scale(0.98);
        }

        .parcel-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .parcel-tracking {
            font-size: 1rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .parcel-code {
            font-size: 0.8rem;
            color: #888;
        }

        .parcel-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .parcel-status.registered { background: rgba(102, 126, 234, 0.1); color: #667eea; }
        .parcel-status.received { background: rgba(255, 193, 7, 0.15); color: #d39e00; }
        .parcel-status.outbound { background: rgba(23, 162, 184, 0.15); color: #117a8b; }
        .parcel-status.inbound { background: rgba(111, 66, 193, 0.15); color: #6f42c1; }
        .parcel-status.ready { background: rgba(40, 167, 69, 0.15); color: #28a745; }
        .parcel-status.delivered { background: rgba(17, 153, 142, 0.15); color: #11998e; }
        .parcel-status.returned { background: rgba(220, 53, 69, 0.15); color: #dc3545; }

        .parcel-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .parcel-detail {
            display: flex;
            align-items: center;
        }

        .detail-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #f5f6fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            color: #667eea;
            font-size: 1rem;
        }

        .detail-content {
            flex: 1;
            min-width: 0;
        }

        .detail-label {
            font-size: 0.7rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .detail-value {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1a1a2e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Results Count */
        .results-count {
            padding: 0 16px 12px;
            font-size: 0.85rem;
            color: #888;
        }

        .results-count strong {
            color: #1a1a2e;
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
            background: #f5f6fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            color: #ccc;
        }

        .empty-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 8px;
        }

        .empty-text {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 24px;
        }

        .empty-btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
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
            background: #f5f6fa;
            color: #667eea;
        }

        .pagination-wrap .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        /* Desktop */
        @media (min-width: 768px) {
            .parcel-list-container {
                max-width: 800px;
                margin: 0 auto;
            }

            .parcel-details {
                grid-template-columns: repeat(4, 1fr);
            }

            .parcel-card {
                padding: 20px;
            }
        }
    </style>

    <!-- Sticky Header (Search + Filter) -->
    <div class="sticky-header">
        <!-- Search Section -->
        <div class="search-section" style="display:block !important; visibility:visible !important; opacity:1 !important; padding:16px; padding-bottom:8px; background:white;">
            <div class="search-wrap" style="display:block !important; visibility:visible !important; opacity:1 !important; position:relative; min-height:50px;">
                <i class="ni ni-search search-icon" style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#999; font-size:1.25rem; z-index:1; pointer-events:none;"></i>
                <input type="text"
                       class="form-control"
                       wire:model.debounce.300ms="search"
                       placeholder="{{ __('Search by tracking number...') }}"
                       autocomplete="off"
                       autocorrect="off"
                       autocapitalize="off"
                       spellcheck="false"
                       style="display:block !important; visibility:visible !important; opacity:1 !important; width:100%; height:50px; padding:14px 16px 14px 48px; border:2px solid #e5e5e5 !important; border-radius:14px; background:#f5f6fa !important; font-size:16px; color:#333 !important; -webkit-appearance:none; appearance:none; position:relative; z-index:2; pointer-events:auto !important; -webkit-user-select:text !important; user-select:text !important;">
                @if($search)
                    <button type="button" wire:click="$set('search', '')" class="clear-btn" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); width:28px; height:28px; border-radius:50%; background:#ddd; border:none; color:#666; cursor:pointer; display:flex; align-items:center; justify-content:center; z-index:3;">
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
                        @php
                            $shortNames = [
                                1 => __('Registered'),
                                2 => __('Received'),
                                3 => __('Outbound'),
                                4 => __('Inbound'),
                                5 => __('Ready'),
                                6 => __('Delivered'),
                                7 => __('Returned'),
                            ];
                        @endphp
                        {{ $shortNames[$statusId] ?? $statusName }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    @if($search || $status !== '')
        <div class="active-filters">
            @if($search)
                <span class="active-filter-tag">
                    <i class="ni ni-search"></i> "{{ $search }}"
                    <button type="button" wire:click="$set('search', '')"><i class="ni ni-cross"></i></button>
                </span>
            @endif
            @if($status !== '')
                <span class="active-filter-tag">
                    <i class="ni ni-filter"></i> {{ $shortNames[$status] ?? '' }}
                    <button type="button" wire:click="$set('status', '')"><i class="ni ni-cross"></i></button>
                </span>
            @endif
            <button type="button" wire:click="clearFilters" class="clear-all-btn">
                {{ __('Clear All') }}
            </button>
        </div>
    @endif

    <!-- Staff Scan Button -->
    @if ($logged_in_user->can('staff.inhouse'))
        <div class="scan-btn-wrap">
            <a href="{{ route('admin.parcel.scan') }}" class="scan-btn">
                <i class="ni ni-qr"></i>
                <span>{{ __('Scan User QRCode') }}</span>
            </a>
        </div>
    @endif

    <!-- Results Count -->
    @if($parcels->total() > 0)
        <div class="results-count">
            {{ __('Showing') }} <strong>{{ $parcels->firstItem() }}-{{ $parcels->lastItem() }}</strong> {{ __('of') }} <strong>{{ $parcels->total() }}</strong> {{ __('parcels') }}
        </div>
    @endif

    <!-- Parcel Cards -->
    <div class="parcel-cards">
        @forelse($parcels as $parcel)
            <a href="{{ route('frontend.user.parcel.show', encrypt($parcel->id)) }}" class="parcel-card">
                <div class="parcel-header">
                    <div>
                        <div class="parcel-tracking">{{ $parcel->tracking_no }}</div>
                        <div class="parcel-code">{{ $parcel->coding }}</div>
                    </div>
                    @php
                        $statusClass = match($parcel->status) {
                            1 => 'registered',
                            2 => 'received',
                            3 => 'outbound',
                            4 => 'inbound',
                            5 => 'ready',
                            6 => 'delivered',
                            7 => 'returned',
                            default => 'registered'
                        };
                    @endphp
                    <span class="parcel-status {{ $statusClass }}">{{ $parcel->status_label }}</span>
                </div>
                <div class="parcel-details">
                    <div class="parcel-detail">
                        <div class="detail-icon">
                            <i class="ni ni-map-pin"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">{{ __('Drop Point') }}</div>
                            <div class="detail-value">{{ $parcel?->dropPoint?->name ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="parcel-detail">
                        <div class="detail-icon">
                            <i class="ni ni-user"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">{{ __('Pickup By') }}</div>
                            <div class="detail-value">{{ $parcel->pickup_name ?: '-' }}</div>
                        </div>
                    </div>
                    @if($parcel->pickup_datetime)
                    <div class="parcel-detail">
                        <div class="detail-icon">
                            <i class="ni ni-calendar"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">{{ __('Pickup Date') }}</div>
                            <div class="detail-value">{{ $parcel->pickup_datetime }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </a>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="ni ni-box"></i>
                </div>
                <div class="empty-title">{{ __('No Parcels Found') }}</div>
                <div class="empty-text">
                    @if($search || $status !== '')
                        {{ __('No parcels match your search criteria.') }}
                    @else
                        {{ __('You haven\'t registered any parcels yet.') }}
                    @endif
                </div>
                @if($search || $status !== '')
                    <button type="button" wire:click="clearFilters" class="empty-btn">
                        <i class="ni ni-reload"></i>
                        {{ __('Clear Filters') }}
                    </button>
                @else
                    <a href="{{ route('frontend.user.parcel.create') }}" class="empty-btn">
                        <i class="ni ni-plus"></i>
                        {{ __('Add Parcel') }}
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($parcels->hasPages())
        <div class="pagination-wrap">
            {{ $parcels->links() }}
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
