// ---- Yihla design: gallery filters + join-us package hover (ported from NewFrontEnd) ----
(function () {
    function initGalleryFilters() {
        var buttons = document.querySelectorAll('.gallery-filter-btn');
        var items = document.querySelectorAll('.gallery-item');
        if (!buttons.length) return;
        buttons.forEach(function (btn) {
            if (btn.dataset.bound) return;
            btn.dataset.bound = '1';
            btn.addEventListener('click', function () {
                var type = btn.getAttribute('data-type');
                buttons.forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
                items.forEach(function (item) {
                    var show = type === 'all' || item.getAttribute('data-type') === type;
                    item.style.display = show ? '' : 'none';
                });
            });
        });
    }
    function initPackageHover() {
        document.querySelectorAll('.packages-container .package-card').forEach(function (card) {
            if (card.dataset.hoverBound) return;
            card.dataset.hoverBound = '1';
            function render(hovered) {
                card.classList.toggle('feature-package', hovered);
                var btn = card.querySelector('.btn');
                if (btn) {
                    btn.classList.toggle('btn-green', hovered);
                    btn.classList.toggle('btn-blue', !hovered);
                }
            }
            card.addEventListener('mouseenter', function () { render(true); });
            card.addEventListener('mouseleave', function () { render(false); });
        });
    }
    function initYihlaDesign() { initGalleryFilters(); initPackageHover(); }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initYihlaDesign);
    } else {
        initYihlaDesign();
    }
    document.addEventListener('livewire:navigated', initYihlaDesign);
    document.addEventListener('livewire:initialized', function () {
        if (window.Livewire && Livewire.hook) {
            Livewire.hook('morphed', initPackageHover);
        }
    });
})();
