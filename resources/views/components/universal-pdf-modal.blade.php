<!-- Universal PDF Preview Modal for View-Only Access -->
<div class="modal fade" id="universalPdfModal" tabindex="-1" role="dialog" aria-labelledby="universalPdfModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 14px; overflow: hidden; box-shadow: 0 15px 40px rgba(0,0,0,0.3); border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #0c2b70 0%, #1a3a8f 100%); color: #ffffff; padding: 14px 20px; border-bottom: none;">
                <div class="d-flex align-items-center">
                    <em class="icon ni ni-book-read mr-2" style="font-size: 20px;"></em>
                    <h5 class="modal-title text-white mb-0" id="universalPdfModalLabel" style="font-size: 15px; font-weight: 600; line-height: 1.3;">
                        Document Preview
                    </h5>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.9; font-size: 24px; line-height: 1; border: none; background: transparent;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: center; max-height: 78vh; overflow-y: auto; background: #525659; padding: 20px;">
                <div id="universal-pdf-spinner" class="py-5 text-center">
                    <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
                        <span class="sr-only">Loading document...</span>
                    </div>
                    <div class="text-white mt-3" style="font-size: 14px; font-weight: 500;">Loading document preview...</div>
                </div>
                <div id="universal-pdf-viewer" style="display: flex; flex-direction: column; align-items: center; gap: 14px;"></div>
            </div>
            <div class="modal-footer" style="padding: 10px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <span class="badge badge-dim badge-primary" style="font-size: 11px; padding: 5px 10px;">
                    <em class="icon ni ni-shield-check mr-1"></em> Student Research &bull; View-Only Mode
                </span>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        if (typeof window['pdfjs-dist/build/pdf'] === 'undefined') {
            var script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js';
            document.head.appendChild(script);
        }
    })();

    if (typeof window.openUniversalPdfPreview === 'undefined') {
        window.openUniversalPdfPreview = function(url, title) {
            var modal = $('#universalPdfModal');
            $('#universalPdfModalLabel').text(title || 'Document Preview');
            var viewer = document.getElementById('universal-pdf-viewer');
            var spinner = document.getElementById('universal-pdf-spinner');
            if (viewer) viewer.innerHTML = '';
            if (spinner) spinner.style.display = 'block';

            modal.modal('show');

            function loadAndRenderPdf() {
                var pdfjsLib = window['pdfjs-dist/build/pdf'];
                if (!pdfjsLib) {
                    setTimeout(loadAndRenderPdf, 200);
                    return;
                }
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';

                pdfjsLib.getDocument(url).promise.then(function(pdfDoc) {
                    if (spinner) spinner.style.display = 'none';
                    for (var pNum = 1; pNum <= pdfDoc.numPages; pNum++) {
                        (function(pageNum) {
                            pdfDoc.getPage(pageNum).then(function(page) {
                                var viewport = page.getViewport({ scale: 1.5 });
                                var canvas = document.createElement('canvas');
                                canvas.className = 'pdf-page shadow';
                                canvas.style.maxWidth = '100%';
                                canvas.style.height = 'auto';
                                canvas.style.pointerEvents = 'none';
                                canvas.style.userSelect = 'none';
                                canvas.style.webkitUserSelect = 'none';
                                var context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;
                                viewer.appendChild(canvas);
                                page.render({
                                    canvasContext: context,
                                    viewport: viewport
                                });
                            });
                        })(pNum);
                    }
                }).catch(function(err) {
                    console.error('PDF preview error:', err);
                    if (spinner) spinner.style.display = 'none';
                    if (viewer) viewer.innerHTML = '<p class="text-white py-3">Error loading preview for this document.</p>';
                });
            }

            loadAndRenderPdf();
        };
    }
</script>
