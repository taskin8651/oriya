@props(['name', 'label', 'type' => 'text', 'id' => null])

@php
    $fieldId = $id ?? $name;
    $invalid = $errors->has($name);
@endphp

<div class="auth-field">
    <label for="{{ $fieldId }}">{{ $label }}</label>
    <div @class(['auth-input', 'auth-input-invalid' => $invalid])>
        <input id="{{ $fieldId }}" name="{{ $name }}" type="{{ $type }}"
            @if($invalid) aria-invalid="true" aria-describedby="{{ $fieldId }}-error" @endif
            {{ $attributes }}>

        @if($type === 'password')
            <button class="auth-password-toggle" type="button" aria-controls="{{ $fieldId }}"
                data-password-toggle data-show="{{ __('Show') }}" data-hide="{{ __('Hide') }}"
                data-field-label="{{ $label }}" hidden>{{ __('Show') }}</button>
        @endif
    </div>

    @error($name)
        <p id="{{ $fieldId }}-error" class="auth-error" role="alert">{{ $message }}</p>
    @enderror
</div>
