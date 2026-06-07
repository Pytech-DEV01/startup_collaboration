<?php
/**
 * Delete API - Handles POST requests to delete records
 * Uses 'type' and 'id' POST parameters to determine which record to delete
 * All queries use prepared statements for security
 */

require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

$type = $_POST['type'] ?? '';
$id   = intval($_POST['id'] ?? 0);
$response = [];

// Validate that an ID was provided
if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'A valid ID is required']);
    exit;
}

switch ($type) {

    // ─── Delete Startup ─────────────────────────────────────────────────
    case 'startup':
        $stmt = $conn->prepare("DELETE FROM startups WHERE startup_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'Startup deleted successfully'];
            } else {
                $response = ['success' => false, 'error' => 'No startup found with the given ID'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Failed to delete startup: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Delete Event ───────────────────────────────────────────────────
    case 'event':
        $stmt = $conn->prepare("DELETE FROM events WHERE event_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'Event deleted successfully'];
            } else {
                $response = ['success' => false, 'error' => 'No event found with the given ID'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Failed to delete event: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Delete Application ─────────────────────────────────────────────
    case 'application':
        $stmt = $conn->prepare("DELETE FROM applications WHERE app_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'Application deleted successfully'];
            } else {
                $response = ['success' => false, 'error' => 'No application found with the given ID'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Failed to delete application: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Delete Collaboration ───────────────────────────────────────────
    case 'collaboration':
        $stmt = $conn->prepare("DELETE FROM collaborations WHERE collab_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'Collaboration deleted successfully'];
            } else {
                $response = ['success' => false, 'error' => 'No collaboration found with the given ID'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Failed to delete collaboration: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Delete Mentorship ──────────────────────────────────────────────
    case 'mentorship':
        $stmt = $conn->prepare("DELETE FROM mentorships WHERE mentorship_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'Mentorship deleted successfully'];
            } else {
                $response = ['success' => false, 'error' => 'No mentorship found with the given ID'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Failed to delete mentorship: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Delete Organization ────────────────────────────────────────────
    case 'organization':
        $stmt = $conn->prepare("DELETE FROM organizations WHERE org_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'Organization deleted successfully'];
            } else {
                $response = ['success' => false, 'error' => 'No organization found with the given ID'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Failed to delete organization: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Default / Invalid Type ─────────────────────────────────────────
    default:
        $response = ['success' => false, 'error' => 'Invalid type parameter'];
        break;
}

echo json_encode($response);
