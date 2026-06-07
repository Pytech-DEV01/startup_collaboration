<?php $currentPage = 'organizations'; ?>
<?php include '../includes/header.php'; ?>

<!-- Page Header -->
<div class="page-header animate-fadeInUp">
    <div>
        <h1 class="page-title">Organizations</h1>
        <p>Manage partner organizations</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('add-org-modal')">
        <i class="fas fa-plus"></i> Add Organization
    </button>
</div>

<!-- Search -->
<div class="search-bar animate-fadeInUp delay-1">
    <i class="fas fa-search"></i>
    <input type="text" id="org-search" placeholder="Search organizations...">
</div>

<!-- Organizations Container -->
<div id="organizations-container" class="grid-3 animate-fadeInUp delay-2">
    <div class="loading-spinner"></div>
</div>

<!-- Add Organization Modal -->
<div id="add-org-modal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="fas fa-building"></i> Add Organization</h2>
            <button class="modal-close" onclick="closeModal('add-org-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="organization-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="org-name">Organization Name</label>
                        <input type="text" id="org-name" name="name" placeholder="Enter organization name" required>
                    </div>
                    <div class="form-group">
                        <label for="org-type">Type</label>
                        <select id="org-type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="University">University</option>
                            <option value="Incubator">Incubator</option>
                            <option value="Accelerator">Accelerator</option>
                            <option value="Corporate">Corporate</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="org-desc">Description</label>
                    <textarea id="org-desc" name="description" rows="3" placeholder="Describe the organization..."></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="org-location">Location</label>
                        <input type="text" id="org-location" name="location" placeholder="City, Country">
                    </div>
                    <div class="form-group">
                        <label for="org-website">Website</label>
                        <input type="url" id="org-website" name="website" placeholder="https://example.com">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('add-org-modal')">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Organization</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
