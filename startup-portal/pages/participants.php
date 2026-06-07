<?php $currentPage = 'participants'; ?>
<?php include '../includes/header.php'; ?>

<!-- Page Header -->
<div class="page-header animate-fadeInUp">
    <div>
        <h1 class="page-title">Event Participants</h1>
        <p>View and manage event registrations</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('add-registration-modal')">
        <i class="fas fa-plus"></i> Register for Event
    </button>
</div>

<!-- Event Selector -->
<div class="form-group animate-fadeInUp delay-1" style="max-width: 500px; margin-bottom: 1.5rem;">
    <label for="event-selector"><i class="fas fa-calendar"></i> Select Event</label>
    <select id="event-selector" onchange="loadParticipants(this.value)">
        <option value="">-- Select an Event --</option>
    </select>
</div>

<!-- Participants Table -->
<div class="card animate-fadeInUp delay-2">
    <div class="card-body" style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Registration Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="participants-table">
                <tr><td colspan="5" class="empty-state">Select an event to view participants</td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Registration Modal -->
<div id="add-registration-modal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="fas fa-user-plus"></i> Register for Event</h2>
            <button class="modal-close" onclick="closeModal('add-registration-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="registration-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="reg-event-select">Event</label>
                        <select id="reg-event-select" name="event_id" required>
                            <option value="">Select Event</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reg-user-select">Participant</label>
                        <select id="reg-user-select" name="user_id" required>
                            <option value="">Select Participant</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('add-registration-modal')">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
