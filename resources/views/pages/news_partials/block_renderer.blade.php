@php
    $isBuilderPreview = $isBuilderPreview ?? false;
@endphp

@if (($block['type'] ?? '') === 'text')
    <section class="mb-10">
        @if (!empty($block['heading']))
            <h2>{{ $block['heading'] }}</h2>
        @endif

        @foreach (($block['segments'] ?? []) as $segment)
            @if (($segment['type'] ?? '') === 'list')
                <ul>
                    @foreach (($segment['items'] ?? []) as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @else
                <p>{{ $segment['content'] ?? '' }}</p>
            @endif
        @endforeach
    </section>
@elseif (($block['type'] ?? '') === 'image' && !empty($block['asset']['jpeg_url']))
    <section class="my-10">
        <figure>
            <div class="aspect-video w-full overflow-hidden rounded-2xl bg-gray-50 border border-gray-100">
                <picture>
                    @if (!empty($block['asset']['webp_url']))
                        <source srcset="{{ $block['asset']['webp_url'] }}" type="image/webp">
                    @endif
                    <img src="{{ $block['asset']['jpeg_url'] }}" alt="{{ $block['alt_text'] ?: 'Gambar berita' }}" class="w-full h-full object-cover rounded-2xl">
                </picture>
            </div>
            @if (!empty($block['caption']))
                <figcaption>{{ $block['caption'] }}</figcaption>
            @endif
        </figure>
    </section>
@elseif (($block['type'] ?? '') === 'image_showcase' && !empty($block['items']))
    @php
        $showcaseItems = collect($block['items'])
            ->filter(fn ($item) => !empty($item['asset']['jpeg_url']))
            ->map(fn ($item) => [
                'jpeg_url' => $item['asset']['jpeg_url'] ?? null,
                'webp_url' => $item['asset']['webp_url'] ?? null,
                'alt_text' => $item['alt_text'] ?: ($block['alt_text'] ?: 'Gambar berita'),
            ])
            ->values();
    @endphp
    @if ($showcaseItems->isNotEmpty())
        <div x-data="{ mainImage: @js($showcaseItems->first()), images: @js($showcaseItems->all()) }" class="my-10">
            <div x-data="{ activeIndex: 0 }" class="block sm:hidden">
                <div x-ref="slider" @scroll.debounce.50ms="activeIndex = Math.round($event.target.scrollLeft / $event.target.clientWidth); mainImage = images[activeIndex]" class="flex overflow-x-auto scroll-smooth snap-x snap-mandatory no-scrollbar">
                    <template x-for="(img, index) in images" :key="index">
                        <figure class="w-full flex-shrink-0 snap-center">
                            <div class="aspect-video w-full overflow-hidden rounded-2xl bg-gray-50 border border-gray-100">
                                <img :src="img.jpeg_url" :alt="img.alt_text" class="w-full h-full object-cover">
                            </div>
                        </figure>
                    </template>
                </div>
                <div class="flex justify-center items-center gap-2 pt-2">
                    <template x-for="(img, index) in images" :key="index">
                        <button type="button" @click="activeIndex = index; mainImage = images[index]; $refs.slider.scrollTo({ left: index * $refs.slider.clientWidth, behavior: 'smooth' })" :class="activeIndex === index ? 'w-6 bg-brand-600' : 'w-2 bg-gray-300 hover:bg-gray-400'" class="h-2 rounded-full transition-all duration-300 focus:outline-none" :aria-label="'Slide ' + (index + 1)"></button>
                    </template>
                </div>
            </div>

            <div class="hidden sm:block">
                <figure class="mb-4">
                    <div class="aspect-video w-full overflow-hidden rounded-2xl bg-gray-50 border border-gray-100">
                        <img :src="mainImage.jpeg_url" :alt="mainImage.alt_text" class="w-full h-full object-cover transition-all duration-300">
                    </div>
                </figure>

                <div class="flex gap-3 overflow-x-auto pb-2 pt-1 scroll-smooth snap-x custom-scrollbar">
                    <template x-for="(img, index) in images" :key="index">
                        <button type="button" @click="mainImage = img" :class="mainImage.jpeg_url === img.jpeg_url ? 'ring-2 ring-brand-600 opacity-100 scale-95' : 'opacity-60 hover:opacity-100'" class="relative flex-shrink-0 w-20 sm:w-24 aspect-video rounded-xl overflow-hidden transition-all duration-200 snap-center focus:outline-none">
                            <img :src="img.jpeg_url" :alt="img.alt_text" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    @endif
@elseif (($block['type'] ?? '') === 'highlight_text' && !empty($block['text']))
    <blockquote>
        {{ $block['text'] }}
    </blockquote>
@endif
