<?php
    class User {
        private $db;

        public function __construct(){
            $this->db = new Database; //new instance of our PDO Database class
        }

        //register user with input data
        public function register($data){
            $this->db->query('INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :password)');

            //bind values to named params
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']); //store password hashed

            //execute query
            if($this->db->execute()){
                return true;
            } else {
                //something went wrong
                return false;
            }
            
        }

        //login user
        public function login($email, $password){
            $this->db->query('SELECT * from users WHERE email = :email');
            $this->db->bind(':email', $email);

            //fetch user instance
            $row = $this->db->single();

            //get selected user password
            $hashed_password = $row->password;

            //verify password
            if(password_verify($password, $hashed_password)){
                return $row;
            } else{
                //wrong password
                return false;
            }
        }


        //find user by email
        public function findUserByEmail($email){
            $this->db->query('SELECT * FROM users WHERE email = :email');

            //bind value to named param
            $this->db->bind(':email', $email);

            //return single row that matches
            $row = $this->db->single();

            //check for existing email (does the row exist)
            if($this->db->rowCount() > 0){
                return true;
            } else {
                return false;
            }
        }

         //get user by id
         public function getUserById($id){
            $this->db->query('SELECT * FROM users WHERE id = :id');

            //bind value
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        

    }

?>