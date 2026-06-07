<?php
/**
 * Register API - Dedicated endpoint for event registration
 * Validates duplicate registrations and event capacity before inserting
 * All queries use prepared statements for security
 */

require_once __DIR__ . '/../db.php';

header('Content-Type: application/json');

$response = [];

// Validate required fields
$event_id = intval($_POST['event_id'] ?? 0);
$user_id  = intval($_POST['user_id'] ?? 0);

if ($event_id <= 0 || $user_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Valid event_id and user_id are required']);
    exit;
}

// ─── Step 1: Check if user is already registered for this event ─────────
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM event_registrations WHERE event_id = ? AND user_id = ?");
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if ($row['count'] > 0) {
    echo json_encode(['success' => false, 'error' => 'User is already registered for this event']);
    exit;
}

// ─── Step 2: Check if event has reached max_participants ────────────────
$stmt = $conn->prepare("SELECT max_participants FROM events WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
$stmt->close();

if (!$event) {
    echo json_encode(['success' => false, 'error' => 'Event not found']);
    exit;
}

$max_participants = intval($event['max_participants']);

// Only check capacity if max_participants is set (greater than 0)
if ($max_participants > 0) {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM event_registrations WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reg_count = $result->fetch_assoc()['count'];
    $stmt->close();

    if ($reg_count >= $max_participants) {
        echo json_encode(['success' => false, 'error' => 'Event has reached maximum participant capacity']);
        exit;
    }
}

// ─── Step 3: Register the user for the event ────────────────────────────
$stmt = $conn->prepare("INSERT INTO event_registrations (event_id, user_id) VALUES (?, ?)");
$stmt->bind_param("ii", $event_id, $user_id);

if ($stmt->execute()) {
    $response = [
        'success' => true,
        'message' => 'Successfully registered for the event',
        'id'      => $stmt->insert_id
    ];
} else {
    $response = ['success' => false, 'error' => 'Failed to register: ' . $stmt->error];
}
$stmt->close();

echo json_encode($response);
