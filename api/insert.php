<?php
/**
 * Insert API - Handles POST requests to insert new records
 * Uses 'type' POST parameter to determine which table to insert into
 * All queries use prepared statements for security
 */

require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

$type = $_POST['type'] ?? '';
$response = [];

switch ($type) {

    // ─── Insert Startup ─────────────────────────────────────────────────
    case 'startup':
        $name         = $_POST['name'] ?? '';
        $type_id      = intval($_POST['type_id'] ?? 0);
        $description  = $_POST['description'] ?? '';
        $funding_stage = $_POST['funding_stage'] ?? '';
        $website      = $_POST['website'] ?? '';
        $founded_year = intval($_POST['founded_year'] ?? 0);
        $org_id       = !empty($_POST['org_id']) ? intval($_POST['org_id']) : null;

        $stmt = $conn->prepare("INSERT INTO startups (name, type_id, description, funding_stage, website, founded_year, org_id) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssii", $name, $type_id, $description, $funding_stage, $website, $founded_year, $org_id);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Startup added successfully', 'id' => $stmt->insert_id];
        } else {
            $response = ['success' => false, 'error' => 'Failed to add startup: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Insert Event ───────────────────────────────────────────────────
    case 'event':
        $title            = $_POST['title'] ?? '';
        $event_type_id    = intval($_POST['event_type_id'] ?? 0);
        $description      = $_POST['description'] ?? '';
        $event_date       = $_POST['event_date'] ?? '';
        $location         = $_POST['location'] ?? '';
        $max_participants = intval($_POST['max_participants'] ?? 0);

        $stmt = $conn->prepare("INSERT INTO events (title, event_type_id, description, event_date, location, max_participants) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssi", $title, $event_type_id, $description, $event_date, $location, $max_participants);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Event added successfully', 'id' => $stmt->insert_id];
        } else {
            $response = ['success' => false, 'error' => 'Failed to add event: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Insert User ────────────────────────────────────────────────────
    case 'user':
        $full_name = $_POST['full_name'] ?? '';
        $email     = $_POST['email'] ?? '';
        $phone     = $_POST['phone'] ?? '';
        $bio       = $_POST['bio'] ?? '';
        $user_type = $_POST['user_type'] ?? '';

        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, bio, user_type) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $full_name, $email, $phone, $bio, $user_type);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'User added successfully', 'id' => $stmt->insert_id];
        } else {
            $response = ['success' => false, 'error' => 'Failed to add user: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Insert Application ─────────────────────────────────────────────
    case 'application':
        $user_id    = intval($_POST['user_id'] ?? 0);
        $startup_id = intval($_POST['startup_id'] ?? 0);
        $app_type   = $_POST['app_type'] ?? '';
        $message    = $_POST['message'] ?? '';

        $stmt = $conn->prepare("INSERT INTO applications (user_id, startup_id, app_type, message) 
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $user_id, $startup_id, $app_type, $message);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Application submitted successfully', 'id' => $stmt->insert_id];
        } else {
            $response = ['success' => false, 'error' => 'Failed to submit application: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Insert Collaboration ───────────────────────────────────────────
    case 'collaboration':
        $startup_id_1 = intval($_POST['startup_id_1'] ?? 0);
        $startup_id_2 = intval($_POST['startup_id_2'] ?? 0);
        $collab_type  = $_POST['collab_type'] ?? '';
        $start_date   = $_POST['start_date'] ?? '';

        $stmt = $conn->prepare("INSERT INTO collaborations (startup_id_1, startup_id_2, collab_type, start_date) 
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $startup_id_1, $startup_id_2, $collab_type, $start_date);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Collaboration added successfully', 'id' => $stmt->insert_id];
        } else {
            $response = ['success' => false, 'error' => 'Failed to add collaboration: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Insert Mentorship ──────────────────────────────────────────────
    case 'mentorship':
        $mentor_id  = intval($_POST['mentor_id'] ?? 0);
        $mentee_id  = intval($_POST['mentee_id'] ?? 0);
        $focus_area = $_POST['focus_area'] ?? '';
        $start_date = $_POST['start_date'] ?? '';

        $stmt = $conn->prepare("INSERT INTO mentorships (mentor_id, mentee_id, focus_area, start_date) 
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $mentor_id, $mentee_id, $focus_area, $start_date);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Mentorship added successfully', 'id' => $stmt->insert_id];
        } else {
            $response = ['success' => false, 'error' => 'Failed to add mentorship: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Insert Organization ────────────────────────────────────────────
    case 'organization':
        $name        = $_POST['name'] ?? '';
        $org_type    = $_POST['org_type'] ?? '';
        $location    = $_POST['location'] ?? '';
        $website     = $_POST['website'] ?? '';
        $description = $_POST['description'] ?? '';

        $stmt = $conn->prepare("INSERT INTO organizations (name, org_type, location, website, description) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $org_type, $location, $website, $description);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Organization added successfully', 'id' => $stmt->insert_id];
        } else {
            $response = ['success' => false, 'error' => 'Failed to add organization: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Default / Invalid Type ─────────────────────────────────────────
    default:
        $response = ['success' => false, 'error' => 'Invalid type parameter'];
        break;
}

echo json_encode($response);
