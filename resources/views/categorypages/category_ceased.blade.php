@extends('layouts.externalcategory')

@section('content')
    <link href="{{ asset('public/admin/css/dashlite.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha384-R334r6kryDNB/GWs2kfB6blAOyWPCxjdHSww/mo7fel+o5TM/AOobJ0QpGRXSDh4" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js"></script>
    <style>
        .break-text {
            max-width: 200px;
            /* Adjust the width as needed */
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            /* Ensure the text wraps */
        }
    </style>
    <section class="gd-main-container">
        <div class="hd-container">

        </div>
        <div class="gl-flex">
            <div class="tabs">
                <div class="current">
                  
                        <p class="current-active" style="font-size: 24px;">A-Z {{ $category->name }} </p>
                   

                </div>
                <div class="active-line">
                    <div class="line-active"></div>
                    <div class="line-inactive"></div>
                </div>
            </div>


            <a href="{{ url()->previous() }}">
                <div class="button-container-sb">
                    <div class="gradient-buttons">
                        <div class="gradient-button-content">
                            <div>
                                < Go back</div>
                                    {{-- <img src="{{ asset('public/users/assets/Arrow - Left.svg') }}" alt="FMDQ Logo" /> --}}
                            </div>
                        </div>
                    </div>
            </a>

        </div>
        @include('components.regulations.table-styles', ['tableId' => 'example'])
        @if (count($search) > 0 || request()->anyFilled(['search', 'letter', 'year', 'entity', 'market_product', 'status']))
            <div style="width: 100%; padding: 0 20px;">
                @include('components.filters.table-filters', [
                    'records' => $search,
                    'tableId' => 'example',
                    'options' => [
                        'showAlphabetFilter' => true,
                        'showYearFilter' => true,
                        'showEntityFilter' => true,
                        'showStatusFilter' => true,
                        'showMarketProductFilter' => true,
                        'years' => $years ?? []
                    ]
                ])
            </div>
        @endif
        @if (count($search) == 0)
            <img src="{{ asset('public/users/assets/illustration-search.svg') }}" alt="No document purchased illustration"
                height="250px" />
            <div class="no-doc"></div>
            <div class="get-in">
                There is no search for the word <span>“{{ $title }}”</span>, refine
                your search by trying another keyword
            </div>
        @else
            <div style="background-color: #fff; padding: 20px; width: 100%">
                <div class="row" style="width: 100%">
                    <div class="col-md-12">
                        @if (Auth::check())
                            @if ($isSubscribed || Auth::user()->usertype == 'internal')
                                <table id="example" class="datatable-init responsive table table-striped"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Title</th>
                                            <th style="text-align: center;">Version Number</th>
                                            <th style="text-align: center;">Issue Date</th>
                                            <th style="text-align: center;">Year</th>
                                            <th style="text-align: center;">Effective Date</th>
                                            <th style="text-align: center;">Entity</th>
                                            <th style="text-align: center;">Market Tags</th>
                                            <th>Ceased/Repealed/Amended Date </th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($search as $result)
                                            <tr>
                                                 <td class="" style="text-align: justify;">
                                                    @if ($result->doc_preview == 1 || (!empty($isViewOnly) && $isViewOnly))
                                                        <a href="#" onclick="openUniversalPdfPreview('{{ asset('public/pdf_documents/' . $result->regulation_doc) }}', '{{ addslashes($result->title) }}'); return false;">
                                                            {{ $result->title }} <em class="icon ni ni-zoom-in"></em>
                                                        </a>
                                                    @else
                                                        {{ $result->title }}
                                                    @endif
                                                </td>
                                                <td style="text-align: center">{{ $result->document_version }}</td>
                                                <td style="text-align: center">
                                                    {{ str_replace('May.', 'May', \Carbon\Carbon::parse($result->issue_date)->format('M. j, Y')) }}
                                                </td>
                                                <td style="text-align: center">{{ optional($result->year)->name }}</td>
                                                <td style="text-align: center">
                                                    {{ str_replace('May.', 'May', \Carbon\Carbon::parse($result->effective_date)->format('M. j, Y')) }}
                                                </td>
                                                <td style="text-align: center">{{ optional($result->entity)->name }}</td>
                                                <td style="text-align: center">
                                                    @php
                                                        $tags = $result->marketProductTags ?? collect();
                                                        if (($tags instanceof \Illuminate\Support\Collection ? $tags->isEmpty() : empty($tags)) && !empty($result->market_product_tag)) {
                                                            $ids = array_filter(explode(',', $result->market_product_tag));
                                                            if (!empty($ids)) {
                                                                $tags = \App\Models\MarketProductTag::whereIn('id', $ids)->get();
                                                            }
                                                        }
                                                    @endphp
                                                    @if($tags && $tags->count())
                                                        @foreach($tags as $tag)
                                                            <span class="badge badge-info" style="margin: 0 2px;">{{ $tag->name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="badge badge-secondary">None</span>
                                                    @endif
                                                </td>
                                                <td style="text-align: center">{{ $result->ceased_date }}</td>
                                                <td class="tb-odr-action"
                                                    style="display: flex !important; align-items: center; justify-content: center">
                                                    <div style="display: flex !important; align-items: center; justify-content: center" class="tb-odr-btns d-none d-sm-inline">





                                                        @if ($isSubscribed || Auth::user()->usertype == 'internal')
                                                            @if (!empty($isViewOnly) && $isViewOnly)
                                                                <a href="#" onclick="openUniversalPdfPreview('{{ asset('public/pdf_documents/' . $result->regulation_doc) }}', '{{ addslashes($result->title) }}'); return false;"
                                                                    class="btn btn-icon btn-white btn-dim btn-sm btn-primary" title="View Document Preview">
                                                                    <em class="icon ni ni-book-read"></em>
                                                                </a>
                                                            @else
                                                                <a href="{{ asset('public/pdf_documents/' . $result->regulation_doc) }}"
                                                                    target="_blank"
                                                                    class="btn btn-icon btn-white btn-dim btn-sm btn-primary">
                                                                    <em class="icon ni ni-book-read"></em>
                                                                </a>

                                                                <a href="{{ route('download', $result->id) }}"
                                                                    class="btn btn-icon btn-white btn-dim btn-sm btn-primary"><em
                                                                        class="icon ni ni-download"></em></a>
                                                            @endif
                                                        @else
                                                            @if (Auth::check())
                                                                <a href="{{ route('subscribe') }}" target="_blank"
                                                                    class="btn btn-icon btn-white btn-dim btn-sm btn-primary">
                                                                    <em class="icon ni ni-book-read"></em>
                                                                </a>
                                                                <a href="{{ route('subscribe') }}"
                                                                    class="btn btn-icon btn-white btn-dim btn-sm btn-primary"><em
                                                                        class="icon ni ni-download"></em></a>
                                                            @else
                                                                <a href="{{ route('login') }}" target="_blank"
                                                                    class="btn btn-icon btn-white btn-dim btn-sm btn-primary">
                                                                    <em class="icon ni ni-book-read"></em>
                                                                </a>
                                                                <a href="{{ route('login') }}"
                                                                    class="btn btn-icon btn-white btn-dim btn-sm btn-primary"><em
                                                                        class="icon ni ni-download"></em></a>
                                                            @endif
                                                        @endif




                                                        <a href="#" id="submit"
                                                            onclick="document.getElementById('save-{{ $result->id }}').submit();"
                                                            class="btn btn-icon btn-white btn-dim btn-sm btn-primary"><em
                                                                class="icon ni ni-save"></em></a>






                                                        <form id="save-{{ $result->id }}"
                                                            action="{{ route('save-document', $result->id) }}"
                                                            method="POST" class="d-none" style="display: none">
                                                            @csrf

                                                        </form>




                                                    </div>

                                                </td>
                                            </tr>

                                            <!-- Modal for PDF Preview -->
                                            <div class="modal fade" id="pdfModal-{{ $result->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="pdfModalLabel-{{ $result->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-body">
                                                            <div id="pdf-viewer-{{ $result->id }}">
                                                                <canvas id="canvas-page1-{{ $result->id }}"
                                                                    class="pdf-page"></canvas>
                                                                <canvas id="canvas-page2-{{ $result->id }}"
                                                                    class="pdf-page"></canvas>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @else
                            <table id="example" class="datatable-init responsive table table-striped"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Title</th>
                                        <th style="text-align: center;">Effective Date</th>
                                        <th style="text-align: center;">Entity</th>
                                        <th style="text-align: center;">Market Tags</th>
                                        <th style="text-align: center;"><span style=" display:none">Entity</span></th>
                                        <th style="text-align: center;"><span>Action</span></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($search as $result)
                                        <tr>
                                             <td class="" style="text-align: justify;">
                                                @if ($result->doc_preview == 1 || (!empty($isViewOnly) && $isViewOnly))
                                                    <a href="#" onclick="openUniversalPdfPreview('{{ asset('public/pdf_documents/' . $result->regulation_doc) }}', '{{ addslashes($result->title) }}'); return false;">
                                                        {{ $result->title }} <em class="icon ni ni-zoom-in"></em>
                                                    </a>
                                                @else
                                                    {{ $result->title }}
                                                @endif
                                            </td>


                                            <td style="text-align: center">
                                                {{ str_replace('May.', 'May', \Carbon\Carbon::parse($result->effective_date)->format('M. j, Y')) }}
                                            </td>
                                            <td style="text-align: center">{{ optional($result->entity)->name }}</td>
                                            <td style="text-align: center">
                                                @php
                                                    $tags = $result->marketProductTags ?? collect();
                                                    if (($tags instanceof \Illuminate\Support\Collection ? $tags->isEmpty() : empty($tags)) && !empty($result->market_product_tag)) {
                                                        $ids = array_filter(explode(',', $result->market_product_tag));
                                                        if (!empty($ids)) {
                                                            $tags = \App\Models\MarketProductTag::whereIn('id', $ids)->get();
                                                        }
                                                    }
                                                @endphp
                                                @if($tags && $tags->count())
                                                    @foreach($tags as $tag)
                                                        <span class="badge badge-info" style="margin: 0 2px;">{{ $tag->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="badge badge-secondary">None</span>
                                                @endif
                                            </td>
                                            <td style="text-align: center;"><span style=" display:none">{{ $result->year->name }}</span></td>
                                            <td class="tb-odr-action"
                                                style="display: flex !important; align-items: center; justify-content: center">
                                                <div style="display: flex !important; align-items: center; justify-content: center" class="tb-odr-btns d-none d-sm-inline">





                                                    @if ($isSubscribed)
                                                        @if (!empty($isViewOnly) && $isViewOnly)
                                                            <a href="#" onclick="openUniversalPdfPreview('{{ asset('public/pdf_documents/' . $result->regulation_doc) }}', '{{ addslashes($result->title) }}'); return false;"
                                                                class="btn btn-icon btn-white btn-dim btn-sm btn-primary" title="View Document Preview">
                                                                <em class="icon ni ni-book-read"></em>
                                                            </a>
                                                        @else
                                                            <a href="{{ asset('public/pdf_documents/' . $result->regulation_doc) }}"
                                                                target="_blank"
                                                                class="btn btn-icon btn-white btn-dim btn-sm btn-primary">
                                                                <em class="icon ni ni-book-read"></em>
                                                            </a>

                                                            <a href="{{ route('download', $result->id) }}"
                                                                class="btn btn-icon btn-white btn-dim btn-sm btn-primary"><em
                                                                    class="icon ni ni-download"></em></a>
                                                        @endif
                                                    @else
                                                        @if (Auth::check())
                                                            <a href="{{ route('subscribe') }}" target="_blank"
                                                                class="btn btn-icon btn-white btn-dim btn-sm btn-primary">
                                                                <em class="icon ni ni-book-read"></em>
                                                            </a>
                                                            <a href="{{ route('subscribe') }}"
                                                                class="btn btn-icon btn-white btn-dim btn-sm btn-primary"><em
                                                                    class="icon ni ni-download"></em></a>
                                                        @else
                                                            <a href="{{ route('login') }}" target="_blank"
                                                                class="btn btn-icon btn-white btn-dim btn-sm btn-primary">
                                                                <em class="icon ni ni-book-read"></em>
                                                            </a>
                                                            <a href="{{ route('login') }}"
                                                                class="btn btn-icon btn-white btn-dim btn-sm btn-primary"><em
                                                                    class="icon ni ni-download"></em></a>
                                                        @endif
                                                    @endif




                                                    <a href="#" id="submit"
                                                        onclick="document.getElementById('save-{{ $result->id }}').submit();"
                                                        class="btn btn-icon btn-white btn-dim btn-sm btn-primary"><em
                                                            class="icon ni ni-save"></em></a>






                                                    <form id="save-{{ $result->id }}"
                                                        action="{{ route('save-document', $result->id) }}" method="POST"
                                                        class="d-none" style="display: none">
                                                        @csrf

                                                    </form>




                                                </div>

                                            </td>
                                        </tr>


                                        <div class="modal fade" id="pdfModal-{{ $result->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="pdfModalLabel-{{ $result->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="pdfModalLabel-{{ $result->id }}">
                                                            PDF
                                                            Preview</h5>
                                                        
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="pdf-viewer-{{ $result->id }}">
                                                            <canvas id="canvas-page1-{{ $result->id }}"
                                                                class="pdf-page"></canvas>
                                                            <canvas id="canvas-page2-{{ $result->id }}"
                                                                class="pdf-page"></canvas>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>

                        @endif
                    </div>
                </div>
            </div>
            <br>
            @if ($search instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-center mt-4">
                    {{ $search->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            @endif
        @endif

        <div class="gda-cards-container">



           
        </div>
    </section>
    </div>

    <script src="{{ asset('public/admin/js/bundle.js') }}"></script>
    @include('components.universal-pdf-modal')
@endsection
</div>
</body>

</html>
