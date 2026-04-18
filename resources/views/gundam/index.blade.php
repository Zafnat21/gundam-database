@extends('layouts.app')

@section('title', 'My Gundam Database')

@section('content')
    <section class="mb-8">
        <div class="max-w-3xl">
            <p class="text-xs uppercase tracking-[0.28em] text-slate-500 mb-3">Archive Overview</p>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-100">Mobile Suits & Pilots</h2>
            <p class="text-slate-400 mt-3 leading-relaxed">
                Temukan berbagai Mobile Suits dan Pilots dari berbagai universe Gundam, lengkap dengan hubungan data yang saling terhubung.
            </p>
        </div>
    </section>

    <div
        x-data="{
            tab: 'mobile-suits',
            modalOpen: false,
            modalType: '',
            selectedItem: null,
            imageModalOpen: false,
            selectedImage: '',
            selectedImageAlt: '',
            allMobileSuits: @js($mobileSuits),
            allPilots: @js($pilots),

            findFullItem(type, id) {
                if (type === 'mobile-suit') {
                    return this.allMobileSuits.find(item => item.id === id) || null;
                }

                if (type === 'pilot') {
                    return this.allPilots.find(item => item.id === id) || null;
                }

                return null;
            },

            openModal(type, item) {
                this.modalType = type;
                this.selectedItem = this.findFullItem(type, item.id) || item;
                this.modalOpen = true;
                document.body.classList.add('overflow-hidden');
            },

            closeModal() {
                this.modalOpen = false;
                this.modalType = '';
                this.selectedItem = null;

                if (!this.imageModalOpen) {
                    document.body.classList.remove('overflow-hidden');
                }
            },

            openImageModal(imageUrl, imageAlt = 'Image') {
                if (!imageUrl) return;

                this.selectedImage = imageUrl;
                this.selectedImageAlt = imageAlt;
                this.imageModalOpen = true;
                document.body.classList.add('overflow-hidden');
            },

            closeImageModal() {
                this.imageModalOpen = false;
                this.selectedImage = '';
                this.selectedImageAlt = '';

                if (!this.modalOpen) {
                    document.body.classList.remove('overflow-hidden');
                }
            },

            openRelatedPilot(pilot) {
                this.modalType = 'pilot';
                this.selectedItem = this.findFullItem('pilot', pilot.id);
            },

            openRelatedMobileSuit(mobileSuit) {
                this.modalType = 'mobile-suit';
                this.selectedItem = this.findFullItem('mobile-suit', mobileSuit.id);
            }
        }"
        @keydown.escape.window="
            if (imageModalOpen) {
                closeImageModal()
            } else if (modalOpen) {
                closeModal()
            }
        "
        class="space-y-6"
    >
        <div class="flex flex-wrap gap-3">
            <button
                @click="tab = 'mobile-suits'"
                :class="tab === 'mobile-suits'
                    ? 'bg-slate-200 text-slate-950 border-slate-200'
                    : 'bg-slate-900/80 text-slate-200 border-slate-700/80 hover:bg-slate-800'"
                class="px-4 py-2.5 rounded-xl border font-medium transition"
            >
                Mobile Suits
            </button>

            <button
                @click="tab = 'pilots'"
                :class="tab === 'pilots'
                    ? 'bg-slate-200 text-slate-950 border-slate-200'
                    : 'bg-slate-900/80 text-slate-200 border-slate-700/80 hover:bg-slate-800'"
                class="px-4 py-2.5 rounded-xl border font-medium transition"
            >
                Pilots
            </button>
        </div>

        <section x-show="tab === 'mobile-suits'" x-cloak>
            @include('gundam.partials.mobile-suits-grid')
        </section>

        <section x-show="tab === 'pilots'" x-cloak>
            @include('gundam.partials.pilots-grid')
        </section>

        <!-- Main Modal Overlay -->
        <div
            x-show="modalOpen"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-sm"
            @click="closeModal()"
        ></div>

        <!-- Main Modal -->
        <div
            x-show="modalOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
        >
            <div
                @click.stop
                class="w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-3xl border border-slate-700 bg-slate-900 shadow-[0_25px_80px_rgba(2,6,23,0.7)]"
            >
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-800">
                    <div>
                        <p
                            class="text-xs uppercase tracking-[0.25em] text-slate-500"
                            x-text="modalType === 'mobile-suit' ? 'Mobile Suit Detail' : 'Pilot Detail'"
                        ></p>
                        <h3
                            class="text-lg font-semibold text-slate-100"
                            x-text="selectedItem?.name || 'Detail'"
                        ></h3>
                    </div>

                    <button
                        @click="closeModal()"
                        class="inline-flex items-center justify-center w-10 h-10 rounded-2xl border border-slate-700 bg-slate-800/90 text-slate-300 hover:bg-slate-700 hover:text-white transition"
                    >
                        ✕
                    </button>
                </div>

                <div class="p-6 space-y-5">
                    <button
                        type="button"
                        class="w-full rounded-3xl overflow-hidden border border-slate-800 bg-slate-800 group cursor-zoom-in"
                        @click="openImageModal(selectedItem?.image_url, selectedItem?.name)"
                    >
                        <template x-if="selectedItem?.image_url">
                            <img
                                :src="selectedItem?.image_url"
                                :alt="selectedItem?.name"
                                class="w-full h-[280px] md:h-[420px] object-cover transition duration-500 group-hover:scale-[1.02]"
                            >
                        </template>

                        <template x-if="!selectedItem?.image_url">
                            <div class="w-full h-[280px] md:h-[420px] flex items-center justify-center text-slate-500">
                                No Image
                            </div>
                        </template>
                    </button>

                    <div class="space-y-3">
                        <h4 class="text-2xl md:text-3xl font-bold text-slate-100" x-text="selectedItem?.name"></h4>

                        <div class="flex flex-wrap gap-2">
                            <template x-for="tag in (selectedItem?.tags || '').split(',').map(tag => tag.trim()).filter(Boolean)" :key="tag">
                                <span class="px-3 py-1 text-xs rounded-full border border-slate-700 bg-slate-800/90 text-slate-200" x-text="tag"></span>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p
                            class="text-xs uppercase tracking-[0.25em] text-slate-500"
                            x-text="modalType === 'mobile-suit' ? 'Related Pilots' : 'Related Mobile Suits'"
                        ></p>

                        <div class="flex gap-3 overflow-x-auto pb-2">
                            <template x-if="modalType === 'mobile-suit'">
                                <template x-for="pilot in (selectedItem?.pilots || [])" :key="pilot.id">
                                    <button
                                        type="button"
                                        @click="openRelatedPilot(pilot)"
                                        class="min-w-[88px] max-w-[88px] text-left group"
                                    >
                                        <div class="rounded-2xl overflow-hidden border border-slate-700 bg-slate-800 transition hover:border-slate-500 hover:-translate-y-0.5">
                                            <template x-if="pilot.image_url">
                                                <img :src="pilot.image_url" :alt="pilot.name" class="w-full h-20 object-cover transition duration-300 group-hover:scale-[1.03]">
                                            </template>

                                            <template x-if="!pilot.image_url">
                                                <div class="w-full h-20 flex items-center justify-center text-[10px] text-slate-500">
                                                    No Image
                                                </div>
                                            </template>
                                        </div>
                                        <p class="mt-2 text-[11px] leading-tight text-slate-300 text-center line-clamp-2" x-text="pilot.name"></p>
                                    </button>
                                </template>
                            </template>

                            <template x-if="modalType === 'pilot'">
                                <template x-for="mobileSuit in (selectedItem?.mobile_suits || [])" :key="mobileSuit.id">
                                    <button
                                        type="button"
                                        @click="openRelatedMobileSuit(mobileSuit)"
                                        class="min-w-[88px] max-w-[88px] text-left group"
                                    >
                                        <div class="rounded-2xl overflow-hidden border border-slate-700 bg-slate-800 transition hover:border-slate-500 hover:-translate-y-0.5">
                                            <template x-if="mobileSuit.image_url">
                                                <img :src="mobileSuit.image_url" :alt="mobileSuit.name" class="w-full h-20 object-cover transition duration-300 group-hover:scale-[1.03]">
                                            </template>

                                            <template x-if="!mobileSuit.image_url">
                                                <div class="w-full h-20 flex items-center justify-center text-[10px] text-slate-500">
                                                    No Image
                                                </div>
                                            </template>
                                        </div>
                                        <p class="mt-2 text-[11px] leading-tight text-slate-300 text-center line-clamp-2" x-text="mobileSuit.name"></p>
                                    </button>
                                </template>
                            </template>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <p class="text-xs uppercase tracking-[0.25em] text-slate-500">Description</p>
                        <p class="text-sm md:text-base leading-relaxed text-slate-300" x-text="selectedItem?.description || 'No description available.'"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Modal Overlay -->
        <div
            x-show="imageModalOpen"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-[60] bg-slate-950/90 backdrop-blur-sm"
            @click="closeImageModal()"
        ></div>

        <!-- Image Modal -->
        <div
            x-show="imageModalOpen"
            x-cloak
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-[70] flex items-center justify-center p-4"
        >
            <div @click.stop class="relative w-full max-w-6xl">
                <button
                    @click="closeImageModal()"
                    class="absolute top-3 right-3 z-10 inline-flex items-center justify-center w-11 h-11 rounded-2xl border border-slate-700 bg-slate-900/90 text-slate-300 hover:bg-slate-700 hover:text-white transition"
                >
                    ✕
                </button>

                <div class="rounded-3xl overflow-hidden border border-slate-700 bg-slate-900 shadow-[0_25px_80px_rgba(2,6,23,0.7)]">
                    <template x-if="selectedImage">
                        <img
                            :src="selectedImage"
                            :alt="selectedImageAlt"
                            class="w-full max-h-[85vh] object-contain bg-slate-950"
                        >
                    </template>
                </div>
            </div>
        </div>
    </div>
@endsection