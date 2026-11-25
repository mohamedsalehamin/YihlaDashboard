@extends('site.layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
@endphp
<div class="container">
    <nav style="--bs-breadcrumb-divider: '|';" aria-label="breadcrumb" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('site.home') }}">{{ __('site.heading.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('site.categories') }}">{{ __('site.heading.categories') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
        </ol>
    </nav>
</div>

<div class="common-page-wrapper category-page products-section pb-64">
    <div class="container">
        <div class="page-head"><h1 class="page-title">{{ $pageTitle }}</h1></div>

        <div class="row g-3 g-lg-4">
            @forelse($providers as $provider)
                <div class="col-6 col-md-4 col-lg-3">
                    <x-site.provider-card :provider="$provider" :show-map-button="true" />
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">{{ __('site.no_data') }}</div>
            @endforelse
        </div>

        @if($providers->hasPages())
            <div class="mt-4">
                {{ $providers->links('vendor.pagination.categories') }}
            </div>
        @endif
    </div>
</div>
@endsection
