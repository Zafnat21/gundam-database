<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($pilots as $pilot)
        <article
            @click='openModal("pilot", @json($pilot))'
            class="card-animate group cursor-pointer rounded-3xl border border-slate-800/90 bg-slate-900/70 shadow-[0_10px_30px_rgba(0,0,0,0.35)] overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(15,23,42,0.55)]"
            style="animation-delay: {{ $loop->index * 90 }}ms;"
        >
            <div class="aspect-[4/3] bg-slate-800 overflow-hidden">
                @if ($pilot->image_url)
                    <img
                        src="{{ $pilot->image_url }}"
                        alt="{{ $pilot->name }}"
                        class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.03]"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-500">
                        No Image
                    </div>
                @endif
            </div>

            <div class="p-5 space-y-4">
                <div class="space-y-2">
                    <h2 class="text-xl font-semibold text-slate-100">{{ $pilot->name }}</h2>
                    <p class="text-sm text-slate-400 line-clamp-2">
                        {{ $pilot->description }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach (explode(',', $pilot->tags ?? '') as $tag)
                        @if (trim($tag) !== '')
                            <span class="px-3 py-1 text-xs rounded-full border border-slate-700 bg-slate-800/90 text-slate-200">
                                {{ trim($tag) }}
                            </span>
                        @endif
                    @endforeach
                </div>

                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.22em] text-slate-500">Related Mobile Suits</p>

                    <div class="flex gap-3 overflow-x-auto pb-1">
                        @foreach ($pilot->mobileSuits as $mobileSuit)
                            <div class="min-w-[72px] max-w-[72px]">
                                <div class="rounded-2xl overflow-hidden border border-slate-700 bg-slate-800 shadow-sm">
                                    @if ($mobileSuit->image_url)
                                        <img
                                            src="{{ $mobileSuit->image_url }}"
                                            alt="{{ $mobileSuit->name }}"
                                            class="w-full h-16 object-cover"
                                        >
                                    @else
                                        <div class="w-full h-16 flex items-center justify-center text-[10px] text-slate-500">
                                            No Image
                                        </div>
                                    @endif
                                </div>
                                <p class="mt-2 text-[11px] leading-tight text-slate-300 text-center line-clamp-2">
                                    {{ $mobileSuit->name }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </article>
    @endforeach
</div>