@php
    $options = $options ?? $filterOptions ?? [];
    $showFilters = $showFilters ?? true;
    $hasActiveFilters = request()->filled('search')
        || request()->filled('letter')
        || request()->filled('year')
        || request()->filled('entity')
        || request()->filled('market_product')
        || request()->filled('status');
@endphp

@if($showFilters)
<style>
    .fmdq-filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 18px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .fmdq-filter-row {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 12px;
    }

    .fmdq-filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1 1 140px;
        min-width: 130px;
    }

    .fmdq-filter-group.is-search {
        flex: 1.5 1 200px;
        min-width: 180px;
    }

    .fmdq-filter-group label {
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        margin: 0;
        letter-spacing: 0.2px;
    }

    .fmdq-filter-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .fmdq-filter-input-icon {
        position: absolute;
        left: 11px;
        color: #94a3b8;
        pointer-events: none;
        display: inline-flex;
        align-items: center;
    }

    .fmdq-filter-control {
        width: 100%;
        height: 40px;
        padding: 0 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #ffffff;
        color: #1e293b;
        font-size: 13.5px;
        outline: none;
        transition: border-color 0.18s ease, box-shadow 0.18s ease;
        box-sizing: border-box;
    }

    .fmdq-filter-control.has-icon {
        padding-left: 34px;
    }

    .fmdq-filter-control:focus {
        border-color: #0c2b70;
        box-shadow: 0 0 0 3px rgba(12, 43, 112, 0.12);
    }

    .fmdq-filter-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .fmdq-btn-submit {
        height: 40px;
        padding: 0 18px;
        background: #0c2b70;
        color: #ffffff !important;
        border: 1px solid #0c2b70;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.18s ease;
        white-space: nowrap;
        width: auto !important;
    }

    .fmdq-btn-submit:hover {
        background: #143ca3;
        border-color: #143ca3;
        box-shadow: 0 4px 12px rgba(12, 43, 112, 0.22);
    }

    .fmdq-btn-clear {
        height: 40px;
        padding: 0 16px;
        background: #ffffff;
        color: #475569 !important;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.18s ease;
        white-space: nowrap;
    }

    .fmdq-btn-clear:hover {
        background: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a !important;
    }

    .fmdq-active-filter-bar {
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 12.5px;
        color: #475569;
    }

    @media (max-width: 768px) {
        .fmdq-filter-group,
        .fmdq-filter-group.is-search {
            flex: 1 1 100%;
        }
        .fmdq-filter-actions {
            width: 100%;
        }
        .fmdq-btn-submit,
        .fmdq-btn-clear {
            flex: 1;
        }
    }
</style>

<form method="GET" action="{{ url()->current() }}" class="fmdq-filter-card" id="server-filter-form-{{ $tableId }}">
    <div class="fmdq-filter-row">
        @if($options['showSearchBar'] ?? true)
        <div class="fmdq-filter-group is-search">
            <label for="srv-search-{{ $tableId }}">Search</label>
            <div class="fmdq-filter-input-wrap">
                <span class="fmdq-filter-input-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input type="text" name="search" id="srv-search-{{ $tableId }}" class="fmdq-filter-control has-icon"
                       placeholder="Search by title..." value="{{ request('search') }}">
            </div>
        </div>
        @endif

        @if($options['showAlphabetFilter'] ?? true)
        <div class="fmdq-filter-group" style="flex: 0.7 1 115px; min-width: 110px;">
            <label for="srv-letter-{{ $tableId }}">First Letter</label>
            <select name="letter" id="srv-letter-{{ $tableId }}" class="fmdq-filter-control">
                <option value="">All Letters</option>
                @foreach(range('A', 'Z') as $letter)
                    <option value="{{ $letter }}" {{ strtoupper(request('letter', '')) === $letter ? 'selected' : '' }}>{{ $letter }}</option>
                @endforeach
            </select>
        </div>
        @endif

        @if(($options['showYearFilter'] ?? true) && !empty($options['years']))
        <div class="fmdq-filter-group" style="flex: 0.7 1 115px; min-width: 110px;">
            <label for="srv-year-{{ $tableId }}">Year</label>
            <select name="year" id="srv-year-{{ $tableId }}" class="fmdq-filter-control">
                <option value="">All Years</option>
                @foreach($options['years'] as $year)
                    @php
                        $yearValue = is_object($year) ? (isset($year->name) ? (string)$year->name : (string)$year) : (string)$year;
                    @endphp
                    <option value="{{ $yearValue }}" {{ request('year') === $yearValue ? 'selected' : '' }}>{{ $yearValue }}</option>
                @endforeach
            </select>
        </div>
        @endif

        @if($options['showEntityFilter'] ?? true)
        <div class="fmdq-filter-group">
            <label for="srv-entity-{{ $tableId }}">Entity</label>
            <select name="entity" id="srv-entity-{{ $tableId }}" class="fmdq-filter-control">
                <option value="">All Entities</option>
                @php
                    try {
                        $entities = \App\Models\Entity::where('status', 1)->orderBy('name')->pluck('name');
                    } catch (\Exception $e) {
                        $entities = $records->pluck('entity.name')->unique()->filter()->sort()->values();
                    }
                @endphp
                @foreach($entities as $entity)
                    @php $entityValue = is_object($entity) ? (string)$entity : $entity; @endphp
                    <option value="{{ $entityValue }}" {{ request('entity') === $entityValue ? 'selected' : '' }}>{{ $entityValue }}</option>
                @endforeach
            </select>
        </div>
        @endif

        @if($options['showMarketProductFilter'] ?? true)
        <div class="fmdq-filter-group">
            <label for="srv-mp-{{ $tableId }}">Markets and Products</label>
            <select name="market_product" id="srv-mp-{{ $tableId }}" class="fmdq-filter-control">
                <option value="">All Markets and Products</option>
                @php
                    if (!isset($options['marketProducts'])) {
                        $marketProducts = \App\Models\MarketProductTag::where('status', 1)->orderBy('name')->pluck('name');
                    } else {
                        $marketProducts = $options['marketProducts'];
                    }
                @endphp
                @foreach($marketProducts as $marketProduct)
                    @php
                        $marketProductValue = is_object($marketProduct)
                            ? (isset($marketProduct->name) ? (string)$marketProduct->name : (string)$marketProduct)
                            : (string)$marketProduct;
                    @endphp
                    <option value="{{ $marketProductValue }}" {{ request('market_product') === $marketProductValue ? 'selected' : '' }}>{{ $marketProductValue }}</option>
                @endforeach
            </select>
        </div>
        @endif

        @if($options['showStatusFilter'] ?? true)
        <div class="fmdq-filter-group" style="flex: 0.9 1 130px; min-width: 125px;">
            <label for="srv-status-{{ $tableId }}">Status</label>
            <select name="status" id="srv-status-{{ $tableId }}" class="fmdq-filter-control">
                <option value="">All Statuses</option>
                @php
                    if (!isset($options['statuses'])) {
                        try {
                            $rawStatuses = \App\Models\Regulation::select('ceased')->distinct()->pluck('ceased');
                            $statusesArray = [];
                            foreach ($rawStatuses as $rawStatus) {
                                if (is_null($rawStatus) || trim($rawStatus) === '') {
                                    if (!in_array('Empty Space', $statusesArray)) {
                                        $statusesArray[] = 'Empty Space';
                                    }
                                    continue;
                                }
                                $parts = array_filter(preg_split('/[, \/]+/', $rawStatus));
                                foreach ($parts as $part) {
                                    $part = trim($part);
                                    if (!empty($part) && !in_array($part, $statusesArray)) {
                                        $statusesArray[] = $part;
                                    }
                                }
                            }
                            sort($statusesArray);
                            if (($key = array_search('Empty Space', $statusesArray)) !== false) {
                                unset($statusesArray[$key]);
                                $statusesArray[] = 'Empty Space';
                            }
                            $statuses = $statusesArray;
                        } catch(\Exception $e) {
                            $statuses = ['Ceased', 'Repealed', 'Amended', 'Superseded', 'Empty Space'];
                        }
                    } else {
                        $statuses = $options['statuses'];
                        if (is_array($statuses) && ($key = array_search('Empty Space', $statuses)) !== false) {
                            unset($statuses[$key]);
                            $statuses[] = 'Empty Space';
                        }
                    }
                @endphp
                @foreach($statuses as $status)
                    @php
                        $statusValue = is_object($status) ? (isset($status->name) ? $status->name : (string)$status) : (string)$status;
                    @endphp
                    <option value="{{ $statusValue }}" {{ request('status') === $statusValue ? 'selected' : '' }}>
                        {{ $statusValue === 'Empty Space' ? 'Unassigned' : $statusValue }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="fmdq-filter-actions">
            <button type="submit" class="fmdq-btn-submit">
                Submit
            </button>
            <a href="{{ url()->current() }}" class="fmdq-btn-clear" id="clear-filters-{{ $tableId }}">
                Clear Filters
            </a>
        </div>
    </div>

    @if($hasActiveFilters)
        <div class="fmdq-active-filter-bar">
            <span>
                <strong style="color: #0c2b70;">Filtered Results:</strong>
                Showing {{ method_exists($records, 'total') ? number_format($records->total()) : $records->count() }} matching document(s) across all pages.
            </span>
        </div>
    @endif
</form>
@endif

<div id="search-info-{{ $tableId }}" class="search-info" style="display: none;"></div>
