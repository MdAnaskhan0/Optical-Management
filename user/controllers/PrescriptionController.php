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

        // Debug output - remove this after testing
        echo "<!-- Debug: Categories count: " . count($categories) . " -->";
        echo "<!-- Debug: Lenses count: " . count($lenses) . " -->";
        echo "<!-- Debug: Lenses by category count: " . count($lenses_by_category) . " -->";

        if ($_POST) {
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

            if ($this->prescriptionModel->create()) {
                $last_id = $this->db->lastInsertId();
                header("Location: prescriptions.php?action=view&id=" . $last_id . "&print=true");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Unable to create prescription.</div>";
            }
        }

        // Pass data to view - USE LOCAL VARIABLES INSTEAD OF $this->view_data
        $view_categories = $categories;
        $view_lenses_by_category = $lenses_by_category;
        $view_lenses = $lenses;

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