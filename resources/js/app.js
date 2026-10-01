document.addEventListener('DOMContentLoaded', () => {
    const brandSelect = document.getElementById('vehicle_brand');
    const modelSelect = document.getElementById('vehicle_model');
    const yearSelect = document.getElementById('vehicle_year');
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    async function loadModels(brandId) {
        if (!modelSelect) return;
        modelSelect.innerHTML = '<option value="">Modèle</option>';
        if (yearSelect) yearSelect.innerHTML = '<option value="">Année</option>';
        if (!brandId) return;

        const res = await fetch(`/api/vehicules/modeles?vehicle_brand_id=${brandId}`);
        const models = await res.json();
        models.forEach((m) => {
            const opt = document.createElement('option');
            opt.value = m.id;
            opt.textContent = m.name;
            modelSelect.appendChild(opt);
        });
    }

    async function loadYears(modelId) {
        if (!yearSelect) return;
        yearSelect.innerHTML = '<option value="">Année</option>';
        if (!modelId) return;

        const res = await fetch(`/api/vehicules/annees?vehicle_model_id=${modelId}`);
        const years = await res.json();
        years.forEach((y) => {
            const opt = document.createElement('option');
            opt.value = y.year;
            opt.textContent = y.year;
            yearSelect.appendChild(opt);
        });
    }

    if (brandSelect) {
        brandSelect.addEventListener('change', (e) => loadModels(e.target.value));
    }

    if (modelSelect) {
        modelSelect.addEventListener('change', (e) => loadYears(e.target.value));
    }
});
