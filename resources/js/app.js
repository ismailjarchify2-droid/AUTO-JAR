document.addEventListener('DOMContentLoaded', () => {
    const brandSelect = document.getElementById('vehicle_brand');
    const modelSelect = document.getElementById('vehicle_model');
    const yearSelect = document.getElementById('vehicle_year');
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    function updateCartLinks(count) {
        const links = document.querySelectorAll('[data-cart-link]');
        const nextText = count > 0 ? `Panier (${count})` : 'Panier';

        links.forEach((link) => {
            const label = link.querySelector('.js-cart-label');
            const badge = link.querySelector('.js-cart-badge');

            if (label) {
                label.textContent = nextText;
            }

            if (badge) {
                badge.textContent = count;
                badge.classList.toggle('hidden', count <= 0);
            }
        });
    }

    function showCartToast(message) {
        let toast = document.getElementById('cart-toast');

        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'cart-toast';
            toast.className = 'fixed right-4 top-4 z-50 rounded-lg border border-sky-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-lg';
            document.body.appendChild(toast);
        }

        toast.textContent = message;
        toast.classList.remove('hidden');
        clearTimeout(toast.timeoutId);
        toast.timeoutId = setTimeout(() => {
            toast.classList.add('hidden');
        }, 1800);
    }

    document.addEventListener('submit', async (event) => {
        const form = event.target.closest('form[data-cart-add]');

        if (!form) return;

        event.preventDefault();

        const submitButton = form.querySelector('button[type="submit"]');
        const originalLabel = submitButton ? submitButton.textContent : 'Ajouter au panier';

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent = 'Ajouté ✓';
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            });

            const data = await response.json().catch(() => ({ success: false, message: 'Une erreur est survenue.' }));

            if (!response.ok || !data.success) {
                showCartToast(data.message || 'Une erreur est survenue.');
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = originalLabel;
                }
                return;
            }

            if (typeof data.cart_count !== 'undefined') {
                updateCartLinks(Number(data.cart_count));
            }

            showCartToast(data.message || 'Produit ajouté au panier.');
        } catch (error) {
            showCartToast('Une erreur est survenue.');
        } finally {
            if (submitButton) {
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalLabel;
                }, 900);
            }
        }
    });

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
