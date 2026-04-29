/**
 * Employee Module Logic
 * Handles request management and dynamic table population.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Mock Data for Incoming Requests
    let MOCK_REQUESTS = [
        {
            id: 101,
            familyName: "The Benali Family",
            type: "child",
            startDate: "2026-05-01",
            endDate: "2026-05-05",
            location: "Algiers, Hydra",
            details: "Looking for overnight care for a 3-year-old."
        },
        {
            id: 102,
            familyName: "The Dupont Family",
            type: "elderly",
            startDate: "2026-05-10",
            endDate: "2026-05-15",
            location: "Oran, Center",
            details: "Daily assistance for elderly patient (mobility support)."
        },
        {
            id: 103,
            familyName: "The Haddad Family",
            type: "child",
            startDate: "2026-06-01",
            endDate: "2026-06-10",
            location: "Constantine, City",
            details: "Summer camp preparation and child care."
        }
    ];

    const requestsList = document.getElementById('requests-list');
    const emptyMsg = document.getElementById('empty-msg');
    const fab = document.getElementById('fab-create-offer');

    // Render Request Rows
    const renderRequests = () => {
        if (MOCK_REQUESTS.length === 0) {
            requestsList.innerHTML = '';
            emptyMsg.classList.remove('hidden');
            return;
        }

        emptyMsg.classList.add('hidden');
        requestsList.innerHTML = MOCK_REQUESTS.map(req => `
            <tr>
                <td><strong>${req.familyName}</strong></td>
                <td><span class="badge badge-${req.type}">${req.type === 'child' ? 'Child' : 'Elderly'}</span></td>
                <td>${req.startDate} to ${req.endDate}</td>
                <td>${req.location}</td>
                <td class="action-btns">
                    <button class="btn-accept" onclick="handleRequest(${req.id}, 'accept')">Accept</button>
                    <button class="btn-decline" onclick="handleRequest(${req.id}, 'decline')">Decline</button>
                </td>
            </tr>
        `).join('');
    };

    // Global handler for Accept/Decline
    window.handleRequest = (id, action) => {
        const req = MOCK_REQUESTS.find(r => r.id === id);
        if (!req) return;

        if (action === 'accept') {
            alert(`Request from ${req.familyName} accepted! You can now coordinate the service.`);
        } else {
            alert(`Request from ${req.familyName} declined.`);
        }

        // Remove from the list
        MOCK_REQUESTS = MOCK_REQUESTS.filter(r => r.id !== id);
        renderRequests();
    };

    // FAB Interaction
    fab.addEventListener('click', () => {
        alert('Redirecting to Create Offer form...');
    });

    // Sidebar Navigation interactions
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
            item.classList.add('active');
        });
    });

    renderRequests();
});
