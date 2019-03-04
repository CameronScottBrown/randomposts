<?php

    class Post {
        private $db;

        public function __construct(){
            $this->db = new Database; //new instance of our PDO Database class
        }

        //get all posts
        public function getPosts(){
            $this->db->query('SELECT *, 
                              posts.id as postId, 
                              users.id as userId, 
                              posts.created_at
                              FROM posts
                              INNER JOIN users 
                              ON posts.user_id = users.id
                              ORDER BY posts.created_at DESC');

            $results = $this->db->resultSet(); //our custom use of fetchAll()

            return $results;
        }

        //add post with input data
        public function addPost($data){
            $this->db->query('INSERT INTO posts (`user_id`, `title`, `body`) VALUES (:user_id, :title, :body)');

            //bind values to named params
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']); 

            //execute query
            if($this->db->execute()){
                return true;
            } else {
                //something went wrong
                return false;
            }
            
        }

        //get post by id
        public function getPostById($id){
            $this->db->query('SELECT * FROM posts WHERE id = :id');

            //bind value
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        //update post
        public function updatePost($data){
            $this->db->query('UPDATE posts SET 
                              title = :title, 
                              body = :body 
                              WHERE id = :id');

            //bind values to named params
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':id', $data['id']); 

            //execute query
            if($this->db->execute()){
                return true;
            } else {
                //something went wrong
                return false;
            }
            
        }

        //delete post
        public function deletePost($id){
            $this->db->query('DELETE FROM posts 
                              WHERE id = :id');

            //bind value to named param
            $this->db->bind(':id', $id); 

            //execute query
            if($this->db->execute()){
                return true;
            } else {
                //something went wrong
                return false;
            }
            
        }



    }

?>