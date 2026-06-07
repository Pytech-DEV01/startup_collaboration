<?php $currentPage = 'mentorships'; ?>
<?php include '../includes/header.php'; ?>

<!-- Page Header -->
<div class="page-header animate-fadeInUp">
    <div>
        <h1 class="page-title">Mentorships</h1>
        <p>Manage mentor-mentee relationships</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('add-mentorship-modal')">
        <i class="fas fa-plus"></i> Create Mentorship
    </button>
</div>

<!-- Mentorships Container -->
<div id="mentorships-container" class="grid-2 animate-fadeInUp delay-1">
    <div class="loading-spinner"></div>
</div>

<!-- Create Mentorship Modal -->
<div id="add-mentorship-modal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="fas fa-users"></i> Create Mentorship</h2>
            <button class="modal-close" onclick="closeModal('add-mentorship-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="mentorship-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="mentor-select">Mentor</label>
                        <select id="mentor-select" name="mentor_id" required>
                            <option value="">Select Mentor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mentee-select">Mentee</label>
                        <select id="mentee-select" name="mentee_id" required>
                            <option value="">Select Mentee</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="mentorship-focus">Focus Area</label>
                        <input type="text" id="mentorship-focus" name="focus_area" placeholder="e.g. Product Development" required>
                    </div>
                    <div class="form-group">
                        <label for="mentorship-start">Start Date</label>
                        <input type="date" id="mentorship-start" name="start_date" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('add-mentorship-modal')">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create Mentorship</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
