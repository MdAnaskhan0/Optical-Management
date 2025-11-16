<?php
include '../includes/config.php';
requireLogin();

// Include models and controllers
include 'models/Prescription.php';
include 'controllers/PrescriptionController.php';

// Create database connection and controller
$prescriptionController = new PrescriptionController($pdo);

// Determine action
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Route to appropriate method
switch ($action) {
    case 'create':
        $prescriptionController->create();
        break;
    case 'view':
        $prescriptionController->view();
        break;
    case 'list':
    default:
        $prescriptionController->list();
        break;
}
?>