/**
 * Family Module Logic
 * Handles rendering of offers and modal interactions.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Mock Data for Offers
    const MOCK_OFFRES = [
        {
            id: 1,
            name: "Sarah Jenkins",
            type: "child",
            experience: "5 years",
            description: "Specialized in early childhood development and creative play.",
            location: "Algiers, Hydra"
        },
        {
            id: 2,
            name: "Robert Miller",
            type: "elderly",
            experience: "8 years",
            description: "Certified geriatric care with experience in mobility support.",
            location: "Oran, Center"
        },
        {
            id: 3,
            name: "Elena Rodriguez",
            type: "child",
            experience: "3 years",
            description: "Passionate about education and multi-lingual child care.",
            location: "Constantine, City"
        },
        {
            id: 4,
            name: "Ahmed Mansouri",
            type: "elderly",
            experience: "10 years",
            description: "Experienced nurse specializing in home-based elder care.",
            location: "Algiers, Kouba"
        }
    ];

    const grid = document.getElementById('offers-grid');
    const modal = document.getElementById('request-modal');
    const openModalBtn = document.getElementById('open-request-modal');
    const closeModalBtn = document.getElementById('close-modal');
    const requestForm = document.getElementById('request-form');

    // Render Offer Cards
    const renderOffers = () => {
        grid.innerHTML = MOCK_OFFRES.map(offer => `
            <div class="offer-card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3>${offer.name}</h3>
                    <span class="badge badge-${offer.type}">${offer.type === 'child' ? 'Child Care' : 'Elderly Care'}</span>
                </div>
                <div class="offer-details">
                    <p><strong>Experience:</strong> ${offer.experience}</p>
                    <p><strong>Location:</strong> ${offer.location}</p>
                    <p style="margin-top: 8px;">${offer.description}</p>
                </div>
                <button class="btn-primary" onclick="selectOffer(${offer.id})">Select Offer</button>
            </div>
        `).join('');
    };

    // Modal Handlers
    openModalBtn.addEventListener('click', () => modal.classList.add('active'));
    closeModalBtn.addEventListener('click', () => modal.classList.remove('active'));

    // Close modal on outside click
    window.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.remove('active');
    });

    // Form Submission Mock
    requestForm.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Your request has been posted successfully! A caregiver will be notified.');
        modal.classList.remove('active');
    });

    // Global function for card buttons
    window.selectOffer = (id) => {
        const offer = MOCK_OFFRES.find(o => o.id === id);
        alert(`You selected ${offer.name}. Redirecting to booking details...`);
    };

    renderOffers();
});
