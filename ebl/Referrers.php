<?php

    require_once dirname(__FILE__)."/config/Dbh.config.php";

    class Referrers extends Dbh{

        const REFERRERS_TABLE = "employees_reference";

        public function __construct(){

            $this->dbh_object = $this->GetConnection();

        }

        public function get_referrer(int $ref_id) : array {

            $sql = "SELECT * FROM ".self::REFERRERS_TABLE." WHERE ID = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            $prepared_statement->execute([$ref_id]);

            return ($prepared_statement->rowCount() == 1) ? [true, $prepared_statement->fetchAll()[0]] : [false];

        }

        public function referrer_exists(int $employee_id, string $unique_key, string $value) : bool {

            $sql = "SELECT COUNT(ID) FROM ".self::REFERRERS_TABLE." WHERE $unique_key = ? AND Employee = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            $prepared_statement->execute([$value, $employee_id]);
            
            return ($prepared_statement->fetchColumn() == 1);

        }

        public function get_num_referrers(int $employee_id) : int {

            $sql = "SELECT COUNT(ID) FROM ".self::REFERRERS_TABLE." WHERE Employee = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            $prepared_statement->execute([$employee_id]);

            return $prepared_statement->fetchColumn();

        }  

        public function get_referrers(int $employee_id) : array {

            $sql = "SELECT * FROM ".self::REFERRERS_TABLE." WHERE Employee = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);
            $prepared_statement->execute([$employee_id]);

            return $prepared_statement->fetchAll();

        }   

        public function add_referrer(
            int $employee_id,
            string $first_name,
            string $last_name,
            string $telephone_number,
            string $email_address
        ) : bool {

            $sql = "INSERT INTO ".self::REFERRERS_TABLE."(Employee, FirstName, LastName, TelephoneNumber, EmailAddress) VALUES(?, ?, ?, ?, ?)";
            $prepared_statement = $this->dbh_object->prepare($sql);

            return $prepared_statement->execute(func_get_args());

        }

        public function delete_referrer(int $employee_id, int $id) : bool {

            $sql = "DELETE FROM ".self::REFERRERS_TABLE." WHERE ID = ? AND Employee = ?";
            $prepared_statement = $this->dbh_object->prepare($sql);

            return $prepared_statement->execute([$id, $employee_id]);

        }

    }

?>