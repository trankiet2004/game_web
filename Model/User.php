<?php
require_once('DBConnect.php');
class User {
    public $id;
    public $username;
    public $email;
    public $password;
    public $role;  // admin or user

    public function __construct($username, $email, $password, $role = 'user') {
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT); // securely hashing the password
        $this->role = $role;
    }

    // Save user to the database
    public function save() {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->username, $this->email, $this->password, $this->role);
        if ($stmt->execute()) {
            echo "User saved successfully!";
        } else {
            echo "Error saving user: " . $stmt->error;
        }
    }

    // Find user by username or email
    public static function findByUsername($username) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_object('User');
    }

    // Validate password
    public function checkPassword($password) {
        return password_verify($password, $this->password);
    }
    
    public function update() {
        global $conn;
        $stmt = $conn->prepare("UPDATE users SET email = ?, phone = ?, city = ? WHERE id = ?");
        $stmt->bind_param("sssi", $this->email, $this->phone, $this->city, $this->id);
        if ($stmt->execute()) {
            echo "Thông tin cập nhật thành công!";
        } else {
            echo "Lỗi khi cập nhật thông tin: " . $stmt->error;
        }
    }
}
?>
