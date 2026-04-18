<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($pilots as $pilot)
        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-lg">
            <div class="aspect-[4/3] bg-zinc-800">
                @if ($pilot->image_url)
                    <img
                        src="{{ $pilot->image_url }}"
                        alt="{{ $pilot->name }}"
                        class="w-full h-full object-cover"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center text-zinc-500">
                        No Image
                    </div>
                @endif
            </div>

            <div class="p-5 space-y-3">
                <h2 class="text-xl font-semibold">{{ $pilot->name }}</h2>

                <p class="text-sm text-zinc-400 line-clamp-2">
                    {{ $pilot->description }}
                </p>

                <div class="flex flex-wrap gap-2">
                    @foreach (explode(',', $pilot->tags ?? '') as $tag)
                        @if (trim($tag) !== '')
                            <span class="px-3 py-1 text-xs rounded-full bg-zinc-800 text-zinc-200">
                                {{ trim($tag) }}
                            </span>
                        @endif
                    @endforeach
                </div>

                <div>
                    <p class="text-sm text-zinc-400 mb-2">Mobile Suits</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($pilot->mobileSuits as $mobileSuit)
                            <span class="px-3 py-1 text-xs rounded-full bg-blue-950 text-blue-200 border border-blue-800">
                                {{ $mobileSuit->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>