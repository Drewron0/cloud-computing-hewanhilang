<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SatwaTrace - Registrasi & Pencarian Satwa Hilang</title>

    <!-- Google Fonts: DM Sans & Fraunces -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        satwa: {
                            bg: '#F6F3EA',
                            card: '#FCFAF4',
                            text: '#172B20',
                            muted: '#52594F',
                            forest: '#172E21',
                            olive: '#4D6448',
                            terracotta: '#BA4E28',
                            terracottaDark: '#A3401E',
                            ochre: '#C7902E',
                            sand: '#EAE5D5',
                            line: '#DCD6C6',
                            softgreen: '#E0E7DC',
                            softorange: '#F5E4DA'
                        }
                    },
                    fontFamily: {
                        heading: ['Fraunces', 'Georgia', 'serif'],
                        body: ['DM Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Dedicated Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/satwatrace.css') }}">
</head>
<body class="flex min-h-screen flex-col antialiased">

    <!-- Navbar Component -->
    @include('components.navbar')

    <!-- Main Content Slot -->
    <main class="mx-auto w-full max-w-[1400px] flex-1 px-4 pb-12 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer Component -->
    @include('components.footer')

    <!-- Detail Modal -->
    @include('animals.partials.detail-modal')

    <!-- Core Interactive Client Scripts -->
    <script>
        let currentModalReportId = null;
        const $ = (id) => document.getElementById(id);

        function switchMainTab(tab) {
            const isMarketplace = tab === 'marketplace';

            const viewMarketplace = $('view-marketplace');
            const viewReport = $('view-report');

            if (viewMarketplace) viewMarketplace.classList.toggle('hidden', !isMarketplace);
            if (viewReport) viewReport.classList.toggle('hidden', isMarketplace);

            ['marketplace', 'report'].forEach(name => {
                const active = name === tab;
                ['tab-btn-' + name, 'tab-btn-' + name + '-mob'].forEach(id => {
                    const btn = $(id);
                    if (btn) btn.classList.toggle('active', active);
                });
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function applyFilters() {
            const location = $('filter-location') ? $('filter-location').value.toLowerCase() : 'all';
            const species = $('filter-species') ? $('filter-species').value.toLowerCase() : 'all';
            const search = $('filter-search') ? $('filter-search').value.trim().toLowerCase() : '';
            const oldestFirst = $('sort-order') ? $('sort-order').value === 'oldest' : false;
            const cards = document.querySelectorAll('.card-item');
            const total = cards.length;

            let visibleCount = 0;

            cards.forEach(card => {
                const cardLocation = (card.dataset.location || '').toLowerCase();
                const cardDistrict = (card.dataset.district || '').toLowerCase();
                const cardSpecies = (card.dataset.species || '').toLowerCase();

                const matchesLocation = (location === 'all' || cardLocation.includes(location) || cardDistrict.includes(location));
                const matchesSpecies = (species === 'all' || cardSpecies === species);
                const matchesSearch = (!search || card.innerText.toLowerCase().includes(search) || (card.dataset.code || '').toLowerCase().includes(search));

                const matches = matchesLocation && matchesSpecies && matchesSearch;

                card.classList.toggle('hidden', !matches);
                card.style.order = oldestFirst ? (total - Number(card.dataset.index)) : Number(card.dataset.index);

                if (matches) visibleCount++;
            });

            const countEl = $('result-count');
            if (countEl) {
                countEl.textContent = `Menampilkan ${visibleCount} laporan satwa hilang`;
            }

            const emptyEl = $('empty-state');
            if (emptyEl) {
                emptyEl.style.order = 999;
                emptyEl.classList.toggle('hidden', visibleCount > 0);
            }
        }

        function resetFilters() {
            if ($('filter-location')) $('filter-location').value = 'all';
            if ($('filter-species')) $('filter-species').value = 'all';
            if ($('filter-search')) $('filter-search').value = '';
            if ($('sort-order')) $('sort-order').value = 'newest';
            applyFilters();
        }

        function openCardDetail(card) {
            const data = card.dataset;
            currentModalReportId = data.id;

            $('modal-title').textContent = data.title;
            $('modal-location').textContent = data.district || 'Surabaya';
            $('modal-reporter').textContent = data.reporter || 'Pemilik Satwa';
            $('modal-species').textContent = data.species || 'Kucing';
            $('modal-detail-address').textContent = data.district || 'Surabaya';
            $('modal-description').textContent = data.description || 'Tidak ada keterangan tambahan.';
            $('modal-code').textContent = data.code || 'Tidak ada';
            $('modal-reward').textContent = data.reward || 'Tanpa imbalan';

            const image = $('modal-image');
            const placeholder = $('modal-image-placeholder');
            if (data.image && data.image.trim() !== '') {
                image.onload = function() {
                    image.classList.remove('hidden');
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                        placeholder.classList.remove('flex');
                    }
                };
                image.onerror = function() {
                    image.classList.add('hidden');
                    if (placeholder) {
                        placeholder.classList.remove('hidden');
                        placeholder.classList.add('flex');
                    }
                };
                image.src = data.image;
            } else {
                image.src = '';
                image.classList.add('hidden');
                if (placeholder) {
                    placeholder.classList.remove('hidden');
                    placeholder.classList.add('flex');
                }
            }

            const phone = (data.phone || '').replace(/\D/g, '');
            $('modal-wa-btn').href =
                'https://wa.me/' + phone + '?text=' +
                encodeURIComponent('Halo ' + (data.reporter || '') + ', saya melihat laporan satwa hilang "' + data.title + '" di SatwaTrace. Apakah satwa Anda sudah ditemukan?');

            $('detail-modal').classList.remove('hidden');
            $('detail-modal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function shareReport(id) {
            const card = document.querySelector('.card-item[data-id="' + id + '"]');
            if (!card) return;

            const shareUrl = window.location.origin + window.location.pathname + '?report=' + id;
            const shareText = 'Laporan satwa hilang di SatwaTrace: ' + card.dataset.title + ' (' + card.dataset.district + ')';

            if (navigator.share) {
                navigator.share({
                    title: 'SatwaTrace: ' + card.dataset.title,
                    text: shareText,
                    url: shareUrl
                }).catch(() => {});
            } else if (navigator.clipboard) {
                navigator.clipboard.writeText(shareText + '\n' + shareUrl);
                alert('Tautan laporan berhasil disalin: ' + shareUrl);
            } else {
                prompt('Salin tautan laporan berikut:', shareUrl);
            }
        }

        function shareReportFromModal() {
            if (currentModalReportId) {
                shareReport(currentModalReportId);
            }
        }

        function closeDetailModal() {
            const modal = $('detail-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            document.body.style.overflow = '';

            // Clean up report query parameter from URL without page reload
            if (window.history.replaceState && window.location.search.includes('report=')) {
                const cleanUrl = window.location.origin + window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);
            }
        }

        function handlePhotoChange(input) {
            const file = input.files[0];
            const defaultText = 'Format: JPG, PNG, atau WebP (Maksimal 5 MB)';
            const previewContainer = $('photo-preview-container');
            const previewImg = $('photo-preview');
            const defaultUi = $('photo-default-ui');
            const tempPhotoInput = $('temp_photo_path');

            if (!file) {
                $('photo-name').textContent = defaultText;
                if (!tempPhotoInput || !tempPhotoInput.value) {
                    if (previewContainer) previewContainer.classList.add('hidden');
                    if (defaultUi) defaultUi.classList.remove('hidden');
                }
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if (!allowedTypes.includes(file.type) || file.size > 5 * 1024 * 1024) {
                alert('Pilih foto JPG, PNG, atau WebP dengan ukuran maksimal 5 MB.');
                input.value = '';
                $('photo-name').textContent = defaultText;
                if (!tempPhotoInput || !tempPhotoInput.value) {
                    if (previewContainer) previewContainer.classList.add('hidden');
                    if (defaultUi) defaultUi.classList.remove('hidden');
                }
                return;
            }

            // User picked new file, clear temp_photo_path
            if (tempPhotoInput) tempPhotoInput.value = '';

            $('photo-name').textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';

            // Real visual image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                if (previewImg) previewImg.src = e.target.result;
                if (previewContainer) previewContainer.classList.remove('hidden');
                if (defaultUi) defaultUi.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') {
                closeDetailModal();
            }
        });

        // Form submission loading state
        document.addEventListener('DOMContentLoaded', () => {
            applyFilters();

            // Auto-open modal if URL contains ?report=ID
            const urlParams = new URLSearchParams(window.location.search);
            const reportId = urlParams.get('report');
            if (reportId) {
                const targetCard = document.querySelector(`.card-item[data-id="${reportId}"]`);
                if (targetCard) {
                    openCardDetail(targetCard);
                    targetCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }

            const form = $('report-animal-form');
            if (form) {
                form.addEventListener('submit', function() {
                    const btn = $('report-submit-btn');
                    if (btn) {
                        btn.disabled = true;
                        btn.classList.add('opacity-80', 'cursor-not-allowed');
                        btn.innerHTML = `
                            <span class="inline-flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Sedang mengirim laporan...</span>
                            </span>
                        `;
                    }
                });
            }
        });

        @if ($errors->any())
            switchMainTab('report');
        @endif
    </script>
</body>
</html>
