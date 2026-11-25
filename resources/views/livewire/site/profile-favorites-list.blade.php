<div class="container">
    @if($providers->isEmpty())
        <p class="text-muted text-center py-5">{{ __('site.no_data') }}</p>
    @else
        <div class="row">
            @foreach($providers as $provider)
                <div class="col-lg-3 col-md-4 col-6">
                    <x-site.provider-card :provider="$provider" :show-map-button="true" :favorite-list="true" />
                </div>
            @endforeach
        </div>
        @if($providers->hasPages())
            <div class="mt-4">
                {{ $providers->links('vendor.pagination.categories') }}
            </div>
        @endif
    @endif
</div>
