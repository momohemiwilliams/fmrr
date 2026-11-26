<?php

namespace App\Traits;

use App\Models\Regulation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

trait AlphabeticalPaginatable
{
    /**
     * Helper method to perform alphabetical pagination
     */
    protected function alphabeticalPaginate($categoryId = null, $subcategoryId = null, $extraQuery = null, $targetPerPage = 20)
    {
        $query = Regulation::where('status', 1);
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        if ($subcategoryId) {
            $query->where('subcategory_id', $subcategoryId);
        }
        
        if ($extraQuery && is_callable($extraQuery)) {
            $extraQuery($query);
        }

        // Apply server-side filter query parameters across all pages
        $req = request();
        if ($req->filled('search')) {
            $search = trim($req->input('search'));
            $query->where('title', 'LIKE', "%{$search}%");
        }

        if ($req->filled('letter')) {
            $letter = strtoupper(substr(trim($req->input('letter')), 0, 1));
            $query->whereRaw('UPPER(LEFT(title, 1)) = ?', [$letter]);
        }

        if ($req->filled('year')) {
            $yearFilter = trim($req->input('year'));
            $query->whereHas('year', function ($yq) use ($yearFilter) {
                $yq->where('name', $yearFilter);
            });
        }

        if ($req->filled('entity')) {
            $entityFilter = trim($req->input('entity'));
            $query->whereHas('entity', function ($eq) use ($entityFilter) {
                $eq->where('name', $entityFilter);
            });
        }

        if ($req->filled('market_product')) {
            $mpFilter = trim($req->input('market_product'));
            $query->whereHas('marketProductTags', function ($mq) use ($mpFilter) {
                $mq->where('name', $mpFilter);
            });
        }

        if ($req->filled('status')) {
            $statusFilter = trim($req->input('status'));
            if ($statusFilter === 'Empty Space') {
                $query->where(function ($sq) {
                    $sq->whereNull('ceased')->orWhere('ceased', '');
                });
            } elseif (strcasecmp($statusFilter, 'Active') === 0) {
                $query->where(function ($sq) {
                    $sq->whereNull('ceased')
                       ->orWhere('ceased', '')
                       ->orWhere('ceased', 'Active')
                       ->orWhere('ceased', 'LIKE', '%Active%');
                });
            } else {
                $query->where('ceased', 'LIKE', "%{$statusFilter}%");
            }
        }

        // 1. Get counts of items per first letter
        $countQuery = clone $query;
        $letterCounts = $countQuery->selectRaw('UPPER(LEFT(title, 1)) as letter, count(*) as count')
            ->groupBy('letter')
            ->orderBy('letter')
            ->get();

        $pageGroups = [];
        $currentGroup = ['letters' => [], 'count' => 0];

        foreach ($letterCounts as $lc) {
            $letter = $lc->letter;
            $count = $lc->count;

            if ($currentGroup['count'] >= ($targetPerPage * 0.5)) {
                $underflowIfSplit = $targetPerPage - $currentGroup['count'];
                $overflowIfAdd = ($currentGroup['count'] + $count) - $targetPerPage;
                
                if ($overflowIfAdd >= $underflowIfSplit) {
                    $pageGroups[] = $currentGroup;
                    $currentGroup = ['letters' => [], 'count' => 0];
                }
            }

            $currentGroup['letters'][] = $letter;
            $currentGroup['count'] += $count;

            if ($currentGroup['count'] >= $targetPerPage) {
                $pageGroups[] = $currentGroup;
                $currentGroup = ['letters' => [], 'count' => 0];
            }
        }

        if (!empty($currentGroup['letters'])) {
            $pageGroups[] = $currentGroup;
        }

        $currentPage = request()->get('page', 1);
        $totalItems = $letterCounts->sum('count');
        $totalPages = count($pageGroups);
        
        $currentPage = max(1, min($currentPage, $totalPages ?: 1));
        
        $activeGroup = $pageGroups[$currentPage - 1] ?? ['letters' => [], 'count' => 0];
        $activeLetters = $activeGroup['letters'];

        // 2. Fetch only items for the active letters on this "page"
        $regItems = $query->whereIn(DB::raw('UPPER(LEFT(title, 1))'), $activeLetters)
            ->with(['year', 'entity', 'category', 'subcategory', 'marketProductTags'])
            ->orderBy('title', 'asc')
            ->get();

        // 3. Create a LengthAwarePaginator
        $logicalPerPage = $totalPages > 0 ? ceil($totalItems / $totalPages) : $targetPerPage;

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $regItems,
            $totalItems,
            $logicalPerPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
