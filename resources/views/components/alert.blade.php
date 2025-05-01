@props(['type' => 'success', 'message' => ''])

@php
$colors = [
    'success' => 'green',
    'error' => 'red',
];
$color = $colors[$type] ?? 'green';
@endphp

<div class="p-4 mb-4 border-l-4 border-{{ $color }}-500 bg-{{ $color }}-100 text-{{ $color }}-700 rounded-md">
    <div class="flex items-center justify-between">
        <p>{{ $message }}</p>
        <button onclick="this.parentElement.parentElement.remove()" class="text-{{ $color }}-500 hover:text-{{ $color }}-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
