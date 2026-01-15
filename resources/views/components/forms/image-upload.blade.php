@props(['name', 'label', 'value' => null, 'required' => false])

<div class="mb-4" x-data="{ imagePreview: '{{ $value ? asset('uploads/barang/' . $value) : '' }}' }">
    <x-forms.label :for="$name" :value="$label" :required="$required" />

    <div class="mb-2" x-show="imagePreview">
        <img :src="imagePreview" class="w-32 h-32 object-cover rounded-lg border border-gray-300 shadow-sm">
    </div>

    <input type="file" name="{{ $name }}" id="{{ $name }}" accept="image/*"
        @change="imagePreview = URL.createObjectURL($event.target.files[0])"
        {{ $attributes->merge(['class' => 'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100']) }}
        @if ($required && !$value) required @endif>
    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, JPEG. Maks: 2MB.</p>

    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
