class User {
    public $userId;
    public $email;
    public $password;

    public function __construct($userId = null, $email = null, $password = null) {
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
    }

    public static function login($email, $password) {
        $query = "EXEC USP_Login @Email = :email, @Password = :password";

        $params = [
            ':email' => $email,
            ':password' => $password
        ];

        $result = DataProvider::Instance()->executeQuery($query, $params);

        return count($result) > 0;
    }

    public static function register($email, $password) {
        $query = "EXEC USP_Register @Email = :email, @Password = :password";

        $params = [
            ':email' => $email,
            ':password' => $password
        ];

        $result = DataProvider::Instance()->executeNonQuery($query, $params);

        return $result > 0;
    }
}