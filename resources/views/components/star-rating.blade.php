@php
    $fullStars = floor($rating);
    $hasHalfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp

{{-- Full stars --}}
@for ($i = 0; $i < $fullStars; $i++)
    <i class="fas fa-star"></i>
@endfor

{{-- Half star --}}
@if ($hasHalfStar)
    <i class="fas fa-star-half-alt"></i>
@endif

{{-- Empty stars --}}
@for ($i = 0; $i < $emptyStars; $i++)
    <i class="far fa-star"></i>
@endfor