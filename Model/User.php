<?php
require_once('DBConnect.php');
class User {
    public $id;
    public $username;
    public $email;
    public $password;
    public $role;  // admin or user
    /**
     * @param string $username
     * @param string $email
     * @param string $password  – nếu từ signup thì là raw password, nếu từ DB thì là hashed password
     * @param string $role
     * @param bool   $isHashed  – TRUE nếu $password đã được hash, FALSE nếu là raw
     */

    public function __construct(string $username,string $email,string $password,string $role = 'user',bool $isHashed = false) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $isHashed ? $password : password_hash($password, PASSWORD_DEFAULT); // securely hashing the password
        $this->role = $role;
    }

    public static function GET($table, $id, $idColumn) {
        header("Content-type: application/json");

        global $connect;
        try {
            $SQL = $id === null ? "SELECT * FROM $table" : "SELECT * FROM $table WHERE $idColumn = $id";
            $query = $connect->query($SQL);

            if(!$query) {
                throw new Exception("Query execution failed: " . $connect->error);
            }

            $jsonResponse = [];
            while($row = $query->fetch_assoc()) {
                $jsonResponse[] = $row;
            }

            http_response_code(200);
            echo json_encode($jsonResponse);
        } catch (mysqli_sql_exception $e) {
            http_response_code(500);
            echo json_encode([
                "error" => "SQL Error: " . $e->getMessage()
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "error" => "An unexpected error occured: " . $e->getMessage()
            ]);
        }
    }

    // Save user to the database
    public function save() {
        global $connect;
        $sql = $connect->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $sql->bind_param("ssss", $this->username, $this->email, $this->password, $this->role);
        if ($sql->execute()) {
            echo "User saved successfully!";
        } else {
            echo "Error saving user: " . $stmt->error;
        }
    }

    // Find user by username or email
    public static function findByUsername($username): ?self {
        global $connect;
        $sql = @$connect->prepare("SELECT * FROM users WHERE username = ?");
    if (!$sql) {
        // Có thể table không tồn tại hoặc lỗi SQL → coi như không tìm thấy user
        return null;
    }
        $sql->bind_param("s", $username);
        $sql->execute();
        $res = $sql->get_result();

        if ($row = $res->fetch_assoc()) {
            // khởi tạo mới với đủ tham số
            $user = new User(
                $row['username'],      // username
                $row['email'],         // email
                $row['password'],      // hashed password
                $row['role'],          // role
                true
            );
            $user->id = $row['id'];    // gán thêm id
            return $user;
        }
        return null;
    }

    // Validate password
    public function checkPassword($password) {
        return password_verify($password, $this->password);
    }
    
    public function update() {
        global $connect;
        $stmt = $connect->prepare("UPDATE users SET email = ?, phone = ?, city = ? WHERE id = ?");
        $stmt->bind_param("sssi", $this->email, $this->phone, $this->city, $this->id);
        if ($stmt->execute()) {
            echo "Thông tin cập nhật thành công!";
        } else {
            echo "Lỗi khi cập nhật thông tin: " . $stmt->error;
        }
    }
}
?>
