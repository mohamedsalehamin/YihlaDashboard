<div>
    @if($successMessage)
        <div class="alert alert-success mb-4" role="alert">{{ $successMessage }}</div>
    @endif

    <form wire:submit.prevent="save" class="contact-form">
        <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" id="name" wire:model="name" placeholder="{{ __('site.fields.name') }}" aria-label="{{ __('site.fields.name') }}">
                @error('name')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-md-6 mb-3">
                @include('livewire._phone-input')
                @error('phone')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <input type="email" class="form-control" id="email" wire:model="email" placeholder="{{ __('site.fields.email') }}" aria-label="{{ __('site.fields.email') }}">
                @error('email')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <select class="form-select" id="messageType" wire:model="contact_type_id" aria-label="{{ __('site.fields.contact_type') }}">
                    <option value="">{{ __('site.fields.contact_type') }}</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('contact_type_id')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-12 mb-3">
                <input type="text" class="form-control" id="messageTitle" wire:model="title" placeholder="{{ __('site.fields.message_title') }}" aria-label="{{ __('site.fields.message_title') }}">
                @error('title')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-12 mb-3">
                <textarea class="form-control" id="messageBody" rows="5" wire:model="message" placeholder="{{ __('site.fields.message') }}" aria-label="{{ __('site.fields.message') }}"></textarea>
                @error('message')<p class="text-danger small mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <button type="submit" class="btn btn-green w-100" wire:loading.attr="disabled">
            <span wire:loading.class="invisible">{{ __('site.buttons.send')  }}</span>
            <span wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
    </form>
</div>

@script
<script>
    $wire.on('resetContactForm', () => {
        document.querySelector('.contact-form')?.reset();
    });
</script>
@endscript
