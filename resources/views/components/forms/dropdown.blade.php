@props(['name', 'label', 'options', 'selected' => null, 'required' => false, 'placeholder' => '-- Pilih Opsi --'])

<div class="mb-4">
    <x-forms.label :for="$name" :value="$label" :required="$required" />

    <select name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out sm:text-sm']) }}
        @if ($required) required @endif>
        <option value="" disabled {{ is_null($selected) ? 'selected' : '' }}>{{ $placeholder }}</option>

        @foreach ($options as $key => $optionValue)
            <option value="{{ $key }}" {{ (string) $key === (string) old($name, $selected) ? 'selected' : '' }}>
                {{ $optionValue }}
            </option>
        @endforeach
    </select>

    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
