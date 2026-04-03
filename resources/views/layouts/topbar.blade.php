<!-- ===== TOP BAR ===== -->
    <div class="top-bar" id="topBar">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-4">
                <span><i class="bi bi-telephone-fill me-1"></i> Service: +91-98765-43210</span>
                <span><i class="bi bi-tag-fill me-1"></i> Sale: +91-80800-65065</span>
            </div>
            <div class="d-flex align-items-center gap-4">
                <a href="#"><i class="bi bi-globe me-1"></i> India</a>
                <a href="#"><i class="bi bi-geo-alt me-1"></i> Store Locator</a>
                {{-- <a href="#">Contact Us</a> --}}
                @if (!empty($contactPage))
                    <a href="{{ route('pages.show', $contactPage->slug) }}">{{ $contactPage->title }}</a>
                @endif
                {{-- <a href="#">Sign In</a> --}}
            </div>
        </div>
    </div>
