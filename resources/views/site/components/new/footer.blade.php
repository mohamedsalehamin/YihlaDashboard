@php
    $assetBase = asset('assets/site');
    $landingSettings = app(\App\DefaultPanel\Settings\LandingSettings::class);
    $appPages = $landingSettings->content['site_pages'] ?? [];
    
    $pages = collect($appPages)->mapWithKeys(fn($pageId, $name) => [$name => \App\ContentModule\Models\Page::find($pageId)])->filter();
    $locale = app()->getLocale();
    $aboutSlug = $pages['about_us']->slug ?? 'about';
    $termsSlug = $pages['terms_and_conditions']->slug ?? 'terms';
    $privacySlug = $pages['privacy_policy']->slug ?? 'privacy';
    $uploadedLogo = data_get($landingSettings->logos, $locale);
    $footerLogo = $uploadedLogo && \Illuminate\Support\Facades\Storage::disk('public')->exists($uploadedLogo)
        ? asset('storage/'.$uploadedLogo)
        : $assetBase.'/images/logo_optmized.webp';
@endphp
<!-- Start Footer -->
<footer style="background: linear-gradient(rgba(0, 47, 135, 0.9), rgba(0, 47, 135, 0.9)), url({{ $assetBase }}/images/footer-bg.webp) no-repeat center center;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer-about">
                    <img src="{{ $footerLogo }}" class="img-fluid" alt="Yihla">
                    <p>{{ __('site.heading.contact_us_text') }}</p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="footer-menu">
                    <h4 class="footer-title">{{ __('site.heading.quick_links') }}</h4>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('site.home') }}">{{ __('site.heading.home') }}</a></li>
                        <li><a href="{{ route('site.categories') }}">{{ __('site.heading.categories') }}</a></li>
                        <li><a href="{{ route('site.blog') }}">{{ __('site.heading.articles') }}</a></li>
                        @if(!auth()->guard('site')->check())
                            <li><a href="{{ route('site.join') }}">{{ __('site.heading.join_us_as_a_provider') }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="footer-menu">
                    <h4 class="footer-title">{{ __('site.fields.important_links') }}</h4>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('site.page', $aboutSlug) }}">{{ __('site.heading.about_us') }}</a></li>
                        <li><a href="{{ route('site.page', $termsSlug) }}">{{ __('site.heading.terms_and_conditions') }}</a></li>
                        <li><a href="{{ route('site.page', $privacySlug) }}">{{ __('site.heading.privacy_policy') }}</a></li>
                        <li><a href="{{ route('site.faqs') }}">{{ __('site.heading.faqs') }}</a></li>
                        <li><a href="{{ route('site.contact') }}">{{ __('site.heading.contact_us') }}</a></li>
                        @if(!auth()->guard('site')->check())
                            <li><a href="{{ route('site.join') }}">{{ __('site.heading.join_us_as_a_provider') }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="footer-info footer-menu">
                    <h4 class="footer-title">{{ __('site.heading.contact_information') }}</h4>
                    <ul class="list-unstyled footer-contact-list">
                        @if(isset($settings) && ($settings->app_phone ?? null))
                            <li>
                                <a href="tel:{{ $settings->app_phone }}">
                                    <svg class="icon-phone" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                    <span dir="ltr">{{ $settings->app_phone }}</span>
                                </a>
                            </li>
                        @endif
                        @if(isset($settings) && ($settings->app_whatsapp ?? null))
                            <li>
                                <a href="https://wa.me/{{ preg_replace('/\D+/', '', $settings->app_whatsapp) }}" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span dir="ltr">{{ $settings->app_whatsapp }}</span>
                                </a>
                            </li>
                        @endif
                        @if(isset($settings) && ($settings->app_email ?? null))
                            <li>
                                <a href="mailto:{{ $settings->app_email }}">
                                    <i class="fa-regular fa-envelope icon-circle"></i>
                                    <span>{{ $settings->app_email }}</span>
                                </a>
                            </li>
                        @endif
                        @php
                            $footerSocials = collect($settings->social_links ?? [])
                                ->filter(fn ($social) => ! empty($social['link']) && ! empty($social['icon']))
                                ->map(function ($social) {
                                    $icon = str_replace(' ', '', strtolower(trim($social['icon'])));
                                    $icon = match ($icon) {
                                        'x', 'twitter', 'x-twitter' => 'x-twitter',
                                        'facebook' => 'facebook-f',
                                        'linkedin', 'linkedinin' => 'linkedin-in',
                                        default => $icon,
                                    };

                                    return ['icon' => $icon, 'link' => $social['link'], 'label' => $social['icon']];
                                });
                        @endphp
                        @if($footerSocials->isNotEmpty())
                            <li class="footer-social-row">
                                @foreach($footerSocials as $social)
                                    <a href="{{ $social['link'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}">
                                        <i class="fa-brands fa-{{ $social['icon'] }}"></i>
                                    </a>
                                @endforeach
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="copyrights">
        <div class="container">
            <div class="text-center">
                {{ __('site.heading.copyright_rights') }} <span>Yihla</span> {{ date('Y') }}
                |
                {{ __('site.heading.made_with_love_at') }}
                <a href="https://targetlines.com/" target="_blank" rel="noopener noreferrer">{{ __('site.heading.target_lines') }}</a>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->
