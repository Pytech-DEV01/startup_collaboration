<?php $currentPage = 'applications'; ?>
<?php include '../includes/header.php'; ?>

<!-- Page Header -->
<div class="page-header animate-fadeInUp">
    <div>
        <h1 class="page-title">Applications</h1>
        <p>Manage startup applications</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('add-application-modal')">
        <i class="fas fa-plus"></i> Submit Application
    </button>
</div>

<!-- Filters -->
<div class="filter-group animate-fadeInUp delay-1">
    <button class="filter-btn active" onclick="filterByStatus('all')">All</button>
    <button class="filter-btn" onclick="filterByStatus('pending')">Pending</button>
    <button class="filter-btn" onclick="filterByStatus('approved')">Approved</button>
    <button class="filter-btn" onclick="filterByStatus('rejected')">Rejected</button>
</div>

<!-- Applications Table -->
<div class="card animate-fadeInUp delay-2">
    <div class="card-body" style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Startup</th>
                    <th>Type</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="applications-container">
                <tr><td colspan="7"><div class="loading-spinner"></div></td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Submit Application Modal -->
<div id="add-application-modal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="fas fa-file-alt"></i> Submit Application</h2>
            <button class="modal-close" onclick="closeModal('add-application-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="application-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="app-user-select">Applicant</label>
                        <select id="app-user-select" name="user_id" required>
                            <option value="">Select Applicant</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="app-startup-select">Startup</label>
                        <select id="app-startup-select" name="startup_id" required>
                            <option value="">Select Startup</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="app-type">Application Type</label>
                    <select id="app-type" name="app_type" required>
                        <option value="">Select Type</option>
                        <option value="join">Join</option>
                        <option value="invest">Invest</option>
                        <option value="collaborate">Collaborate</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="app-message">Message</label>
                    <textarea id="app-message" name="message" rows="3" placeholder="Write your application message..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('add-application-modal')">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
