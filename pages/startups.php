<?php $currentPage = 'startups'; ?>
<?php include '../includes/header.php'; ?>

<!-- Page Header -->
<div class="page-header animate-fadeInUp">
    <div>
        <h1 class="page-title">Startups</h1>
        <p>Manage and explore startups in the ecosystem</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('add-startup-modal')">
        <i class="fas fa-plus"></i> Add Startup
    </button>
</div>

<!-- Search & Filters -->
<div class="search-bar animate-fadeInUp delay-1">
    <i class="fas fa-search"></i>
    <input type="text" id="startup-search" placeholder="Search startups...">
</div>

<div class="filter-group animate-fadeInUp delay-2">
    <button class="filter-btn active" onclick="filterByFunding('all')">All</button>
    <button class="filter-btn" onclick="filterByFunding('pre-seed')">Pre-Seed</button>
    <button class="filter-btn" onclick="filterByFunding('seed')">Seed</button>
    <button class="filter-btn" onclick="filterByFunding('series a')">Series A</button>
    <button class="filter-btn" onclick="filterByFunding('series b')">Series B</button>
    <button class="filter-btn" onclick="filterByFunding('series c+')">Series C+</button>
</div>

<!-- Startups Container -->
<div id="startups-container" class="grid-3 animate-fadeInUp delay-3">
    <div class="loading-spinner"></div>
</div>

<!-- Add Startup Modal -->
<div id="add-startup-modal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="fas fa-rocket"></i> Add New Startup</h2>
            <button class="modal-close" onclick="closeModal('add-startup-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="startup-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="startup-name">Startup Name</label>
                        <input type="text" id="startup-name" name="name" placeholder="Enter startup name" required>
                    </div>
                    <div class="form-group">
                        <label for="startup-type-select">Startup Type</label>
                        <select id="startup-type-select" name="type_id" required>
                            <option value="">Select Type</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="startup-desc">Description</label>
                    <textarea id="startup-desc" name="description" rows="3" placeholder="Describe the startup..."></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="startup-funding">Funding Stage</label>
                        <select id="startup-funding" name="funding_stage">
                            <option value="">Select Stage</option>
                            <option value="Pre-Seed">Pre-Seed</option>
                            <option value="Seed">Seed</option>
                            <option value="Series A">Series A</option>
                            <option value="Series B">Series B</option>
                            <option value="Series C+">Series C+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="startup-website">Website</label>
                        <input type="url" id="startup-website" name="website" placeholder="https://example.com">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="startup-year">Founded Year</label>
                        <input type="number" id="startup-year" name="founded_year" min="1900" max="2030" placeholder="2024">
                    </div>
                    <div class="form-group">
                        <label for="startup-org-select">Organization</label>
                        <select id="startup-org-select" name="org_id">
                            <option value="">Select Organization (Optional)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('add-startup-modal')">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add Startup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
