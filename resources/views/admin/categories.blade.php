@extends('admin.layout')

@section('content')
    @php
        $categoryItems = method_exists($categories, 'getCollection') ? $categories->getCollection() : collect($categories);
        $totalCount = $categoryItems->count();
        $activeCount = $categoryItems->where('status', 'active')->count();
        $inactiveCount = $totalCount - $activeCount;
    @endphp

    <div
        class="mb-6 rounded-2xl border border-red-200 bg-gradient-to-r from-red-600 via-rose-600 to-orange-500 p-6 shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-white">Category Management</h1>
                <p class="mt-1 text-sm text-slate-200">Create, update, and organize your food categories.</p>
            </div>

            <a href="/admin/categories/create"
                class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-white/70 focus:ring-offset-1 focus:ring-offset-slate-800">
                + Add New Category
            </a>
        </div>
    </div>

    @if(session('success'))
        <div
            class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Categories</p>
            <p class="mt-2 text-2xl font-bold text-slate-800">{{ $totalCount }}</p>
        </div>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Active</p>
            <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $activeCount }}</p>
        </div>
        <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-rose-700">Inactive</p>
            <p class="mt-2 text-2xl font-bold text-rose-700">{{ $inactiveCount }}</p>
        </div>
    </div>

    <div class="mb-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="relative w-full md:max-w-md">
                <input id="categorySearch" type="text" placeholder="Search by category name or slug..."
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
            </div>
            <div class="flex items-center gap-2">
                <label for="categoryStatusFilter" class="text-sm font-medium text-slate-600">Status</label>
                <select id="categoryStatusFilter"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-rose-400 focus:ring-2 focus:ring-rose-100">
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Image
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Name
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Slug
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">Status
                        </th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-600">
                            Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse ($categories as $cat)
                        <tr class="group transition hover:bg-slate-50 category-row" data-name="{{ strtolower($cat->cat_name) }}"
                            data-slug="{{ strtolower($cat->slug) }}" data-status="{{ strtolower($cat->status) }}">
                            <td class="px-4 py-3 text-sm text-slate-700">{{ $loop->iteration }}</td>

                            <td class="px-4 py-3">
                                <img src="{{ $cat->image_url }}" alt="{{ $cat->cat_name }}"
                                    class="h-14 w-14 rounded-lg object-cover ring-1 ring-slate-200">

                            </td>

                            <td class="px-4 py-3 text-sm font-semibold text-slate-800">{{ $cat->cat_name }}</td>

                            <td class="px-4 py-3 text-sm text-slate-500">{{ $cat->slug }}</td>

                            <td class="px-4 py-3">
                                <span
                                    class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $cat->status == 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ ucfirst($cat->status) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2 ">
                                    <a href="/admin/categories/show/{{ $cat->id }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500/30"
                                        aria-label="View category" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>
                                    <a href="/admin/categories/edit/{{ $cat->id }}"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500/30"
                                        aria-label="Edit category" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 20h9" />
                                            <path d="M16.5 3.5a2.12 2.12 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                                        </svg>
                                    </a>
                                    <!-- <a href="/admin/categories/delete/{{ $cat->id }}"
                                                                                                                    onclick="return confirm('Are you sure you want to delete this category?')"
                                                                                                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500/30"
                                                                                                                    aria-label="Delete category" title="Delete">
                                                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                                                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                                                                                        stroke-linejoin="round" aria-hidden="true">
                                                                                                                        <path d="M3 6h18" />
                                                                                                                        <path d="M8 6V4h8v2" />
                                                                                                                        <path d="M19 6l-1 14H6L5 6" />
                                                                                                                        <path d="M10 11v6" />
                                                                                                                        <path d="M14 11v6" />
                                                                                                                    </svg>
                                                                                                                </a> -->
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500">
                                No categories found. Click
                                <a href="/admin/categories/create" class="font-semibold text-rose-600 hover:text-rose-800">
                                    Add New Category
                                </a>
                                to create your first category.
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noCategoryResultRow" class="hidden">
                        <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500">
                            No matching categories found for current search/filter.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if(method_exists($categories, 'links'))
        <div class="category-pagination mt-5">
            {{ $categories->links() }}
        </div>
    @endif

    <style>
        .category-pagination nav>div:first-child {
            display: none;
        }

        .category-pagination nav>div:last-child {
            display: flex;
            justify-content: center;
        }

        .category-pagination nav span[aria-current="page"] span,
        .category-pagination nav a,
        .category-pagination nav span[aria-disabled="true"] span {
            border-radius: 0.6rem;
            border: 1px solid rgb(226 232 240);
            min-width: 2.25rem;
            height: 2.25rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0 0.65rem;
            transition: all 0.2s ease;
        }

        .category-pagination nav a {
            color: rgb(51 65 85);
            background: rgb(255 255 255);
        }

        .category-pagination nav a:hover {
            border-color: rgb(165 180 252);
            background: rgb(238 242 255);
            color: rgb(67 56 202);
        }

        .category-pagination nav span[aria-current="page"] span {
            background: linear-gradient(90deg, rgb(79 70 229), rgb(99 102 241));
            border-color: rgb(79 70 229);
            color: rgb(255 255 255);
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.28);
        }

        .category-pagination nav span[aria-disabled="true"] span {
            color: rgb(148 163 184);
            background: rgb(248 250 252);
            cursor: not-allowed;
        }

        .category-pagination nav .relative.z-0.inline-flex {
            gap: 0.45rem;
            box-shadow: none;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('categorySearch');
            const statusFilter = document.getElementById('categoryStatusFilter');
            const rows = document.querySelectorAll('.category-row');
            const emptyResultRow = document.getElementById('noCategoryResultRow');
            const paginationRoot = document.querySelector('.category-pagination');

            const applyPrevNextPaginationStyle = () => {
                if (!paginationRoot) return;

                const controls = paginationRoot.querySelectorAll('a, span');

                controls.forEach((el) => {
                    const text = (el.textContent || '').trim().toLowerCase();
                    const ariaLabel = (el.getAttribute('aria-label') || '').toLowerCase();
                    const rel = (el.getAttribute('rel') || '').toLowerCase();

                    const isPrevOrNext = rel === 'prev' || rel === 'next' ||
                        ariaLabel.includes('previous') || ariaLabel.includes('next') ||
                        text.includes('previous') || text.includes('next') ||
                        text === '‹' || text === '›' || text === '<' || text === '>';

                    if (!isPrevOrNext) {
                        el.style.display = 'none';
                    }
                });
            };

            const applyFilters = () => {
                if (!searchInput || !statusFilter || !rows.length || !emptyResultRow) return;

                const query = searchInput.value.trim().toLowerCase();
                const selectedStatus = statusFilter.value;
                let visibleRows = 0;

                rows.forEach((row) => {
                    const name = row.dataset.name || '';
                    const slug = row.dataset.slug || '';
                    const status = row.dataset.status || '';

                    const matchesSearch = !query || name.includes(query) || slug.includes(query);
                    const matchesStatus = selectedStatus === 'all' || status === selectedStatus;
                    const shouldShow = matchesSearch && matchesStatus;

                    row.classList.toggle('hidden', !shouldShow);
                    if (shouldShow) visibleRows++;
                });

                emptyResultRow.classList.toggle('hidden', visibleRows !== 0);
            };

            if (searchInput && statusFilter) {
                searchInput.addEventListener('input', applyFilters);
                statusFilter.addEventListener('change', applyFilters);
            }

            applyPrevNextPaginationStyle();
        });
    </script>

@endsection