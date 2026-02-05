<?php
class User {
    protected $conn;
    protected $table_name;

    public $id;
    public $name;
    public $cnic;
    public $address;
    public $password;
    public $email;
    public $phone;
    public $town;
    public $region;
    public $postcode;
    public $country;
    public $status;  // Set default status to "active"

    public function __construct($db) {
        $this->conn = $db;
    }

    // Generate unique ID based on the user type
    public function generateUniqueId() {
        $prefix = "";
        if ($this instanceof Admin) {
            $prefix = "AD";
        } elseif ($this instanceof Candidate) {
            $prefix = "CD";
        } elseif ($this instanceof Recruiter) {
            $prefix = "RT";
        }

        $query = "SELECT id FROM " . $this->table_name . " ORDER BY id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $lastId = $row['id'];
            $number = (int)substr($lastId, 2); // Extract the number part
            $newNumber = str_pad($number + 1, 2, "0", STR_PAD_LEFT); // Increment and pad with zeros
            $this->id = $prefix . $newNumber;
        } else {
            $this->id = $prefix . "01"; // First user of this type
        }
        return $this->id;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET id=:id, name=:name, cnic=:cnic, address=:address, password=:password, email=:email, phone=:phone, town=:town, region=:region, postcode=:postcode, country=:country, status=:status";

        $stmt = $this->conn->prepare($query);

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":cnic", $this->cnic);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":town", $this->town);
        $stmt->bindParam(":region", $this->region);
        $stmt->bindParam(":postcode", $this->postcode);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":status", $this->status); // Bind the status parameter

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row && password_verify($this->password, $row['password'])) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->email = $row['email'];

            $_SESSION['set_id'] = $this->id;
            $_SESSION['set_name'] = $this->name;
            $_SESSION['set_email'] = $this->email;
            return true;
        }
        return false;
    }
}
?>
