<?php $currentPage = 'events'; ?>
<?php include '../includes/header.php'; ?>

<!-- Page Header -->
<div class="page-header animate-fadeInUp">
    <div>
        <h1 class="page-title">Events</h1>
        <p>Manage events and workshops</p>
    </div>
    <button class="btn btn-primary" onclick="openModal('add-event-modal')">
        <i class="fas fa-plus"></i> Create Event
    </button>
</div>

<!-- Search & Filters -->
<div class="search-bar animate-fadeInUp delay-1">
    <i class="fas fa-search"></i>
    <input type="text" id="event-search" placeholder="Search events...">
</div>

<div class="filter-group animate-fadeInUp delay-2">
    <button class="filter-btn active" onclick="filterByEventType('all')">All</button>
    <button class="filter-btn" onclick="filterByEventType('workshop')">Workshop</button>
    <button class="filter-btn" onclick="filterByEventType('hackathon')">Hackathon</button>
    <button class="filter-btn" onclick="filterByEventType('pitch')">Pitch</button>
    <button class="filter-btn" onclick="filterByEventType('networking')">Networking</button>
    <button class="filter-btn" onclick="filterByEventType('conference')">Conference</button>
</div>

<!-- Events Container -->
<div id="events-container" class="grid-3 animate-fadeInUp delay-3">
    <div class="loading-spinner"></div>
</div>

<!-- Add Event Modal -->
<div id="add-event-modal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="fas fa-calendar-plus"></i> Create New Event</h2>
            <button class="modal-close" onclick="closeModal('add-event-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="event-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="event-title">Event Title</label>
                        <input type="text" id="event-title" name="title" placeholder="Enter event title" required>
                    </div>
                    <div class="form-group">
                        <label for="event-type-select">Event Type</label>
                        <select id="event-type-select" name="event_type_id" required>
                            <option value="">Select Type</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="event-desc">Description</label>
                    <textarea id="event-desc" name="description" rows="3" placeholder="Describe the event..."></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="event-date">Event Date & Time</label>
                        <input type="datetime-local" id="event-date" name="event_date" required>
                    </div>
                    <div class="form-group">
                        <label for="event-location">Location</label>
                        <input type="text" id="event-location" name="location" placeholder="Event location">
                    </div>
                </div>
                <div class="form-group">
                    <label for="event-max">Max Participants</label>
                    <input type="number" id="event-max" name="max_participants" placeholder="e.g. 100" min="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('add-event-modal')">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Create Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Participants Modal -->
<div id="participants-modal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h2><i class="fas fa-users"></i> Event Participants</h2>
            <button class="modal-close" onclick="closeModal('participants-modal')">&times;</button>
        </div>
        <div class="modal-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Registration Date</th>
                    </tr>
                </thead>
                <tbody id="event-participants-body">
                    <tr><td colspan="4" class="empty-state">Loading...</td></tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline" onclick="closeModal('participants-modal')">Close</button>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
