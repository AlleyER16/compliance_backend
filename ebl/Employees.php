<?php

    require_once dirname(__FILE__)."/config/Dbh.config.php";

    class Employees extends Dbh{

        const EMPLOYEES_TABLE = "employees";

        public function __construct() {

            $this->dbh_object = $this->getConnection();

        }

        public function exployee_exists_uc(string $key, string $value) : bool {

            $sql = "SELECT COUNT(ID) FROM ".self::EMPLOYEES_TABLE." WHERE $key = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            $prepared_statement->execute([$value]);

            return ($prepared_statement->fetchColumn() == 1);

        }

        public function username_exists(string $username) : bool {

            $sql = "SELECT COUNT(ID) FROM ".self::EMPLOYEES_TABLE." WHERE Username = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            $prepared_statement->execute([$username]);

            return ($prepared_statement->fetchColumn() == 1);

        }

        public function get_employee(int $employee_id) : array {

            $sql = "SELECT * FROM ".self::EMPLOYEES_TABLE." WHERE ID = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            $prepared_statement->execute([$employee_id]);

            return ($prepared_statement->rowCount() == 1) ? [true, $prepared_statement->fetchAll()[0]] : [false];

        }

        public function employee_login(string $username, string $password) : array {

            $sql = "SELECT * FROM ".self::EMPLOYEES_TABLE." WHERE Username = ? AND Password = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            $prepared_statement->execute(func_get_args());

            return ($prepared_statement->rowCount() == 1) ? [true, $prepared_statement->fetchAll()[0]] : [false];

        }

        public function get_num_employees(
            string $name_search, 
            bool $status
        ) : int {

            $sql = "SELECT COUNT(ID) FROM ".self::EMPLOYEES_TABLE." WHERE CONCAT(FirstName, LastName) LIKE ? AND Status = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            $prepared_statement->execute(["%$name_search%", $status]);

            return $prepared_statement->fetchColumn();

        }

        public function get_employees_pagination(
            string $name_search, 
            bool $status, 
            int $division
        ) : int {

            $num_employees = $this->get_num_employees($name_search, $status);
            $pages = floor($num_employees/$division);
            return (($num_employees % $division) > 0) ? $pages + 1 : $pages;

        }

        public function get_employees(
            string $name_search, 
            bool $status,
            int $page,
            int $division
        ) : array {

            $start = ($page - 1) * $division;

            $sql = "SELECT * FROM ".self::EMPLOYEES_TABLE." WHERE CONCAT(FirstName, LastName) LIKE ? AND Status = ? ORDER BY ID DESC LIMIT $start, $division";
            $prepared_statement = $this->dbh_object->prepare($sql);
            $prepared_statement->execute(["%$name_search%", $status]);

            return $prepared_statement->fetchAll();

        }

        public function add_employee(
            string $first_name, 
            string $last_name, 
            string $gender, 
            string $username, 
            string $password
        ) : array {

            $sql = "INSERT INTO ".self::EMPLOYEES_TABLE."(FirstName, LastName, Gender, Username, Password) VALUES(?, ?, ?, ?, ?)";
            $prepared_statement = $this->dbh_object->prepare($sql);
            
            return ($prepared_statement->execute(func_get_args())) ? [true, $this->dbh_object->lastInsertId()] : [false];

        }

        public function update_employee_status(int $employee_id, int $status) : bool {

            $sql = "UPDATE ".self::EMPLOYEES_TABLE." SET Status = ? WHERE ID = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            
            return $prepared_statement->execute([$status, $employee_id]);

        }

        public function update_employee_info(
            string $first_name,
            string $last_name,
            string $gender,
            string $address,
            string $town_or_city,
            string $email_address,
            string $telephone_number,
            string $national_insurance,
            string $sia_license,
            string $pin,
            string $immigration_status,
            string $bank_sort_code,
            string $account_number,
            string $account_name,
            int $employee_id
        ) : bool{

            $sql = "UPDATE ".self::EMPLOYEES_TABLE." SET FirstName = ?, LastName = ?, Gender = ?, Address = ?, TownOrCity = ?, EmailAddress = ?, TelephoneNumber = ?, NationalInsurance = ?, SIALicense = ?, PIN = ?, ImmigrationStatus = ?, BankSortCode = ?, AccountNumber = ?, AccountName = ? WHERE ID = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);

            return $prepared_statement->execute(func_get_args());

        }

        public function update_employee_datum(
            int $employee_id,
            string $datum_key,
            string $new_value
        ) : bool {

            $sql = "UPDATE ".self::EMPLOYEES_TABLE." SET $datum_key = ? WHERE ID = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            
            return $prepared_statement->execute([$new_value, $employee_id]);

        }

    }

?>