<?php
/**
 * Fetch API - Handles all GET/SELECT requests
 * Uses 'type' query parameter to determine what data to fetch
 */

require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

$type = $_GET['type'] ?? '';
$response = [];

switch ($type) {

    // ─── Dashboard Statistics ───────────────────────────────────────────
    case 'dashboard_stats':
        $stats = [];

        // Total startups
        $result = $conn->query("SELECT COUNT(*) as count FROM startups");
        $stats['total_startups'] = $result ? $result->fetch_assoc()['count'] : 0;

        // Total events
        $result = $conn->query("SELECT COUNT(*) as count FROM events");
        $stats['total_events'] = $result ? $result->fetch_assoc()['count'] : 0;

        // Total investors
        $result = $conn->query("SELECT COUNT(*) as count FROM users WHERE user_type = 'investor'");
        $stats['total_investors'] = $result ? $result->fetch_assoc()['count'] : 0;

        // Total collaborations
        $result = $conn->query("SELECT COUNT(*) as count FROM collaborations");
        $stats['total_collaborations'] = $result ? $result->fetch_assoc()['count'] : 0;

        // Total organizations
        $result = $conn->query("SELECT COUNT(*) as count FROM organizations");
        $stats['total_organizations'] = $result ? $result->fetch_assoc()['count'] : 0;

        // Total users
        $result = $conn->query("SELECT COUNT(*) as count FROM users");
        $stats['total_users'] = $result ? $result->fetch_assoc()['count'] : 0;

        $response = $stats;
        break;

    // ─── All Startups ───────────────────────────────────────────────────
    case 'startups':
        $sql = "SELECT s.*, st.type_name, GROUP_CONCAT(u.full_name SEPARATOR ', ') as founders
                FROM startups s
                LEFT JOIN startup_types st ON s.type_id = st.type_id
                LEFT JOIN startup_founders sf ON s.startup_id = sf.startup_id
                LEFT JOIN users u ON sf.user_id = u.user_id
                GROUP BY s.startup_id
                ORDER BY s.created_at DESC";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch startups: ' . $conn->error];
        }
        break;

    // ─── Recent Startups (Top 5) ────────────────────────────────────────
    case 'recent_startups':
        $sql = "SELECT s.*, st.type_name, GROUP_CONCAT(u.full_name SEPARATOR ', ') as founders
                FROM startups s
                LEFT JOIN startup_types st ON s.type_id = st.type_id
                LEFT JOIN startup_founders sf ON s.startup_id = sf.startup_id
                LEFT JOIN users u ON sf.user_id = u.user_id
                GROUP BY s.startup_id
                ORDER BY s.created_at DESC
                LIMIT 5";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch recent startups: ' . $conn->error];
        }
        break;

    // ─── All Events ─────────────────────────────────────────────────────
    case 'events':
        $sql = "SELECT e.*, et.type_name, COUNT(er.reg_id) as participant_count
                FROM events e
                LEFT JOIN event_types et ON e.event_type_id = et.event_type_id
                LEFT JOIN event_registrations er ON e.event_id = er.event_id
                GROUP BY e.event_id
                ORDER BY e.event_date ASC";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch events: ' . $conn->error];
        }
        break;

    // ─── Upcoming Events (Top 5) ────────────────────────────────────────
    case 'upcoming_events':
        $sql = "SELECT e.*, et.type_name, COUNT(er.reg_id) as participant_count
                FROM events e
                LEFT JOIN event_types et ON e.event_type_id = et.event_type_id
                LEFT JOIN event_registrations er ON e.event_id = er.event_id
                WHERE e.event_date >= NOW()
                GROUP BY e.event_id
                ORDER BY e.event_date ASC
                LIMIT 5";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch upcoming events: ' . $conn->error];
        }
        break;

    // ─── Investors ──────────────────────────────────────────────────────
    case 'investors':
        $sql = "SELECT u.*, si.investment_amount, si.investment_date, s.name as startup_name
                FROM users u
                INNER JOIN startup_investors si ON u.user_id = si.user_id
                INNER JOIN startups s ON si.startup_id = s.startup_id
                WHERE u.user_type = 'investor'
                ORDER BY si.investment_amount DESC";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch investors: ' . $conn->error];
        }
        break;

    // ─── Organizations ──────────────────────────────────────────────────
    case 'organizations':
        $sql = "SELECT o.*, COUNT(DISTINCT s.startup_id) as startup_count, COUNT(DISTINCT eo.event_id) as event_count
                FROM organizations o
                LEFT JOIN startups s ON o.org_id = s.org_id
                LEFT JOIN event_organizers eo ON o.org_id = eo.org_id
                GROUP BY o.org_id";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch organizations: ' . $conn->error];
        }
        break;

    // ─── Applications ───────────────────────────────────────────────────
    case 'applications':
        $sql = "SELECT a.*, u.full_name, u.email, s.name as startup_name
                FROM applications a
                JOIN users u ON a.user_id = u.user_id
                JOIN startups s ON a.startup_id = s.startup_id
                ORDER BY a.applied_at DESC";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch applications: ' . $conn->error];
        }
        break;

    // ─── Collaborations ─────────────────────────────────────────────────
    case 'collaborations':
        $sql = "SELECT c.*, s1.name as startup1_name, s2.name as startup2_name
                FROM collaborations c
                JOIN startups s1 ON c.startup_id_1 = s1.startup_id
                JOIN startups s2 ON c.startup_id_2 = s2.startup_id
                ORDER BY c.start_date DESC";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch collaborations: ' . $conn->error];
        }
        break;

    // ─── Mentorships ────────────────────────────────────────────────────
    case 'mentorships':
        $sql = "SELECT m.*, 
                    mentor.full_name as mentor_name, mentor.bio as mentor_bio, 
                    mentee.full_name as mentee_name, mentee.bio as mentee_bio
                FROM mentorships m
                JOIN users mentor ON m.mentor_id = mentor.user_id
                JOIN users mentee ON m.mentee_id = mentee.user_id";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch mentorships: ' . $conn->error];
        }
        break;

    // ─── Event Participants (by event_id) ───────────────────────────────
    case 'participants':
        $event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

        if ($event_id <= 0) {
            $response = ['error' => 'Valid event_id is required'];
            break;
        }

        $stmt = $conn->prepare("SELECT er.*, u.full_name, u.email, u.phone
                                FROM event_registrations er
                                JOIN users u ON er.user_id = u.user_id
                                WHERE er.event_id = ?");
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
        $stmt->close();
        break;

    // ─── Event Types (for dropdowns) ────────────────────────────────────
    case 'event_types':
        $result = $conn->query("SELECT * FROM event_types");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch event types: ' . $conn->error];
        }
        break;

    // ─── Startup Types (for dropdowns) ──────────────────────────────────
    case 'startup_types':
        $result = $conn->query("SELECT * FROM startup_types");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch startup types: ' . $conn->error];
        }
        break;

    // ─── Users List (for dropdowns) ─────────────────────────────────────
    case 'users_list':
        $result = $conn->query("SELECT user_id, full_name, email, user_type FROM users ORDER BY full_name");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch users list: ' . $conn->error];
        }
        break;

    // ─── Startups List (for dropdowns) ──────────────────────────────────
    case 'startups_list':
        $result = $conn->query("SELECT startup_id, name FROM startups ORDER BY name");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch startups list: ' . $conn->error];
        }
        break;

    // ─── Organizations List (for dropdowns) ─────────────────────────────
    case 'organizations_list':
        $result = $conn->query("SELECT org_id, name FROM organizations ORDER BY name");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
        } else {
            $response = ['error' => 'Failed to fetch organizations list: ' . $conn->error];
        }
        break;

    // ─── Default / Invalid Type ─────────────────────────────────────────
    default:
        $response = ['error' => 'Invalid type parameter'];
        break;
}

echo json_encode($response);
