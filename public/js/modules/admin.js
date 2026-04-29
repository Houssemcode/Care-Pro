/**
 * Admin Module Logic
 * Handles employee verification and dispute reports.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Mock Data for Pending Employees
    let MOCK_EMPLOYEES = [
        { id: 501, name: "Sonia Belkacem", credentials: "Nursing Degree, 4y Exp", status: "pending" },
        { id: 502, name: "Marc Dubois", credentials: "Pedagogy Cert, 2y Exp", status: "pending" },
        { id: 503, name: "Yasmine Amari", credentials: "Elderly Care Cert, 6y Exp", status: "pending" },
        { id: 504, name: "Karim Ziane", credentials: "First Aid Cert, 1y Exp", status: "pending" }
    ];

    // Mock Data for Reports (Rapports)
    const MOCK_REPORTS = [
        {
            id: 901,
            employee: "Sarah Jenkins",
            family: "The Benali Family",
            reason: "Tardiness",
            comment: "Employee arrived 30 minutes late for three consecutive days."
        },
        {
            id: 902,
            employee: "Robert Miller",
            family: "The Dupont Family",
            reason: "Service Quality",
            comment: "Family reports that medication schedule was not strictly followed."
        }
    ];

    const verificationList = document.getElementById('verification-list');
    const reportsList = document.getElementById('reports-list');
    const pendingCountEl = document.getElementById('pending-count');

    // Render Verifications Table
    const renderVerifications = () => {
        const pending = MOCK_EMPLOYEES.filter(e => e.status === 'pending');
        pendingCountEl.textContent = `${pending.length} Pending`;

        verificationList.innerHTML = MOCK_EMPLOYEES.map(emp => `
            <tr>
                <td>#${emp.id}</td>
                <td><strong>${emp.name}</strong></td>
                <td>${emp.credentials}</td>
                <td><span class="status-badge status-${emp.status}">${emp.status}</span></td>
                <td>
                    ${emp.status === 'pending' ? `
                        <div style="display:flex; gap:5px;">
                            <button class="btn-approve" onclick="updateStatus(${emp.id}, 'approved')">Approve</button>
                            <button class="btn-reject" onclick="updateStatus(${emp.id}, 'rejected')">Reject</button>
                        </div>
                    ` : `<span style="font-size:0.8rem; color:grey;">Processed</span>`}
                </td>
            </tr>
        `).join('');
    };

    // Render Reports List
    const renderReports = () => {
        reportsList.innerHTML = MOCK_REPORTS.map(rep => `
            <div class="report-card">
                <div class="report-meta">
                    <strong>${rep.reason}</strong>
                    <span>${rep.employee} &harr; ${rep.family}</span>
                </div>
                <div class="report-body">"${rep.comment}"</div>
                <div style="text-align:right; margin-top:5px;">
                    <button class="btn-approve" style="font-size:0.7rem;">Resolve Issue</button>
                </div>
            </div>
        `).join('');
    };

    // Update Status Function
    window.updateStatus = (id, newStatus) => {
        const emp = MOCK_EMPLOYEES.find(e => e.id === id);
        if (emp) {
            emp.status = newStatus;
            renderVerifications();
        }
    };

    renderVerifications();
    renderReports();
});
