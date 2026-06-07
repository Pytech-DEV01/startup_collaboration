<?php
/**
 * Update API - Handles POST requests to update existing records
 * Primarily used for status updates on applications, collaborations, mentorships, and registrations
 * All queries use prepared statements for security
 */

require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

$type = $_POST['type'] ?? '';
$response = [];

switch ($type) {

    // ─── Update Application Status ──────────────────────────────────────
    case 'application_status':
        $app_id = intval($_POST['app_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if ($app_id <= 0 || empty($status)) {
            $response = ['success' => false, 'error' => 'app_id and status are required'];
            break;
        }

        $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE app_id = ?");
        $stmt->bind_param("si", $status, $app_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'Application status updated successfully'];
            } else {
                $response = ['success' => false, 'error' => 'No application found with the given ID'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Failed to update application status: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Update Collaboration Status ────────────────────────────────────
    case 'collaboration_status':
        $collab_id = intval($_POST['collab_id'] ?? 0);
        $status    = $_POST['status'] ?? '';

        if ($collab_id <= 0 || empty($status)) {
            $response = ['success' => false, 'error' => 'collab_id and status are required'];
            break;
        }

        $stmt = $conn->prepare("UPDATE collaborations SET status = ? WHERE collab_id = ?");
        $stmt->bind_param("si", $status, $collab_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'Collaboration status updated successfully'];
            } else {
                $response = ['success' => false, 'error' => 'No collaboration found with the given ID'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Failed to update collaboration status: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Update Mentorship Status ───────────────────────────────────────
    case 'mentorship_status':
        $mentorship_id = intval($_POST['mentorship_id'] ?? 0);
        $status        = $_POST['status'] ?? '';

        if ($mentorship_id <= 0 || empty($status)) {
            $response = ['success' => false, 'error' => 'mentorship_id and status are required'];
            break;
        }

        $stmt = $conn->prepare("UPDATE mentorships SET status = ? WHERE mentorship_id = ?");
        $stmt->bind_param("si", $status, $mentorship_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'Mentorship status updated successfully'];
            } else {
                $response = ['success' => false, 'error' => 'No mentorship found with the given ID'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Failed to update mentorship status: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Update Registration Status ─────────────────────────────────────
    case 'registration_status':
        $reg_id = intval($_POST['reg_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if ($reg_id <= 0 || empty($status)) {
            $response = ['success' => false, 'error' => 'reg_id and status are required'];
            break;
        }

        $stmt = $conn->prepare("UPDATE event_registrations SET status = ? WHERE reg_id = ?");
        $stmt->bind_param("si", $status, $reg_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => 'Registration status updated successfully'];
            } else {
                $response = ['success' => false, 'error' => 'No registration found with the given ID'];
            }
        } else {
            $response = ['success' => false, 'error' => 'Failed to update registration status: ' . $stmt->error];
        }
        $stmt->close();
        break;

    // ─── Default / Invalid Type ─────────────────────────────────────────
    default:
        $response = ['success' => false, 'error' => 'Invalid type parameter'];
        break;
}

echo json_encode($response);
