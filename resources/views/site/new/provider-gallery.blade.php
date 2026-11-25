@extends('site.layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
    $assetBase = asset('assets/site');
@endphp
<!-- Start Breadcrumb -->
<div class="container">
    <nav aria-label="breadcrumb" class="my-4 custom-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('site.home') }}">{{ __('site.heading.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('site.categories') }}">{{ __('site.heading.categories') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('site.provider.show', $provider) }}">{{ $providerName }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('site.heading.gallery') }}</li>
        </ol>
    </nav>
</div>
<!-- End Breadcrumb -->
@php
    $galleryItems = collect($portfolio ?? [])->flatMap(fn ($album) => $album['items'] ?? [])->values();
    $galleryTypes = $galleryItems->map(fn ($item) => in_array($item['type'] ?? '', ['video', 'audio'], true) ? $item['type'] : 'image')->unique();
@endphp
<div class="gallery-section mt-4 mb-5">
    <div class="container">
        <h1 class="gallery-page-title">{{ __('site.heading.gallery') }}</h1>
        @if($galleryItems->isNotEmpty())
            <div class="gallery-filters">
                <button type="button" class="gallery-filter-btn active" data-type="all">{{ __('site.buttons.gallery_all') }}</button>
                @foreach(['video', 'audio', 'image'] as $type)
                    @if($galleryTypes->contains($type))
                        <button type="button" class="gallery-filter-btn" data-type="{{ $type }}">{{ __('site.buttons.gallery_'.$type) }}</button>
                    @endif
                @endforeach
            </div>
            <div class="row g-4">
                @foreach($galleryItems as $item)
                    @php $type = in_array($item['type'] ?? '', ['video', 'audio'], true) ? $item['type'] : 'image'; @endphp
                    <div class="col-lg-3 col-6 gallery-item" data-type="{{ $type }}">
                        <div class="gallery-media {{ $type !== 'image' ? 'gallery-media--'.$type : '' }}"
                            style="cursor: pointer;"
                            role="button"
                            tabindex="0"
                            onclick="openMediaModal('{{ $type }}', @js($item['url']), @js($item['title'] ?? ''), @js($item['description'] ?? ''))"
                            onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();this.click();}">
                            @if($type === 'video')
                                <img src="{{ $assetBase }}/images/about.webp" class="testimonial-video-thumb" alt="{{ $item['title'] ?? '' }}" data-video-thumbnail="{{ e($item['url']) }}">
                                <span class="gallery-play"><i class="fa-solid fa-play"></i></span>
                            @elseif($type === 'audio')
                                <span class="play-audio-btn" aria-hidden="true"><i class="fa-solid fa-play"></i></span>
                                <img src="{{ $assetBase }}/images/audio-waves.png" class="waveform-img" alt="">
                            @else
                                <img src="{{ $item['url'] }}" alt="{{ $item['title'] ?? '' }}">
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <p class="text-muted">{{ __('site.no_data') ?? 'لا توجد عناصر في المعرض' }}</p>
                <a href="{{ route('site.provider.show', $provider) }}" class="btn btn-blue">{{ __('site.buttons.back') ?? 'رجوع' }}</a>
            </div>
        @endif
    </div>
</div>
<!-- Start Media Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content bg-white border-0 rounded-4 shadow">
            <div class="modal-header border-0 justify-content-end py-2 px-3">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-3 pb-4 pt-0" id="mediaModalBody"></div>
        </div>
    </div>
</div>
<!-- End Media Modal -->
@endsection

@push('scripts')
@include('site.new.partials.video-thumbnail-capture-script')
@endpush
