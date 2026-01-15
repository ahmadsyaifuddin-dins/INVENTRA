@props(['name', 'label', 'value' => '', 'type' => 'text', 'required' => false, 'placeholder' => ''])

<div class="mb-4">
    <x-forms.label :for="$name" :value="$label" :required="$required" />

    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out sm:text-sm']) }}
        @if ($required) required @endif>

    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
