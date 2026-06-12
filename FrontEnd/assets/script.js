// =============================================
// Startup Collaboration Portal - Main Script
// Vanilla JS — No jQuery
// =============================================

// --- Configuration ---
const apiBase = window.location.pathname.includes('/pages/') ? '../../api' : '../api';

// =============================================
// UTILITY FUNCTIONS
// =============================================

/**
 * Fetch data from the API
 * @param {string} type - The data type to fetch
 * @param {string} extraParams - Additional query parameters
 * @returns {Promise<any>} API response data
 */
async function fetchData(type, extraParams = '') {
    try {
        const res = await fetch(`${apiBase}/fetch.php?type=${type}${extraParams}`);
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        const data = await res.json();
        return data;
    } catch (err) {
        console.error('Fetch error:', err);
        showToast('Failed to load data', 'error');
        return [];
    }
}

/**
 * POST data to the API
 * @param {string} endpoint - API endpoint filename
 * @param {object} data - Key-value pairs to send
 * @returns {Promise<object>} API response
 */
async function postData(endpoint, data) {
    try {
        const formData = new FormData();
        for (let key in data) {
            if (data[key] !== undefined && data[key] !== null) {
                formData.append(key, data[key]);
            }
        }
        const res = await fetch(`${apiBase}/${endpoint}`, {
            method: 'POST',
            body: formData
        });
        return await res.json();
    } catch (err) {
        console.error('Post error:', err);
        showToast('Operation failed', 'error');
        return { success: false };
    }
}

/**
 * Show a toast notification
 * @param {string} message - Notification text
 * @param {string} type - 'success', 'error', or 'info'
 */
function showToast(message, type = 'success') {
    const container = document.querySelector('.toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;

    const iconMap = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        info: 'fa-info-circle'
    };

    toast.innerHTML = `
        <i class="fas ${iconMap[type] || iconMap.info}"></i>
        <span>${message}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">&times;</button>
    `;

    container.appendChild(toast);

    // Trigger enter animation
    requestAnimationFrame(() => {
        toast.classList.add('show');
    });

    // Auto dismiss after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/**
 * Format currency in Indian Rupees
 */
function formatCurrency(amount) {
    return '₹' + Number(amount).toLocaleString('en-IN');
}

/**
 * Format a date string nicely
 */
function formatDate(dateStr) {
    if (!dateStr) return 'N/A';
    const date = new Date(dateStr);
    if (isNaN(date.getTime())) return 'N/A';
    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
}

/**
 * Format a datetime string
 */
function formatDateTime(dateStr) {
    if (!dateStr) return 'N/A';
    const date = new Date(dateStr);
    if (isNaN(date.getTime())) return 'N/A';
    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

/**
 * Truncate text to a max length
 */
function truncateText(text, maxLen = 100) {
    if (!text) return '';
    return text.length > maxLen ? text.substring(0, maxLen) + '...' : text;
}

/**
 * Get CSS class for status badges
 */
function getStatusBadgeClass(status) {
    const map = {
        'pending': 'badge-pending',
        'approved': 'badge-approved',
        'rejected': 'badge-rejected',
        'active': 'badge-success',
        'completed': 'badge-primary',
        'inactive': 'badge-warning'
    };
    return map[status?.toLowerCase()] || 'badge-primary';
}

/**
 * Get CSS class for funding stage badges
 */
function getBadgeClass(stage) {
    const map = {
        'Pre-Seed': 'pre-seed',
        'Seed': 'seed',
        'Series A': 'series-a',
        'Series B': 'series-a',
        'Series C+': 'series-a'
    };
    return map[stage] || 'primary';
}

/**
 * Get investment amount badge HTML
 */
function getInvestmentBadge(amount) {
    const num = Number(amount);
    if (num >= 10000000) return '<span class="badge badge-danger">High Value</span>';
    if (num >= 1000000) return '<span class="badge badge-warning">Mid Value</span>';
    return '<span class="badge badge-success">Early Stage</span>';
}

/**
 * Get organization type badge class
 */
function getOrgTypeBadge(type) {
    const map = {
        'University': 'badge-primary',
        'Incubator': 'badge-success',
        'Accelerator': 'badge-warning',
        'Corporate': 'badge-danger'
    };
    return map[type] || 'badge-primary';
}


// =============================================
// MODAL FUNCTIONS
// =============================================

/**
 * Open a modal by ID
 */
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

/**
 * Close a modal by ID
 */
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Close modal on overlay click
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-overlay') && e.target.classList.contains('active')) {
        e.target.classList.remove('active');
        document.body.style.overflow = '';
    }
});

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.active').forEach(m => {
            m.classList.remove('active');
        });
        document.body.style.overflow = '';
    }
});


// =============================================
// PAGE ROUTER — DOMContentLoaded
// =============================================

document.addEventListener('DOMContentLoaded', () => {
    const path = window.location.pathname;

    if (path.includes('index.php') || path.endsWith('/startup-portal/') || path.endsWith('/startup-portal')) {
        loadDashboard();
    } else if (path.includes('startups.php')) {
        loadStartups();
        loadStartupFormDropdowns();
        setupSearch('startup-search', 'startups-container');
    } else if (path.includes('events.php')) {
        loadEvents();
        loadEventFormDropdowns();
        setupSearch('event-search', 'events-container');
    } else if (path.includes('investors.php')) {
        loadInvestors();
    } else if (path.includes('organizations.php')) {
        loadOrganizations();
        setupSearch('org-search', 'organizations-container');
    } else if (path.includes('applications.php')) {
        loadApplications();
        loadApplicationFormDropdowns();
    } else if (path.includes('mentorships.php')) {
        loadMentorships();
        loadMentorshipFormDropdowns();
    } else if (path.includes('participants.php')) {
        loadParticipantEvents();
        loadParticipantFormDropdowns();
    }

    // Setup form submit handlers
    setupFormHandlers();

    // Auto-refresh data every 30 seconds
    setInterval(() => {
        const p = window.location.pathname;
        if (p.includes('index.php') || p.endsWith('/startup-portal/') || p.endsWith('/startup-portal')) {
            loadDashboard();
        } else if (p.includes('startups.php')) {
            loadStartups();
        } else if (p.includes('events.php')) {
            loadEvents();
        } else if (p.includes('investors.php')) {
            loadInvestors();
        } else if (p.includes('organizations.php')) {
            loadOrganizations();
        } else if (p.includes('applications.php')) {
            loadApplications();
        } else if (p.includes('mentorships.php')) {
            loadMentorships();
        }
    }, 30000);
});


// =============================================
// DASHBOARD FUNCTIONS
// =============================================

/**
 * Load all dashboard data
 */
async function loadDashboard() {
    // Load stats
    const stats = await fetchData('dashboard_stats');
    if (stats && !Array.isArray(stats)) {
        animateCounter('stat-startups', stats.total_startups || 0);
        animateCounter('stat-events', stats.total_events || 0);
        animateCounter('stat-investors', stats.total_investors || 0);
        animateCounter('stat-collaborations', stats.total_collaborations || 0);
        animateCounter('stat-organizations', stats.total_organizations || 0);
        animateCounter('stat-users', stats.total_users || 0);
    }

    // Load recent startups
    const startups = await fetchData('recent_startups');
    renderRecentStartups(Array.isArray(startups) ? startups : []);

    // Load upcoming events
    const events = await fetchData('upcoming_events');
    renderUpcomingEvents(Array.isArray(events) ? events : []);

    // Load collaborations
    const collabs = await fetchData('collaborations');
    renderCollaborations(Array.isArray(collabs) ? collabs : []);
}

/**
 * Animate a counter from current value to target
 */
function animateCounter(elementId, target) {
    const el = document.getElementById(elementId);
    if (!el) return;

    const targetNum = parseInt(target) || 0;
    const duration = 1500;
    const startTime = performance.now();
    const startVal = parseInt(el.textContent) || 0;

    function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        // Ease-out cubic for smooth deceleration
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = Math.round(startVal + (targetNum - startVal) * eased);
        el.textContent = current;
        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }

    requestAnimationFrame(update);
}

/**
 * Render recent startups in dashboard
 */
function renderRecentStartups(startups) {
    const container = document.getElementById('recent-startups-container');
    if (!container) return;

    if (startups.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-rocket"></i><p>No startups yet</p></div>';
        return;
    }

    container.innerHTML = startups.map(s => `
        <div class="list-item">
            <div class="list-item-info">
                <h4>${s.name}</h4>
                <p>${truncateText(s.description, 60)}</p>
            </div>
            <span class="badge badge-${getBadgeClass(s.funding_stage)}">${s.funding_stage || 'N/A'}</span>
        </div>
    `).join('');
}

/**
 * Render upcoming events in dashboard
 */
function renderUpcomingEvents(events) {
    const container = document.getElementById('upcoming-events-container');
    if (!container) return;

    if (events.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-calendar"></i><p>No upcoming events</p></div>';
        return;
    }

    container.innerHTML = events.map(e => {
        const eventDate = new Date(e.event_date);
        return `
            <div class="list-item">
                <div class="event-date-badge">
                    <span class="month">${eventDate.toLocaleDateString('en-US', { month: 'short' })}</span>
                    <span class="day">${eventDate.getDate()}</span>
                </div>
                <div class="list-item-info">
                    <h4>${e.title}</h4>
                    <p><i class="fas fa-map-marker-alt"></i> ${e.location || 'TBA'}</p>
                </div>
            </div>
        `;
    }).join('');
}

/**
 * Render collaborations in dashboard
 */
function renderCollaborations(collabs) {
    const container = document.getElementById('collaborations-container');
    if (!container) return;

    if (collabs.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-handshake"></i><p>No collaborations yet</p></div>';
        return;
    }

    container.innerHTML = collabs.map(c => `
        <div class="list-item">
            <div class="list-item-info">
                <h4>${c.startup1_name} <i class="fas fa-arrows-alt-h"></i> ${c.startup2_name}</h4>
                <p>${c.collab_type || 'Collaboration'}</p>
            </div>
            <span class="badge ${getStatusBadgeClass(c.status)}">${c.status || 'Pending'}</span>
        </div>
    `).join('');
}


// =============================================
// STARTUPS FUNCTIONS
// =============================================

let allStartups = [];

/**
 * Load all startups from API
 */
async function loadStartups() {
    const startups = await fetchData('startups');
    allStartups = Array.isArray(startups) ? startups : [];
    renderStartups(allStartups);
}

/**
 * Render startup cards
 */
function renderStartups(startups) {
    const container = document.getElementById('startups-container');
    if (!container) return;

    if (startups.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-rocket"></i><p>No startups found</p></div>';
        return;
    }

    container.innerHTML = startups.map((s, i) => `
        <div class="card animate-fadeInUp delay-${(i % 4) + 1}" data-funding="${(s.funding_stage || '').toLowerCase()}">
            <div class="card-header">
                <h3>${s.name}</h3>
                <span class="badge badge-${getBadgeClass(s.funding_stage)}">${s.funding_stage || 'N/A'}</span>
            </div>
            <div class="card-body">
                <span class="badge badge-primary">${s.type_name || 'N/A'}</span>
                <p>${truncateText(s.description, 120)}</p>
                <p><i class="fas fa-users"></i> ${s.founders || 'No founders listed'}</p>
                <p><i class="fas fa-calendar"></i> Founded: ${s.founded_year || 'N/A'}</p>
            </div>
            <div class="card-footer">
                ${s.website ? `<a href="${s.website}" target="_blank" class="btn btn-outline btn-sm"><i class="fas fa-globe"></i> Website</a>` : ''}
                <button class="btn btn-danger btn-sm" onclick="deleteItem('startup', ${s.startup_id})">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    `).join('');
}

/**
 * Load startup form dropdowns (types & organizations)
 */
async function loadStartupFormDropdowns() {
    // Load startup types
    const types = await fetchData('startup_types');
    const typeSelect = document.getElementById('startup-type-select');
    if (typeSelect && Array.isArray(types)) {
        typeSelect.innerHTML = '<option value="">Select Type</option>' +
            types.map(t => `<option value="${t.type_id}">${t.type_name}</option>`).join('');
    }

    // Load organizations
    const orgs = await fetchData('organizations_list');
    const orgSelect = document.getElementById('startup-org-select');
    if (orgSelect && Array.isArray(orgs)) {
        orgSelect.innerHTML = '<option value="">Select Organization (Optional)</option>' +
            orgs.map(o => `<option value="${o.org_id}">${o.name}</option>`).join('');
    }
}

/**
 * Filter startups by funding stage
 */
function filterByFunding(stage) {
    // Update active filter button
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    if (event && event.target) event.target.classList.add('active');

    if (stage === 'all') {
        renderStartups(allStartups);
    } else {
        const filtered = allStartups.filter(s =>
            (s.funding_stage || '').toLowerCase() === stage.toLowerCase()
        );
        renderStartups(filtered);
    }
}


// =============================================
// EVENTS FUNCTIONS
// =============================================

let allEvents = [];

/**
 * Load all events from API
 */
async function loadEvents() {
    const events = await fetchData('events');
    allEvents = Array.isArray(events) ? events : [];
    renderEvents(allEvents);
}

/**
 * Render event cards
 */
function renderEvents(events) {
    const container = document.getElementById('events-container');
    if (!container) return;

    if (events.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-calendar"></i><p>No events found</p></div>';
        return;
    }

    container.innerHTML = events.map((e, i) => `
        <div class="card animate-fadeInUp delay-${(i % 4) + 1}" data-type="${(e.type_name || '').toLowerCase()}">
            <div class="card-header">
                <h3>${e.title}</h3>
                <span class="badge badge-primary">${e.type_name || 'Event'}</span>
            </div>
            <div class="card-body">
                <p><i class="fas fa-calendar-alt"></i> ${formatDateTime(e.event_date)}</p>
                <p><i class="fas fa-map-marker-alt"></i> ${e.location || 'TBA'}</p>
                <p>${truncateText(e.description, 100)}</p>
                <p><i class="fas fa-users"></i> ${e.participant_count || 0} participants</p>
            </div>
            <div class="card-footer">
                <button class="btn btn-outline btn-sm" onclick="viewEventParticipants(${e.event_id}, '${(e.title || '').replace(/'/g, "\\'")}')">
                    <i class="fas fa-eye"></i> Participants
                </button>
                <button class="btn btn-danger btn-sm" onclick="deleteItem('event', ${e.event_id})">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    `).join('');
}

/**
 * View participants for a specific event
 */
async function viewEventParticipants(eventId, title) {
    const participants = await fetchData('participants', `&event_id=${eventId}`);
    const tbody = document.getElementById('event-participants-body');

    if (tbody) {
        const list = Array.isArray(participants) ? participants : [];
        if (list.length > 0) {
            tbody.innerHTML = list.map(p => `
                <tr>
                    <td>${p.full_name || p.name || 'N/A'}</td>
                    <td>${p.email || 'N/A'}</td>
                    <td>${p.phone || 'N/A'}</td>
                    <td>${formatDate(p.registration_date)}</td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = '<tr><td colspan="4" class="empty-state">No participants registered</td></tr>';
        }
    }

    // Update modal title
    const modalHeader = document.querySelector('#participants-modal .modal-header h2');
    if (modalHeader) {
        modalHeader.innerHTML = `<i class="fas fa-users"></i> Participants — ${title}`;
    }

    openModal('participants-modal');
}

/**
 * Load event form dropdowns (event types)
 */
async function loadEventFormDropdowns() {
    const types = await fetchData('event_types');
    const typeSelect = document.getElementById('event-type-select');
    if (typeSelect && Array.isArray(types)) {
        typeSelect.innerHTML = '<option value="">Select Type</option>' +
            types.map(t => `<option value="${t.type_id}">${t.type_name}</option>`).join('');
    }
}

/**
 * Filter events by type
 */
function filterByEventType(type) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    if (event && event.target) event.target.classList.add('active');

    if (type === 'all') {
        renderEvents(allEvents);
    } else {
        const filtered = allEvents.filter(e =>
            (e.type_name || '').toLowerCase() === type.toLowerCase()
        );
        renderEvents(filtered);
    }
}


// =============================================
// INVESTORS FUNCTIONS
// =============================================

/**
 * Load all investors from API
 */
async function loadInvestors() {
    const investors = await fetchData('investors');
    const container = document.getElementById('investors-container');
    const totalEl = document.getElementById('total-investment');
    const list = Array.isArray(investors) ? investors : [];

    // Show total investment summary
    if (totalEl) {
        if (list.length > 0) {
            const total = list.reduce((sum, inv) => sum + Number(inv.investment_amount || 0), 0);
            totalEl.innerHTML = `
                <div class="stat-card" style="max-width: 400px;">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f7971e, #ffd200);">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>${formatCurrency(total)}</h3>
                    <p>Total Investment</p>
                </div>
            `;
        } else {
            totalEl.innerHTML = '';
        }
    }

    if (!container) return;

    if (list.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-hand-holding-usd"></i><p>No investors found</p></div>';
        return;
    }

    container.innerHTML = list.map((inv, i) => `
        <div class="card animate-fadeInUp delay-${(i % 4) + 1}">
            <div class="card-header">
                <h3>${inv.full_name || 'Anonymous'}</h3>
                ${getInvestmentBadge(inv.investment_amount)}
            </div>
            <div class="card-body">
                <p class="investment-amount"><i class="fas fa-money-bill-wave"></i> ${formatCurrency(inv.investment_amount || 0)}</p>
                <p><i class="fas fa-rocket"></i> Invested in: <strong>${inv.startup_name || 'N/A'}</strong></p>
                <p><i class="fas fa-calendar"></i> ${formatDate(inv.investment_date)}</p>
                ${inv.bio ? `<p class="investor-bio">${truncateText(inv.bio, 80)}</p>` : ''}
            </div>
        </div>
    `).join('');
}


// =============================================
// ORGANIZATIONS FUNCTIONS
// =============================================

let allOrganizations = [];

/**
 * Load all organizations from API
 */
async function loadOrganizations() {
    const orgs = await fetchData('organizations');
    allOrganizations = Array.isArray(orgs) ? orgs : [];
    renderOrganizations(allOrganizations);
}

/**
 * Render organization cards
 */
function renderOrganizations(orgs) {
    const container = document.getElementById('organizations-container');
    if (!container) return;

    if (orgs.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-building"></i><p>No organizations found</p></div>';
        return;
    }

    container.innerHTML = orgs.map((o, i) => `
        <div class="card animate-fadeInUp delay-${(i % 4) + 1}">
            <div class="card-header">
                <h3>${o.name}</h3>
                <span class="badge ${getOrgTypeBadge(o.type)}">${o.type || 'N/A'}</span>
            </div>
            <div class="card-body">
                <p><i class="fas fa-map-marker-alt"></i> ${o.location || 'N/A'}</p>
                <p>${truncateText(o.description, 100)}</p>
                <div class="org-stats">
                    <span><i class="fas fa-rocket"></i> ${o.startup_count || 0} Startups</span>
                    <span><i class="fas fa-calendar"></i> ${o.event_count || 0} Events</span>
                </div>
            </div>
            <div class="card-footer">
                ${o.website ? `<a href="${o.website}" target="_blank" class="btn btn-outline btn-sm"><i class="fas fa-globe"></i> Website</a>` : ''}
                <button class="btn btn-danger btn-sm" onclick="deleteItem('organization', ${o.org_id})">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    `).join('');
}


// =============================================
// APPLICATIONS FUNCTIONS
// =============================================

let allApplications = [];

/**
 * Load all applications from API
 */
async function loadApplications() {
    const apps = await fetchData('applications');
    allApplications = Array.isArray(apps) ? apps : [];
    renderApplications(allApplications);
}

/**
 * Render applications in table
 */
function renderApplications(apps) {
    const container = document.getElementById('applications-container');
    if (!container) return;

    if (apps.length === 0) {
        container.innerHTML = '<tr><td colspan="7" class="empty-state">No applications found</td></tr>';
        return;
    }

    container.innerHTML = apps.map(a => `
        <tr>
            <td><strong>${a.full_name || 'N/A'}</strong></td>
            <td>${a.startup_name || 'N/A'}</td>
            <td><span class="badge badge-primary">${a.app_type || 'N/A'}</span></td>
            <td>${truncateText(a.message, 50)}</td>
            <td><span class="badge ${getStatusBadgeClass(a.status)}">${a.status || 'Pending'}</span></td>
            <td>${formatDate(a.created_at)}</td>
            <td class="action-buttons">
                ${(a.status || '').toLowerCase() === 'pending' ? `
                    <button class="btn btn-success btn-sm" onclick="updateStatus('application', ${a.app_id}, 'approved')" title="Approve">
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="updateStatus('application', ${a.app_id}, 'rejected')" title="Reject">
                        <i class="fas fa-times"></i>
                    </button>
                ` : '<span class="badge badge-primary">—</span>'}
            </td>
        </tr>
    `).join('');
}

/**
 * Filter applications by status
 */
function filterByStatus(status) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    if (event && event.target) event.target.classList.add('active');

    if (status === 'all') {
        renderApplications(allApplications);
    } else {
        const filtered = allApplications.filter(a =>
            (a.status || '').toLowerCase() === status.toLowerCase()
        );
        renderApplications(filtered);
    }
}

/**
 * Load application form dropdowns (users & startups)
 */
async function loadApplicationFormDropdowns() {
    const users = await fetchData('users_list');
    const userSelect = document.getElementById('app-user-select');
    if (userSelect && Array.isArray(users)) {
        userSelect.innerHTML = '<option value="">Select Applicant</option>' +
            users.map(u => `<option value="${u.user_id}">${u.full_name}</option>`).join('');
    }

    const startups = await fetchData('startups_list');
    const startupSelect = document.getElementById('app-startup-select');
    if (startupSelect && Array.isArray(startups)) {
        startupSelect.innerHTML = '<option value="">Select Startup</option>' +
            startups.map(s => `<option value="${s.startup_id}">${s.name}</option>`).join('');
    }
}


// =============================================
// MENTORSHIPS FUNCTIONS
// =============================================

/**
 * Load all mentorships from API
 */
async function loadMentorships() {
    const mentorships = await fetchData('mentorships');
    const container = document.getElementById('mentorships-container');
    const list = Array.isArray(mentorships) ? mentorships : [];

    if (!container) return;

    if (list.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-users"></i><p>No mentorships found</p></div>';
        return;
    }

    container.innerHTML = list.map((m, i) => `
        <div class="card animate-fadeInUp delay-${(i % 4) + 1}">
            <div class="card-header">
                <h3>
                    <span class="mentor-name">${m.mentor_name}</span>
                    <i class="fas fa-arrow-right" style="margin: 0 0.5rem; color: var(--primary);"></i>
                    <span class="mentee-name">${m.mentee_name}</span>
                </h3>
            </div>
            <div class="card-body">
                <p><i class="fas fa-bullseye"></i> Focus: <strong>${m.focus_area || 'General'}</strong></p>
                <span class="badge ${getStatusBadgeClass(m.status)}">${m.status || 'Active'}</span>
                <p><i class="fas fa-calendar"></i> Started: ${formatDate(m.start_date)}</p>
            </div>
            <div class="card-footer">
                <button class="btn btn-danger btn-sm" onclick="deleteItem('mentorship', ${m.mentorship_id})">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    `).join('');
}

/**
 * Load mentorship form dropdowns (users for mentor & mentee)
 */
async function loadMentorshipFormDropdowns() {
    const users = await fetchData('users_list');
    const mentorSelect = document.getElementById('mentor-select');
    const menteeSelect = document.getElementById('mentee-select');

    if (Array.isArray(users)) {
        const options = '<option value="">Select User</option>' +
            users.map(u => `<option value="${u.user_id}">${u.full_name}</option>`).join('');
        if (mentorSelect) mentorSelect.innerHTML = options;
        if (menteeSelect) menteeSelect.innerHTML = options;
    }
}


// =============================================
// PARTICIPANTS FUNCTIONS
// =============================================

/**
 * Load events into the event selector dropdown
 */
async function loadParticipantEvents() {
    const events = await fetchData('events');
    const selector = document.getElementById('event-selector');

    if (selector && Array.isArray(events)) {
        selector.innerHTML = '<option value="">-- Select an Event --</option>' +
            events.map(e => `<option value="${e.event_id}">${e.title} — ${formatDate(e.event_date)}</option>`).join('');
    }
}

/**
 * Load participants for a selected event
 */
async function loadParticipants(eventId) {
    const tbody = document.getElementById('participants-table');
    if (!tbody) return;

    if (!eventId) {
        tbody.innerHTML = '<tr><td colspan="5" class="empty-state">Select an event to view participants</td></tr>';
        return;
    }

    // Show loading
    tbody.innerHTML = '<tr><td colspan="5"><div class="loading-spinner"></div></td></tr>';

    const participants = await fetchData('participants', `&event_id=${eventId}`);
    const list = Array.isArray(participants) ? participants : [];

    if (list.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="empty-state">No participants registered for this event</td></tr>';
        return;
    }

    tbody.innerHTML = list.map(p => `
        <tr>
            <td><strong>${p.full_name || p.name || 'N/A'}</strong></td>
            <td>${p.email || 'N/A'}</td>
            <td>${p.phone || 'N/A'}</td>
            <td>${formatDate(p.registration_date)}</td>
            <td><span class="badge badge-success">Registered</span></td>
        </tr>
    `).join('');
}

/**
 * Load participant form dropdowns (events & users)
 */
async function loadParticipantFormDropdowns() {
    const events = await fetchData('events');
    const eventSelect = document.getElementById('reg-event-select');
    if (eventSelect && Array.isArray(events)) {
        eventSelect.innerHTML = '<option value="">Select Event</option>' +
            events.map(e => `<option value="${e.event_id}">${e.title}</option>`).join('');
    }

    const users = await fetchData('users_list');
    const userSelect = document.getElementById('reg-user-select');
    if (userSelect && Array.isArray(users)) {
        userSelect.innerHTML = '<option value="">Select Participant</option>' +
            users.map(u => `<option value="${u.user_id}">${u.full_name}</option>`).join('');
    }
}


// =============================================
// FORM HANDLERS
// =============================================

/**
 * Setup all form submit event listeners
 */
function setupFormHandlers() {

    // --- Startup Form ---
    document.getElementById('startup-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target));
        data.type = 'startup';
        const result = await postData('insert.php', data);
        if (result.success) {
            showToast('Startup added successfully!');
            closeModal('add-startup-modal');
            e.target.reset();
            loadStartups();
        } else {
            showToast(result.error || 'Failed to add startup', 'error');
        }
    });

    // --- Event Form ---
    document.getElementById('event-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target));
        data.type = 'event';
        const result = await postData('insert.php', data);
        if (result.success) {
            showToast('Event created successfully!');
            closeModal('add-event-modal');
            e.target.reset();
            loadEvents();
        } else {
            showToast(result.error || 'Failed to create event', 'error');
        }
    });

    // --- Organization Form ---
    document.getElementById('organization-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target));
        data.type = 'organization';
        const result = await postData('insert.php', data);
        if (result.success) {
            showToast('Organization added successfully!');
            closeModal('add-org-modal');
            e.target.reset();
            loadOrganizations();
        } else {
            showToast(result.error || 'Failed to add organization', 'error');
        }
    });

    // --- Application Form ---
    document.getElementById('application-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target));
        data.type = 'application';
        const result = await postData('insert.php', data);
        if (result.success) {
            showToast('Application submitted successfully!');
            closeModal('add-application-modal');
            e.target.reset();
            loadApplications();
        } else {
            showToast(result.error || 'Failed to submit application', 'error');
        }
    });

    // --- Mentorship Form ---
    document.getElementById('mentorship-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target));
        data.type = 'mentorship';
        const result = await postData('insert.php', data);
        if (result.success) {
            showToast('Mentorship created successfully!');
            closeModal('add-mentorship-modal');
            e.target.reset();
            loadMentorships();
        } else {
            showToast(result.error || 'Failed to create mentorship', 'error');
        }
    });

    // --- Registration Form ---
    document.getElementById('registration-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const data = Object.fromEntries(new FormData(e.target));
        const result = await postData('register.php', data);
        if (result.success) {
            showToast('Registration successful!');
            closeModal('add-registration-modal');
            e.target.reset();
            // Refresh participants if an event is selected
            const selector = document.getElementById('event-selector');
            if (selector && selector.value) {
                loadParticipants(selector.value);
            }
        } else {
            showToast(result.error || 'Registration failed', 'error');
        }
    });
}


// =============================================
// SEARCH FUNCTION
// =============================================

/**
 * Setup live search filtering on card containers
 * @param {string} inputId - Search input element ID
 * @param {string} containerId - Container element ID
 */
function setupSearch(inputId, containerId) {
    const input = document.getElementById(inputId);
    if (!input) return;

    input.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        const container = document.getElementById(containerId);
        if (!container) return;

        // Search within cards
        const cards = container.querySelectorAll('.card');
        let visibleCount = 0;

        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            const isMatch = text.includes(query);
            card.style.display = isMatch ? '' : 'none';
            if (isMatch) visibleCount++;
        });

        // Search within table rows
        const rows = container.querySelectorAll('tr');
        rows.forEach(row => {
            if (row.parentElement.tagName === 'THEAD') return;
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
}


// =============================================
// DELETE FUNCTION
// =============================================

/**
 * Delete an item via API
 * @param {string} type - Item type (startup, event, organization, mentorship)
 * @param {number} id - Item ID
 */
async function deleteItem(type, id) {
    if (!confirm(`Are you sure you want to delete this ${type}?`)) return;

    const result = await postData('delete.php', { type, id });

    if (result.success) {
        showToast('Deleted successfully!');
        // Reload the appropriate section
        const path = window.location.pathname;
        if (path.includes('startups')) loadStartups();
        else if (path.includes('events')) loadEvents();
        else if (path.includes('organizations')) loadOrganizations();
        else if (path.includes('mentorships')) loadMentorships();
        else if (path.includes('index') || path.endsWith('/startup-portal/') || path.endsWith('/startup-portal')) loadDashboard();
    } else {
        showToast(result.error || 'Failed to delete', 'error');
    }
}


// =============================================
// UPDATE STATUS FUNCTION
// =============================================

/**
 * Update status for applications, collaborations, or mentorships
 * @param {string} type - 'application', 'collaboration', or 'mentorship'
 * @param {number} id - Item ID
 * @param {string} status - New status value
 */
async function updateStatus(type, id, status) {
    const typeMap = {
        application: 'application_status',
        collaboration: 'collaboration_status',
        mentorship: 'mentorship_status'
    };
    const idMap = {
        application: 'app_id',
        collaboration: 'collab_id',
        mentorship: 'mentorship_id'
    };

    const result = await postData('update.php', {
        type: typeMap[type],
        [idMap[type]]: id,
        status: status
    });

    if (result.success) {
        showToast(`Status updated to ${status}!`);
        // Reload the appropriate data
        if (type === 'application') loadApplications();
        else if (type === 'collaboration') loadDashboard();
        else if (type === 'mentorship') loadMentorships();
    } else {
        showToast(result.error || 'Failed to update status', 'error');
    }
}


// =============================================
// SIDEBAR TOGGLE (MOBILE)
// =============================================

document.querySelector('.mobile-toggle')?.addEventListener('click', () => {
    document.querySelector('.sidebar')?.classList.toggle('active');
});
