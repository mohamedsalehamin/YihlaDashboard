@extends('site.layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
    $landingSettings = app(\App\DefaultPanel\Settings\LandingSettings::class);
    $isAboutPage = (int) data_get($landingSettings->content, 'site_pages.about_us') === (int) $page->id;
    // The About page's top content and image come from the page itself (not from the home section settings)
    $pageIntro = $isAboutPage ? trim((string) $page->getTranslation('intro', $locale, false)) : '';
    $pageImageRaw = $isAboutPage ? (string) $page->image : '';
    $pageImage = $pageImageRaw === ''
        ? asset('assets/site/images/about.webp')
        : (str_starts_with($pageImageRaw, 'http') ? $pageImageRaw : \Illuminate\Support\Facades\Storage::url($pageImageRaw));
@endphp

<!-- Start Breadcrumb -->
<div class="container">
    <nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('site.home') }}">{{ __('site.heading.home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $page->getTranslation('title', $locale) }}</li>
        </ol>
    </nav>
</div>
<!-- End Breadcrumb -->

<div class="common-page-wrapper pb-64">
    <div class="container">
        <div class="text-center">
            <h1 class="section-title mb-5">{{ $page->getTranslation('title', $locale) }}</h1>
        </div>

        @if($isAboutPage && ($pageIntro !== '' || $pageImageRaw !== ''))
            <div class="row align-items-md-center mb-5">
                <div class="col-lg-6">
                    <div class="about-wrapper">
                        <div class="about-content">
                            <p class="description">{{ $pageIntro }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <img src="{{ $pageImage }}" loading="lazy" alt="{{ $page->getTranslation('title', $locale) }}" class="about-img img-fluid">
                </div>
            </div>
        @endif

        <div class="page-content">
            {!! $page->getTranslation('description', $locale) !!}
        </div>
    </div>
</div>

@endsection
