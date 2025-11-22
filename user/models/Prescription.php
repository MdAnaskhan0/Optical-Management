<?php
class Prescription
{
    private $conn;
    private $table_name = "prescriptions";

    public $id;
    public $patient_name;
    public $age;
    public $phone;
    public $date;
    public $od_sph;
    public $od_cyl;
    public $od_axis;
    public $od_va;
    public $od_prism;
    public $od_base;
    public $os_sph;
    public $os_cyl;
    public $os_axis;
    public $os_va;
    public $os_prism;
    public $os_base;
    public $near_add_od;
    public $near_add_os;
    public $pd_od;
    public $pd_os;
    public $remarks;
    public $lens_type;
    public $visual_categories;
    public $next_examination;
    public $created_by;
    public $created_at;

    // Arrays to store tests and medicines
    public $tests = [];
    public $medicines = [];

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        try {
            $this->conn->beginTransaction();

            // Insert main prescription
            $query = "INSERT INTO " . $this->table_name . "
                    SET patient_name=:patient_name, age=:age, phone=:phone, date=:date, 
                    od_sph=:od_sph, od_cyl=:od_cyl, od_axis=:od_axis, od_va=:od_va, 
                    od_prism=:od_prism, od_base=:od_base, os_sph=:os_sph, 
                    os_cyl=:os_cyl, os_axis=:os_axis, os_va=:os_va, os_prism=:os_prism, 
                    os_base=:os_base, near_add_od=:near_add_od, near_add_os=:near_add_os, 
                    pd_od=:pd_od, pd_os=:pd_os, remarks=:remarks, lens_type=:lens_type, 
                    visual_categories=:visual_categories, next_examination=:next_examination, 
                    created_by=:created_by";

            $stmt = $this->conn->prepare($query);

            // Sanitize
            $this->patient_name = htmlspecialchars(strip_tags($this->patient_name));
            $this->age = $this->age ? htmlspecialchars(strip_tags($this->age)) : null;
            $this->phone = htmlspecialchars(strip_tags($this->phone));
            $this->date = htmlspecialchars(strip_tags($this->date));
            $this->remarks = htmlspecialchars(strip_tags($this->remarks));
            $this->visual_categories = $this->visual_categories ? htmlspecialchars(strip_tags($this->visual_categories)) : null;

            // Bind values
            $stmt->bindParam(":patient_name", $this->patient_name);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":od_sph", $this->od_sph);
            $stmt->bindParam(":od_cyl", $this->od_cyl);
            $stmt->bindParam(":od_axis", $this->od_axis);
            $stmt->bindParam(":od_va", $this->od_va);
            $stmt->bindParam(":od_prism", $this->od_prism);
            $stmt->bindParam(":od_base", $this->od_base);
            $stmt->bindParam(":os_sph", $this->os_sph);
            $stmt->bindParam(":os_cyl", $this->os_cyl);
            $stmt->bindParam(":os_axis", $this->os_axis);
            $stmt->bindParam(":os_va", $this->os_va);
            $stmt->bindParam(":os_prism", $this->os_prism);
            $stmt->bindParam(":os_base", $this->os_base);
            $stmt->bindParam(":near_add_od", $this->near_add_od);
            $stmt->bindParam(":near_add_os", $this->near_add_os);
            $stmt->bindParam(":pd_od", $this->pd_od);
            $stmt->bindParam(":pd_os", $this->pd_os);
            $stmt->bindParam(":remarks", $this->remarks);
            $stmt->bindParam(":lens_type", $this->lens_type);
            $stmt->bindParam(":visual_categories", $this->visual_categories);
            $stmt->bindParam(":next_examination", $this->next_examination);
            $stmt->bindParam(":created_by", $this->created_by);

            if (!$stmt->execute()) {
                throw new Exception("Failed to create prescription");
            }

            $prescription_id = $this->conn->lastInsertId();

            // Insert tests
            if (!empty($this->tests)) {
                foreach ($this->tests as $test) {
                    $test_query = "INSERT INTO prescription_tests (prescription_id, test_id, notes) 
                                 VALUES (:prescription_id, :test_id, :notes)";
                    $test_stmt = $this->conn->prepare($test_query);
                    $test_stmt->bindParam(":prescription_id", $prescription_id);
                    $test_stmt->bindParam(":test_id", $test['test_id']);
                    $test_stmt->bindParam(":notes", $test['notes']);

                    if (!$test_stmt->execute()) {
                        throw new Exception("Failed to add test");
                    }
                }
            }

            // Insert medicines
            if (!empty($this->medicines)) {
                foreach ($this->medicines as $medicine) {
                    $med_query = "INSERT INTO prescription_medicines 
                                (prescription_id, medicine_id, dosage, frequency, duration, instructions) 
                                VALUES (:prescription_id, :medicine_id, :dosage, :frequency, :duration, :instructions)";
                    $med_stmt = $this->conn->prepare($med_query);
                    $med_stmt->bindParam(":prescription_id", $prescription_id);
                    $med_stmt->bindParam(":medicine_id", $medicine['medicine_id']);
                    $med_stmt->bindParam(":dosage", $medicine['dosage']);
                    $med_stmt->bindParam(":frequency", $medicine['frequency']);
                    $med_stmt->bindParam(":duration", $medicine['duration']);
                    $med_stmt->bindParam(":instructions", $medicine['instructions']);

                    if (!$med_stmt->execute()) {
                        throw new Exception("Failed to add medicine");
                    }
                }
            }

            $this->conn->commit();
            return $prescription_id;

        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Prescription creation error: " . $e->getMessage());
            return false;
        }
    }

    // Add methods to get tests and medicines for a prescription
    public function getPrescriptionTests($prescription_id)
    {
        $query = "SELECT pt.*, t.name as test_name 
                  FROM prescription_tests pt 
                  JOIN tests t ON pt.test_id = t.id 
                  WHERE pt.prescription_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $prescription_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPrescriptionMedicines($prescription_id)
    {
        $query = "SELECT pm.*, m.name as medicine_name, m.strength, m.dosage_form 
                  FROM prescription_medicines pm 
                  JOIN medicines m ON pm.medicine_id = m.id 
                  WHERE pm.prescription_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $prescription_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Rest of your existing methods (readAllByUser, readOne) remain the same...
    public function readAllByUser($user_id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE created_by = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        return $stmt;
    }

    public function readOne()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->patient_name = $row['patient_name'];
            $this->age = $row['age'];
            $this->phone = $row['phone'];
            $this->date = $row['date'];
            $this->od_sph = $row['od_sph'];
            $this->od_cyl = $row['od_cyl'];
            $this->od_axis = $row['od_axis'];
            $this->od_va = $row['od_va'];
            $this->od_prism = $row['od_prism'];
            $this->od_base = $row['od_base'];
            $this->os_sph = $row['os_sph'];
            $this->os_cyl = $row['os_cyl'];
            $this->os_axis = $row['os_axis'];
            $this->os_va = $row['os_va'];
            $this->os_prism = $row['os_prism'];
            $this->os_base = $row['os_base'];
            $this->near_add_od = $row['near_add_od'];
            $this->near_add_os = $row['near_add_os'];
            $this->pd_od = $row['pd_od'];
            $this->pd_os = $row['pd_os'];
            $this->remarks = $row['remarks'];
            $this->lens_type = $row['lens_type'];
            $this->visual_categories = $row['visual_categories'];
            $this->next_examination = $row['next_examination'];
            $this->created_by = $row['created_by'];

            // Load tests and medicines
            $this->tests = $this->getPrescriptionTests($this->id);
            $this->medicines = $this->getPrescriptionMedicines($this->id);

            return true;
        }
        return false;
    }
}
?>