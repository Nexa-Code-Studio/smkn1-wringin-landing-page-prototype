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
    <figure class="my-10 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        <picture>
            @if (!empty($block['asset']['webp_url']))
                <source srcset="{{ $block['asset']['webp_url'] }}" type="image/webp">
            @endif
            <img src="{{ $block['asset']['jpeg_url'] }}" alt="{{ $block['alt_text'] ?? 'Gambar PPDB' }}" class="max-h-[420px] w-full object-cover">
        </picture>

        @if (!empty($block['caption']))
            <figcaption class="px-5 py-4 text-center text-sm italic text-slate-500">
                {{ $block['caption'] }}
            </figcaption>
        @endif
    </figure>
@elseif (($block['type'] ?? '') === 'file' && !empty($block['asset']['original_url']))
    @php
        $fileExtension = strtoupper($block['asset']['extension'] ?? 'FILE');
        $fileIcon = match (strtolower($block['asset']['extension'] ?? '')) {
            'pdf' => 'fa-file-pdf text-red-500',
            'doc', 'docx' => 'fa-file-word text-blue-600',
            'xls', 'xlsx' => 'fa-file-excel text-emerald-600',
            'zip' => 'fa-file-zipper text-amber-500',
            default => 'fa-file-lines text-slate-500',
        };
        $fileUrl = $isBuilderPreview ? '#' : $block['asset']['original_url'];
    @endphp

    <section class="my-10 rounded-2xl border border-brand-100 bg-brand-50 p-5 shadow-sm transition hover:shadow-md">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl border border-slate-100 bg-white text-3xl shadow-sm">
                    <i class="fa-solid {{ $fileIcon }}"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold leading-tight text-slate-900">{{ $block['label'] ?? '' }}</h3>
                    @if (!empty($block['description']))
                        <p class="mt-1 text-sm text-slate-500">{{ $block['description'] }}</p>
                    @endif
                    <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-slate-500">
                        <span><i class="fa-solid fa-file mr-1"></i>{{ $fileExtension }}</span>
                        <span>•</span>
                        <span><i class="fa-solid fa-hard-drive mr-1"></i>{{ $block['asset']['size_label'] ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ $fileUrl }}" @if (! $isBuilderPreview) target="_blank" rel="noopener noreferrer" @endif class="inline-flex w-full flex-shrink-0 items-center justify-center gap-2 rounded-xl bg-brand px-6 py-2.5 text-center font-bold text-white transition hover:bg-brand-700 sm:w-auto">
                {{ $block['button_text'] ?? 'Unduh File' }}
                <i class="fa-solid fa-arrow-down"></i>
            </a>
        </div>
    </section>
@elseif (($block['type'] ?? '') === 'link' && !empty($block['url']) && !empty($block['label']))
    @php
        $isOutline = ($block['style_variant'] ?? 'brand') === 'outline';
        $linkUrl = $isBuilderPreview ? '#' : $block['url'];
    @endphp

    <section class="my-8">
        <a href="{{ $linkUrl }}" @if (! $isBuilderPreview) target="_blank" rel="noopener noreferrer" @endif class="group inline-flex w-full items-center justify-between rounded-xl border-2 p-4 text-left text-lg transition hover:shadow-md {{ $isOutline ? 'border-slate-200 bg-white hover:border-secondary' : 'border-brand/20 bg-white hover:border-brand' }}">
            <div>
                <span class="block font-bold {{ $isOutline ? 'text-slate-700 group-hover:text-slate-900' : 'text-brand group-hover:text-brand-700' }}">{{ $block['label'] }}</span>
                @if (!empty($block['description']))
                    <span class="mt-1 block text-sm font-medium text-slate-500">{{ $block['description'] }}</span>
                @endif
            </div>
            <div class="ml-4 flex h-8 w-8 items-center justify-center rounded-full transition {{ $isOutline ? 'bg-slate-100 text-slate-500 group-hover:bg-secondary group-hover:text-white' : 'bg-brand-50 text-brand group-hover:bg-brand group-hover:text-white' }}">
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </a>
    </section>
@endif
