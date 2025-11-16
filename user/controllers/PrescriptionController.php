<?php
class PrescriptionController
{
    private $prescriptionModel;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->prescriptionModel = new Prescription($db);
    }

    public function create()
    {
        if ($_POST) {
            $this->prescriptionModel->patient_name = $_POST['patient_name'];
            $this->prescriptionModel->age = $_POST['age'];
            $this->prescriptionModel->date = $_POST['date'];
            $this->prescriptionModel->od_sph = $_POST['od_sph'];
            $this->prescriptionModel->od_cyl = $_POST['od_cyl'];
            $this->prescriptionModel->od_axis = $_POST['od_axis'];
            $this->prescriptionModel->od_va = $_POST['od_va'];
            $this->prescriptionModel->od_prism = $_POST['od_prism'];
            $this->prescriptionModel->od_base = $_POST['od_base'];
            $this->prescriptionModel->os_sph = $_POST['os_sph'];
            $this->prescriptionModel->os_cyl = $_POST['os_cyl'];
            $this->prescriptionModel->os_axis = $_POST['os_axis'];
            $this->prescriptionModel->os_va = $_POST['os_va'];
            $this->prescriptionModel->os_prism = $_POST['os_prism'];
            $this->prescriptionModel->os_base = $_POST['os_base'];
            $this->prescriptionModel->near_add_od = $_POST['near_add_od'];
            $this->prescriptionModel->near_add_os = $_POST['near_add_os'];
            $this->prescriptionModel->pd_od = $_POST['pd_od'];
            $this->prescriptionModel->pd_os = $_POST['pd_os'];
            $this->prescriptionModel->remarks = $_POST['remarks'];
            $this->prescriptionModel->lens_type = $_POST['lens_type'];
            $this->prescriptionModel->next_examination = $_POST['next_examination'];
            $this->prescriptionModel->created_by = $_SESSION['user_id'];

            if ($this->prescriptionModel->create()) {
                // Get the last inserted ID
                $last_id = $this->db->lastInsertId();
                header("Location: prescriptions.php?action=view&id=" . $last_id . "&print=true");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Unable to create prescription.</div>";
            }
        }
        include_once 'views/prescriptions/create.php';
    }

    public function list()
    {
        $stmt = $this->prescriptionModel->readAllByUser($_SESSION['user_id']);
        include_once 'views/prescriptions/list.php';
    }

    public function view()
    {
        $this->prescriptionModel->id = $_GET['id'];
        $result = $this->prescriptionModel->readOne();

        if ($result && $this->prescriptionModel->created_by == $_SESSION['user_id']) {
            $prescription = $this->prescriptionModel;
            include_once 'views/prescriptions/view.php';
        } else {
            echo "<div class='alert alert-danger'>Prescription not found or access denied.</div>";
        }
    }
}
?>