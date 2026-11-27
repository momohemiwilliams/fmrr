<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Smalot\PdfParser\Parser as PdfParser;

class Regulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'month_id', 'year_id', 'document_tag', 'alpha_id',
        'entity_id', 'category_id', 'subcategory_id', 'regulation_doc', 'regulation_doc2',
        'price', 'status', 'note', 'ceased', 'effective_date', 'issue_date',
        'document_version', 'ceased_date', 'group_id', 'doc_preview', 'doc_preview_count', 'admin_status',
        'related_docs', 'nested_related_docs', 'market_product_tag'
            ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }


    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function marketProductTags()
    {
        return $this->belongsToMany(MarketProductTag::class, 'regulation_market_product_tag');
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }



    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    public function usersWhoSaved()
    {
        return $this->belongsToMany(User::class, 'saved_documents');
    }


    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function approvals()
    {
        return $this->hasMany(DocumentApproval::class, 'regulation_id');
    }


    public function savedDocuments()
    {
        return $this->hasMany(SaveDoc::class);
    }

    // Document relationships - documents that this document relates to
    public function sourceRelationships()
    {
        return $this->hasMany(DocumentRelationship::class, 'source_document_id');
    }

    // Document relationships - documents that relate to this document
    public function relatedRelationships()
    {
        return $this->hasMany(DocumentRelationship::class, 'related_document_id');
    }

    // Get all related documents (both directions)
    public function relatedDocuments()
    {
        if ($this->cachedDirectRelationships !== null) {
            return $this->cachedDirectRelationships;
        }

        $sourceRelationships = $this->sourceRelationships()->with('relatedDocument')->get();
        $relatedRelationships = $this->relatedRelationships()->with('sourceDocument')->get();
        
        $relatedDocs = collect();
        
        foreach ($sourceRelationships as $rel) {
            if ($rel->relatedDocument) {
                $rel->relatedDocument->relationship_type = $rel->relationship_type;
                $rel->relatedDocument->relationship_notes = $rel->notes;
                $relatedDocs->push($rel->relatedDocument);
            }
        }
        
        foreach ($relatedRelationships as $rel) {
            if ($rel->sourceDocument) {
                $rel->sourceDocument->relationship_type = $rel->relationship_type;
                $rel->sourceDocument->relationship_notes = $rel->notes;
                $relatedDocs->push($rel->sourceDocument);
            }
        }
        
        return $this->cachedDirectRelationships = $relatedDocs->unique('id');
    }

    // Get version history (documents with same title but different versions)
    public function versionHistory()
    {
        return Regulation::where('title', $this->title)
            ->where('id', '!=', $this->id)
            ->orderBy('document_version', 'desc')
            ->get();
    }
    
    /**
     * Per-instance memoized related documents collection.
     */
    protected $cachedRelatedDocuments = null;
    protected $cachedFlattenedRelatedDocuments = null;
    protected $cachedDirectRelationships = null;

    /**
     * Per-request regulation lookup cache to prevent repeated queries across rows.
     */
    protected static array $regulationLookupCache = [];

    /**
     * Fetch Regulation models by IDs using the per-request cache.
     */
    private static function fetchRegulationsCached(array $ids)
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
        if (empty($ids)) {
            return collect();
        }

        $missingIds = array_values(array_diff($ids, array_keys(self::$regulationLookupCache)));
        if (!empty($missingIds)) {
            $fetched = Regulation::whereIn('id', $missingIds)->get();
            foreach ($fetched as $item) {
                self::$regulationLookupCache[$item->id] = $item;
            }
            // Mark any missing/deleted IDs as null so we don't re-query them
            foreach ($missingIds as $missingId) {
                if (!array_key_exists($missingId, self::$regulationLookupCache)) {
                    self::$regulationLookupCache[$missingId] = null;
                }
            }
        }

        $result = collect();
        foreach ($ids as $id) {
            if (!empty(self::$regulationLookupCache[$id])) {
                $result->push(clone self::$regulationLookupCache[$id]);
            }
        }
        return $result;
    }

    // Get related documents as collection with recursive nesting
    public function getRelatedDocumentsAttribute()
    {
        if ($this->cachedRelatedDocuments !== null) {
            return $this->cachedRelatedDocuments;
        }

        if (!$this->related_docs) {
            return $this->cachedRelatedDocuments = collect();
        }

        $relatedIds = array_filter(array_map('trim', explode(',', $this->related_docs)));
        $relatedDocuments = self::fetchRegulationsCached($relatedIds);

        // Track visited IDs across the whole traversal to prevent exponential O(k!) explosion
        $visitedIds = [$this->id];
        foreach ($relatedDocuments as $doc) {
            $visitedIds[] = $doc->id;
        }

        $relatedDocuments->each(function ($doc) use (&$visitedIds) {
            $doc->nested_related_documents = $this->loadNestedRelatedDocuments($doc, $visitedIds);
        });

        return $this->cachedRelatedDocuments = $relatedDocuments;
    }

    // Recursive method to load nested related documents with circular reference prevention
    private function loadNestedRelatedDocuments($document, array &$visitedIds = [], int $depth = 0)
    {
        if (!$document->related_docs || $depth >= 5) {
            return collect();
        }

        $nestedIds = array_filter(array_map('intval', explode(',', $document->related_docs)));
        $unvisitedIds = array_values(array_diff($nestedIds, $visitedIds));
        if (empty($unvisitedIds)) {
            return collect();
        }

        foreach ($unvisitedIds as $id) {
            $visitedIds[] = $id;
        }

        $nestedDocuments = self::fetchRegulationsCached($unvisitedIds);

        $nestedDocuments->each(function ($nestedDoc) use (&$visitedIds, $depth) {
            $nestedDoc->nested_related_documents = $this->loadNestedRelatedDocuments($nestedDoc, $visitedIds, $depth + 1);
        });

        return $nestedDocuments;
    }
    
    // Get all related documents using the relationship-based approach
    public function getRelatedDocumentsFromRelationshipsAttribute()
    {
        // Get documents that this document is linked to as a source
        $directlyRelated = $this->sourceRelationships()->where('is_active', true)->with('relatedDocument')->get();
        
        $result = collect();
        
        foreach ($directlyRelated as $relationship) {
            if ($relationship->relatedDocument) {
                $relationship->relatedDocument->relationship_type = $relationship->relationship_type;
                $relationship->relatedDocument->relationship_notes = $relationship->notes;
                $result->push($relationship->relatedDocument);
            }
        }
        
        return $result;
    }
    
    // Get all nested related documents using relationship-based approach
    public function getNestedRelatedDocumentsFromRelationshipsAttribute($visitedIds = [])
    {
        if (in_array($this->id, $visitedIds)) {
            return collect();
        }
        
        $visitedIds[] = $this->id;
        
        // Get directly related documents
        $directlyRelated = $this->getRelatedDocumentsFromRelationshipsAttribute();
        
        $nestedCollection = collect();
        
        foreach ($directlyRelated as $relatedDoc) {
            if (!in_array($relatedDoc->id, $visitedIds)) {
                // Add the related document to the collection
                $nestedCollection->push($relatedDoc);
                
                // Recursively get nested related documents
                $nestedRelated = $relatedDoc->getNestedRelatedDocumentsFromRelationshipsAttribute($visitedIds);
                $nestedCollection = $nestedCollection->merge($nestedRelated);
            }
        }
        
        return $nestedCollection->unique('id');
    }
    
    // Combined method to get all related documents (both simple and relationship-based)
    public function getAllRelatedDocumentsAttribute()
    {
        $simpleRelated = $this->related_documents; // Uses the existing accessor
        $relationshipBased = $this->getRelatedDocumentsFromRelationshipsAttribute();
        
        // Combine both collections and return unique documents
        return $simpleRelated->merge($relationshipBased)->unique('id');
    }
    
    // Combined method to get all nested related documents
    public function getAllNestedRelatedDocumentsAttribute($visitedIds = [])
    {
        $simpleNested = $this->nested_related_documents; // Uses existing nested accessor
        $relationshipBasedNested = $this->getNestedRelatedDocumentsFromRelationshipsAttribute($visitedIds);
        
        // Combine both collections and return unique documents
        return $simpleNested->merge($relationshipBasedNested)->unique('id');
    }
    

    
    // Direct accessor for nested_related_docs column
    public function getNestedRelatedDocsColumnAttribute()
    {
        return $this->attributes['nested_related_docs'] ?? null;
    }
    
    // Accessor to get formatted title with effective date
    public function getFormattedTitleAttribute()
    {
        if ($this->effective_date) {
            $formattedDate = \Carbon\Carbon::parse($this->effective_date)->format('M. j, Y');
            return "{$this->title} ({$formattedDate})";
        }
        return $this->title;
    }
    
    // Method to get the page count of the PDF document
    public function getPageCountAttribute()
    {
        try {
            $filePath = public_path("pdf_documents/{$this->regulation_doc}");
            if (!file_exists($filePath)) {
                return 0;
            }
            
            $parser = new PdfParser();
            $pdf = $parser->parseFile($filePath);
            return $pdf->getDetails()['Pages'] ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    // Recursive method to get all related documents in a flat collection (lineage)
    public function getFlattenedRelatedDocuments($visitedIds = [])
    {
        if (empty($visitedIds) && $this->cachedFlattenedRelatedDocuments !== null) {
            return $this->cachedFlattenedRelatedDocuments;
        }

        $visitedRef = is_array($visitedIds) ? $visitedIds : [];
        $flat = $this->collectFlattenedRelatedDocuments($visitedRef);

        $result = $flat->unique('id')->filter(function ($doc) {
            return $doc->id != $this->id;
        });

        if (empty($visitedIds)) {
            $this->cachedFlattenedRelatedDocuments = $result;
        }

        return $result;
    }

    private function collectFlattenedRelatedDocuments(array &$visitedIds, int $depth = 0)
    {
        if (in_array($this->id, $visitedIds) || $depth >= 6) {
            return collect();
        }

        $visitedIds[] = $this->id;

        // 1. Get from DocumentRelationship records (both directions)
        $relMethodDocs = $this->relatedDocuments();

        // 2. Get from related_docs column (cached per-request)
        $colDocs = collect();
        if ($this->related_docs) {
            $ids = array_filter(array_map('trim', explode(',', $this->related_docs)));
            if (!empty($ids)) {
                $colDocs = self::fetchRegulationsCached($ids);
            }
        }

        // Combine immediate relatives
        $allImmediate = $relMethodDocs->merge($colDocs)->unique('id');
        $flat = clone $allImmediate;

        // Recurse only for unvisited relatives (shared &$visitedIds prevents O(k!) blowup)
        foreach ($allImmediate as $doc) {
            if (!in_array($doc->id, $visitedIds)) {
                $nested = $doc->collectFlattenedRelatedDocuments($visitedIds, $depth + 1);
                $flat = $flat->merge($nested);
            }
        }

        return $flat;
    }
}