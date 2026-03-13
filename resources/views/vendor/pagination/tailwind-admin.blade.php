@if ($paginator->hasPages())
    <div class="flex items-center justify-between">
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center rounded-md border border-[#2a2d35] bg-[#20222a] px-4 py-2 text-sm font-medium text-gray-500 cursor-default">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-[#2a2d35] bg-[#20222a] px-4 py-2 text-sm font-medium text-gray-300 hover:text-white">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative ml-3 inline-flex items-center rounded-md border border-[#2a2d35] bg-[#20222a] px-4 py-2 text-sm font-medium text-gray-300 hover:text-white">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative ml-3 inline-flex items-center rounded-md border border-[#2a2d35] bg-[#20222a] px-4 py-2 text-sm font-medium text-gray-500 cursor-default">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-400">
                    {!! __('Hiển thị') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium text-white">{{ $paginator->firstItem() }}</span>
                        {!! __('đến') !!}
                        <span class="font-medium text-white">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('trong số') !!}
                    <span class="font-medium text-white">{{ $paginator->total() }}</span>
                    {!! __('kết quả') !!}
                </p>
            </div>

            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center rounded-l-md border border-[#2a2d35] bg-[#20222a] px-2 py-2 text-gray-500 cursor-default" aria-hidden="true">
                                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center rounded-l-md border border-[#2a2d35] bg-[#20222a] px-2 py-2 text-gray-400 hover:bg-[#2a2d35] hover:text-white focus:z-20 focus:outline-offset-0" aria-label="{{ __('pagination.previous') }}">
                            <span class="material-symbols-outlined text-[20px]">chevron_left</span>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true" class="relative inline-flex items-center border border-[#2a2d35] bg-[#20222a] px-4 py-2 text-sm font-semibold text-gray-500 cursor-default focus:outline-offset-0">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="relative z-10 inline-flex items-center bg-[#E70814] px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 outline-none">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center border border-[#2a2d35] bg-[#20222a] px-4 py-2 text-sm font-semibold text-gray-400 hover:bg-[#2a2d35] hover:text-white focus:z-20 focus:outline-offset-0 outline-none transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center rounded-r-md border border-[#2a2d35] bg-[#20222a] px-2 py-2 text-gray-400 hover:bg-[#2a2d35] hover:text-white focus:z-20 focus:outline-offset-0" aria-label="{{ __('pagination.next') }}">
                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center rounded-r-md border border-[#2a2d35] bg-[#20222a] px-2 py-2 text-gray-500 cursor-default" aria-hidden="true">
                                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                            </span>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
@endif
