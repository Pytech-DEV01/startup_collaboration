<?php $currentPage = 'dashboard'; ?>
<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<div class="page-header animate-fadeInUp">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p>Overview of your startup ecosystem</p>
    </div>
</div>

<!-- Stats Row -->
<div class="stats-row">
    <div class="stat-card animate-fadeInUp delay-1">
        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <i class="fas fa-rocket"></i>
        </div>
        <h3><span id="stat-startups">0</span></h3>
        <p>Total Startups</p>
    </div>
    <div class="stat-card animate-fadeInUp delay-2">
        <div class="stat-icon" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
            <i class="fas fa-calendar"></i>
        </div>
        <h3><span id="stat-events">0</span></h3>
        <p>Total Events</p>
    </div>
    <div class="stat-card animate-fadeInUp delay-3">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f7971e, #ffd200);">
            <i class="fas fa-hand-holding-usd"></i>
        </div>
        <h3><span id="stat-investors">0</span></h3>
        <p>Total Investors</p>
    </div>
    <div class="stat-card animate-fadeInUp delay-4">
        <div class="stat-icon" style="background: linear-gradient(135deg, #a855f7, #6366f1);">
            <i class="fas fa-handshake"></i>
        </div>
        <h3><span id="stat-collaborations">0</span></h3>
        <p>Collaborations</p>
    </div>
    <div class="stat-card animate-fadeInUp delay-1">
        <div class="stat-icon" style="background: linear-gradient(135deg, #06b6d4, #0891b2);">
            <i class="fas fa-building"></i>
        </div>
        <h3><span id="stat-organizations">0</span></h3>
        <p>Organizations</p>
    </div>
    <div class="stat-card animate-fadeInUp delay-2">
        <div class="stat-icon" style="background: linear-gradient(135deg, #ec4899, #f43f5e);">
            <i class="fas fa-users"></i>
        </div>
        <h3><span id="stat-users">0</span></h3>
        <p>Total Users</p>
    </div>
</div>

<!-- Dashboard Grid -->
<div class="dashboard-grid">
    <!-- Left Column (Main) -->
    <div class="dashboard-main">
        <!-- Recent Startups -->
        <div class="card animate-fadeInUp delay-3">
            <div class="card-header">
                <h3><i class="fas fa-rocket"></i> Recent Startups</h3>
                <a href="pages/startups.php" class="btn btn-outline btn-sm">View All</a>
            </div>
            <div class="card-body" id="recent-startups-container">
                <div class="loading-spinner"></div>
            </div>
        </div>

        <!-- Active Collaborations -->
        <div class="card animate-fadeInUp delay-4">
            <div class="card-header">
                <h3><i class="fas fa-handshake"></i> Active Collaborations</h3>
            </div>
            <div class="card-body" id="collaborations-container">
                <div class="loading-spinner"></div>
            </div>
        </div>
    </div>

    <!-- Right Column (Sidebar) -->
    <div class="dashboard-sidebar">
        <!-- Upcoming Events -->
        <div class="card animate-fadeInUp delay-3">
            <div class="card-header">
                <h3><i class="fas fa-calendar-alt"></i> Upcoming Events</h3>
                <a href="pages/events.php" class="btn btn-outline btn-sm">View All</a>
            </div>
            <div class="card-body" id="upcoming-events-container">
                <div class="loading-spinner"></div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions animate-fadeInUp delay-4">
            <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
            <div class="quick-actions-grid">
                <a href="pages/startups.php" class="quick-action-btn">
                    <i class="fas fa-plus"></i>
                    <span>Add Startup</span>
                </a>
                <a href="pages/events.php" class="quick-action-btn">
                    <i class="fas fa-calendar-plus"></i>
                    <span>Create Event</span>
                </a>
                <a href="pages/participants.php" class="quick-action-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Register</span>
                </a>
                <a href="pages/applications.php" class="quick-action-btn">
                    <i class="fas fa-file-alt"></i>
                    <span>New Application</span>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
