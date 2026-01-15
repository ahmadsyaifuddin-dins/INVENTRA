@props(['name', 'label', 'value' => '', 'required' => false, 'placeholder' => ''])

<div class="mb-4">
    <x-forms.label :for="$name" :value="$label" :required="$required" />

    <textarea name="{{ $name }}" id="{{ $name }}" rows="3" placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out sm:text-sm']) }}
        @if ($required) required @endif>{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
