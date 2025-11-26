@extends('custom.master')

@section('content')
<div class="container mx-auto px-4 py-6">

   <div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">{{ $epaper->title }}</h1>

    <h1 class="text-xl font-semibold text-gray-600">
       {{ $epaper->publication_date ? \Carbon\Carbon::parse($epaper->publication_date)->format('d M, Y') : '—' }}

    </h1>
</div>



    <div class="bg-white shadow rounded-lg p-4">

        {{-- TOOLBAR --}}
        <div class="flex items-center gap-3 mb-4">
            <button onclick="prevPage()" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Prev</button>
            <span class="text-sm">Page: <span id="page_num">1</span> / <span id="page_count">--</span></span>
            <button onclick="nextPage()" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Next</button>

            <div class="ml-auto flex items-center gap-2">
                <button onclick="zoomOut()" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                <button onclick="zoomIn()" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
            </div>
        </div>


        {{-- PDF Canvas --}}
        <canvas id="pdf_render" class="border w-full"></canvas>

    </div>
</div>

{{-- PDF.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<script>
    const url = "{{ $pdf }}";

    let pdfDoc = null,
        pageNum = 1,
        pageIsRendering = false,
        pageNumIsPending = null,
        scale = 1.2,
        canvas = document.getElementById('pdf_render'),
        ctx = canvas.getContext('2d');

    function renderPage(num) {
        pageIsRendering = true;

        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({ scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderCtx = {
                canvasContext: ctx,
                viewport
            };

            page.render(renderCtx).promise.then(() => {
                pageIsRendering = false;

                if (pageNumIsPending !== null) {
                    renderPage(pageNumIsPending);
                    pageNumIsPending = null;
                }
            });

            document.getElementById('page_num').textContent = num;
        });
    }

    function queueRenderPage(num) {
        if (pageIsRendering) {
            pageNumIsPending = num;
        } else {
            renderPage(num);
        }
    }

    function prevPage() {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    }

    function nextPage() {
        if (pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    }

    function zoomIn() {
        scale += 0.2;
        queueRenderPage(pageNum);
    }

    function zoomOut() {
        if (scale <= 0.4) return;
        scale -= 0.2;
        queueRenderPage(pageNum);
    }

    // Load PDF
    pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
        pdfDoc = pdfDoc_;
        document.getElementById('page_count').textContent = pdfDoc.numPages;
        renderPage(pageNum);
    });
</script>
@endsection
