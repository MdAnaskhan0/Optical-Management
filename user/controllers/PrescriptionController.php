<?php
class PrescriptionController
{
    private $prescriptionModel;
    private $db;
    public $view_data = [];

    public function __construct($db)
    {
        $this->db = $db;
        $this->prescriptionModel = new Prescription($db);
    }

    public function create()
    {
        // Fetch categories and lenses from database
        try {
            $categories_stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
            $categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $categories = [];
            error_log("Categories query error: " . $e->getMessage());
        }

        try {
            $lenses_stmt = $this->db->query("
                SELECT l.*, c.name as category_name 
                FROM lenses l 
                LEFT JOIN categories c ON l.category_id = c.id 
                ORDER BY c.name, l.name
            ");
            $lenses = $lenses_stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $lenses = [];
            error_log("Lenses query error: " . $e->getMessage());
        }

        // Fetch tests
        try {
            $tests_stmt = $this->db->query("SELECT * FROM tests ORDER BY name");
            $tests = $tests_stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $tests = [];
            error_log("Tests query error: " . $e->getMessage());
        }

        // Fetch medicines
        try {
            $medicines_stmt = $this->db->query("SELECT * FROM medicines ORDER BY name");
            $medicines = $medicines_stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $medicines = [];
            error_log("Medicines query error: " . $e->getMessage());
        }

        // Group lenses by category for better organization
        $lenses_by_category = [];
        if (!empty($lenses)) {
            foreach ($lenses as $lens) {
                $category_name = !empty($lens['category_name']) ? $lens['category_name'] : 'Uncategorized';
                if (!isset($lenses_by_category[$category_name])) {
                    $lenses_by_category[$category_name] = [];
                }
                $lenses_by_category[$category_name][] = $lens;
            }
        }

        if ($_POST) {
            // Set basic prescription data (your existing code)
            $this->prescriptionModel->patient_name = $_POST['patient_name'] ?? '';
            $this->prescriptionModel->age = $_POST['age'] ?? null;
            $this->prescriptionModel->phone = $_POST['phone'] ?? '';
            $this->prescriptionModel->date = $_POST['date'] ?? '';
            $this->prescriptionModel->od_sph = $_POST['od_sph'] ?? '';
            $this->prescriptionModel->od_cyl = $_POST['od_cyl'] ?? '';
            $this->prescriptionModel->od_axis = $_POST['od_axis'] ?? '';
            $this->prescriptionModel->od_va = $_POST['od_va'] ?? '';
            $this->prescriptionModel->od_prism = $_POST['od_prism'] ?? '';
            $this->prescriptionModel->od_base = $_POST['od_base'] ?? '';
            $this->prescriptionModel->os_sph = $_POST['os_sph'] ?? '';
            $this->prescriptionModel->os_cyl = $_POST['os_cyl'] ?? '';
            $this->prescriptionModel->os_axis = $_POST['os_axis'] ?? '';
            $this->prescriptionModel->os_va = $_POST['os_va'] ?? '';
            $this->prescriptionModel->os_prism = $_POST['os_prism'] ?? '';
            $this->prescriptionModel->os_base = $_POST['os_base'] ?? '';
            $this->prescriptionModel->near_add_od = $_POST['near_add_od'] ?? '';
            $this->prescriptionModel->near_add_os = $_POST['near_add_os'] ?? '';
            $this->prescriptionModel->pd_od = $_POST['pd_od'] ?? '';
            $this->prescriptionModel->pd_os = $_POST['pd_os'] ?? '';
            $this->prescriptionModel->remarks = $_POST['remarks'] ?? '';

            // Store selected Visual Categories
            $selected_categories = $_POST['visual_categories'] ?? [];
            $this->prescriptionModel->visual_categories = !empty($selected_categories) ? implode(',', $selected_categories) : null;

            $this->prescriptionModel->lens_type = $_POST['lens_type'] ?? '';
            $this->prescriptionModel->next_examination = $_POST['next_examination'] ?? null;
            $this->prescriptionModel->created_by = $_SESSION['user_id'] ?? null;

            // Process tests
            $selected_tests = $_POST['tests'] ?? [];
            $test_notes = $_POST['test_notes'] ?? [];

            foreach ($selected_tests as $test_id) {
                $this->prescriptionModel->tests[] = [
                    'test_id' => $test_id,
                    'notes' => $test_notes[$test_id] ?? ''
                ];
            }

            // Process medicines
            $selected_medicines = $_POST['medicines'] ?? [];
            $medicine_dosage = $_POST['medicine_dosage'] ?? [];
            $medicine_frequency = $_POST['medicine_frequency'] ?? [];
            $medicine_duration = $_POST['medicine_duration'] ?? [];
            $medicine_instructions = $_POST['medicine_instructions'] ?? [];

            foreach ($selected_medicines as $medicine_id) {
                $this->prescriptionModel->medicines[] = [
                    'medicine_id' => $medicine_id,
                    'dosage' => $medicine_dosage[$medicine_id] ?? '',
                    'frequency' => $medicine_frequency[$medicine_id] ?? '',
                    'duration' => $medicine_duration[$medicine_id] ?? '',
                    'instructions' => $medicine_instructions[$medicine_id] ?? ''
                ];
            }

            $prescription_id = $this->prescriptionModel->create();
            if ($prescription_id) {
                header("Location: prescriptions.php?action=view&id=" . $prescription_id . "&print=true");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Unable to create prescription.</div>";
            }
        }

        // Pass data to view
        $view_categories = $categories;
        $view_lenses_by_category = $lenses_by_category;
        $view_lenses = $lenses;
        $view_tests = $tests;
        $view_medicines = $medicines;

        // Include the view file
        include_once 'views/prescriptions/create.php';
    }

    public function list()
    {
        $stmt = $this->prescriptionModel->readAllByUser($_SESSION['user_id']);
        include_once 'views/prescriptions/list.php';
    }

    public function view()
    {
        $this->prescriptionModel->id = $_GET['id'] ?? null;
        $result = $this->prescriptionModel->readOne();

        if ($result && $this->prescriptionModel->created_by == $_SESSION['user_id']) {
            $prescription = $this->prescriptionModel;

            // Fetch categories and lenses for the view
            try {
                $categories_stmt = $this->db->query("SELECT * FROM categories ORDER BY name");
                $categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $categories = [];
            }

            try {
                $lenses_stmt = $this->db->query("
                    SELECT l.*, c.name as category_name 
                    FROM lenses l 
                    LEFT JOIN categories c ON l.category_id = c.id 
                    ORDER BY c.name, l.name
                ");
                $lenses = $lenses_stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $lenses = [];
            }

            // Fetch tests and medicines for display
            try {
                $tests_stmt = $this->db->query("SELECT * FROM tests ORDER BY name");
                $tests = $tests_stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $tests = [];
            }

            try {
                $medicines_stmt = $this->db->query("SELECT * FROM medicines ORDER BY name");
                $medicines = $medicines_stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $medicines = [];
            }

            // Group lenses by category for better organization
            $lenses_by_category = [];
            if (!empty($lenses)) {
                foreach ($lenses as $lens) {
                    $category_name = !empty($lens['category_name']) ? $lens['category_name'] : 'Uncategorized';
                    if (!isset($lenses_by_category[$category_name])) {
                        $lenses_by_category[$category_name] = [];
                    }
                    $lenses_by_category[$category_name][] = $lens;
                }
            }

            include_once 'views/prescriptions/view.php';
        } else {
            echo "<div class='alert alert-danger'>Prescription not found or access denied.</div>";
        }
    }
}
?>