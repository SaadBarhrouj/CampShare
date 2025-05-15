<div id="rental-requests-list">
    @foreach($data as $request)
        <div class="p-4 border-b dark:border-gray-700">
            <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ $request->title }}</h3>
            <p class="text-gray-700 dark:text-gray-300">{{ $request->description }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Prix: {{ $request->price_per_day }} MAD | Statut: {{ $request->status }}</p>
        </div>
    @endforeach
</div>