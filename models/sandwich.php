<?php

class Sandwich extends Db {

    function infinite_sandwiches( ) {

        $user_id = $_SESSION['user_logged_in'];

        $start = $this->data['start'];
        $limit = $this->data['limit'];
        $sandwiches['reachedMax'] = false;
        $sandwiches['sandwiches'] = array();

        $sql = "SELECT
        sandwiches.*, users.username, loves.id AS love_id,
        (SELECT COUNT(loves.id) FROM loves WHERE loves.sandwich_id = sandwiches.id) AS love_count
        FROM sandwiches
        LEFT JOIN users
        ON sandwiches.user_id = users.id
        LEFT JOIN loves
        ON sandwiches.id = loves.sandwich_id
        AND loves.user_id = '$user_id' LIMIT $start, $limit
        ";


        $sandwiches['sandwiches'] = $this->select($sql);

        if( !empty($sandwiches['sandwiches']) ){

            foreach( $sandwiches['sandwiches'] as $key => $sandwich ){

                $sandwich_id = $sandwich['id'];

                $sql = "SELECT * FROM ingredients WHERE sandwich_id = '$sandwich_id' ";
                $ingredients = $this->select($sql);

                $sandwiches['sandwiches'][$key]['ingredients'] = $ingredients;

            }

        }else{
            $sandwiches['reachedMax'] = true;
        }


        return $sandwiches;


    }


    function add(){

        $name = $this->data['name'];
        $bread_type = $this->data['bread_type'];
        $ingredients = $this->data['ingredients'];
        $instructions = $this->data['instructions'];
        $user_id = (int)$_SESSION['user_logged_in'];
        $util = new Util;
        $file_upload = $util->file_upload();
        $filename = $file_upload['filename'];
        $current_time = time();

        if( $file_upload['file_upload_error_status'] === 0 ){ // File upload was successful
            $sql = "INSERT INTO sandwiches (user_id, name, bread_type, filename, instructions, posted_time) VALUES ('$user_id', '$name', '$bread_type', '$filename', '$instructions', '$current_time')";

            $sandwich_id = $this->execute_return_id($sql);

            $ingredients_values = '';

            if( !empty($ingredients) ){
                foreach ($ingredients as $ingredient) {
                    if( !empty($ingredient)){
                        $ingredients_values .= "('$ingredient', '$sandwich_id'),";
                    }
                }
                $ingredients_values = rtrim($ingredients_values,',');
                $sql = "INSERT INTO ingredients (name, sandwich_id) VALUES $ingredients_values";

                $this->execute($sql);

            }
        }

    }

    function get_all(){

        $user_id = (int)$_SESSION['user_logged_in'];

        if( !empty($_GET['search']) ){ // They're searching something

            $search = $this->params['search'];

            $sql = "SELECT
            sandwiches.*, users.username, loves.id AS love_id,
            (SELECT COUNT(loves.id) FROM loves WHERE loves.sandwich_id = sandwiches.id) AS love_count
            FROM sandwiches
            LEFT JOIN users
            ON sandwiches.user_id = users.id
            LEFT JOIN loves
            ON sandwiches.id = loves.sandwich_id
            AND loves.user_id = '$user_id'
            WHERE sandwiches.title
            LIKE '%$search%' OR sandwiches.description OR CONCAT(users.username) LIKE '%$search%'
            DESC";

        }else{ // They're not searching
            $sql = "SELECT
            sandwiches.*, users.username, loves.id AS love_id,
            (SELECT COUNT(loves.id) FROM loves WHERE loves.sandwich_id = sandwiches.id) AS love_count
            FROM sandwiches
            LEFT JOIN users
            ON sandwiches.user_id = users.id
            LEFT JOIN loves
            ON sandwiches.id = loves.sandwich_id
            AND loves.user_id = '$user_id' LIMIT 3
            ";
        }

        $sandwiches = $this->select($sql);

        if( !empty($sandwiches) ){

            foreach( $sandwiches as $key => $sandwich ){

                $sandwich_id = $sandwich['id'];

                $sql = "SELECT * FROM ingredients WHERE sandwich_id = '$sandwich_id'";
                $ingredients = $this->select($sql);

                $sandwiches[$key]['ingredients'] = $ingredients;

            }

        }





        return $sandwiches;

    }

    function get_by_id($id){

        $id = (int)$id;

        $sql = "SELECT * FROM sandwiches WHERE id = '$id'";

        $sandwich = $this->select($sql)[0];

        if( !empty($sandwich) ){

                $sandwich_id = $sandwich['id'];

                $sql = "SELECT * FROM ingredients WHERE sandwich_id = '$sandwich_id'";
                $ingredients = $this->select($sql);

                $sandwich['ingredients'] = $ingredients;



        }

        return $sandwich;

    }

    function get_by_user_id(){


                $user_id = (int)$_SESSION['user_logged_in'];


                $sql = "SELECT
                sandwiches.*, users.username, loves.id AS love_id,
                (SELECT COUNT(loves.id) FROM loves WHERE loves.sandwich_id = sandwiches.id) AS love_count
                FROM sandwiches
                LEFT JOIN users
                ON sandwiches.user_id = users.id
                LEFT JOIN loves
                ON sandwiches.id = loves.sandwich_id
                AND loves.user_id = '$user_id' WHERE sandwiches.user_id = '$user_id' LIMIT 3
                ";


                $sandwiches = $this->select($sql);

                if( !empty($sandwiches) ){

                    foreach( $sandwiches as $key => $sandwich ){

                        $sandwich_id = $sandwich['id'];

                        $sql = "SELECT * FROM ingredients WHERE sandwich_id = '$sandwich_id'";
                        $ingredients = $this->select($sql);

                        $sandwiches[$key]['ingredients'] = $ingredients;

                    }

                }





                return $sandwiches;

    }

    function edit($id){

        $id = (int)$id;
        $this->check_ownership($id); // Make sure user owns post that's being editted

        $name = $this->data['name'];
        $instructions = $this->data['instructions'];
        $bread_type = $this->data['bread_type'];
        $current_user_id = (int)$_SESSION['user_logged_in'];

        if( !empty($_FILES['fileToUpload']['name']) ) { // Check if new file submitted

            $util = new Util;
            $file_upload = $util->file_upload(); // Upload new file
            $filename = $file_upload['filename'];

            if( $file_upload['file_upload_error_status'] === 0 ){ // File upload was successful

                // Get old filename from db first
                $old_project_image = trim($this->get_by_id($id)['filename']);

                // Save filename to DB
                $sql = "UPDATE sandwiches SET name='$name', instructions='$instructions', bread_type='$bread_type', filename='$filename' WHERE id='$id' AND user_id='$current_user_id'";

                $this->execute($sql);

                // Delete the old project image file
                if( !empty($old_project_image) ){
                    if( file_exists(APP_ROOT.'/views/assets/files/'.$old_project_image )){
                        unlink( APP_ROOT.'/views/assets/files/'.$old_project_image );
                    }
                }

            }

        }else{ // if no new file was submitted

            $sql = "UPDATE sandwiches SET name='$name', instructions='$instructions', bread_type='$bread_type' WHERE id='$id' AND user_id='$current_user_id'";

            $this->execute($sql);

        }

    }

    function check_ownership($id){

        $id = (int)$id;

        $sql = "SELECT * FROM sandwiches WHERE id = '$id'";

        $sandwich = $this->select($sql)[0];

        if( $sandwich['user_id'] == $_SESSION['user_logged_in'] ){
            return true;
        }else{
            header("Location: /");
            exit();
        }

    }

    function delete(){

        $current_user_id = (int)$_SESSION['user_logged_in'];
        $id = (int)$_POST['sandwich_id'];
        $this->check_ownership($id);

        // Delete the old project image file
        $sandwich_image = trim($this->get_by_id($id)['filename']);
        if( !empty($sandwich_image) ){
            if( file_exists(APP_ROOT.'/views/graphics/'.$sandwich_image )){
                unlink( APP_ROOT.'/views/graphics/'.$sandwich_image );
            }
        }

        $sql = "DELETE FROM sandwiches WHERE id='$id' AND user_id='$current_user_id'";
        $this->execute($sql);

    }

    function search(){

        $search = $this->data['search'];

        if( !empty($_SESSION['user_logged_in']) ){

            $user_id = $_SESSION['user_logged_in'];

            $sql = "SELECT
            sandwiches.*, users.username,
            IF(sandwiches.user_id = '$user_id', 'true', 'false') AS user_owns
            FROM sandwiches
            LEFT JOIN users
            ON sandwiches.user_id = users.id
            WHERE sandwiches.name LIKE '%$search%'
            ";
        }else{
            $sql = "SELECT
            sandwiches.*, users.username,
            'not_logged_in' AS user_owns
            FROM sandwiches
            LEFT JOIN users
            ON sandwiches.user_id = users.id
            WHERE sandwiches.name LIKE '%$search%'
            ";
        }

        $sandwiches = $this->select($sql);

        if( !empty($sandwiches) ){

            foreach( $sandwiches as $key => $sandwich ){

                $sandwich_id = $sandwich['id'];

                $sql = "SELECT * FROM ingredients WHERE sandwich_id = '$sandwich_id'";
                $ingredients = $this->select($sql);

                $sandwiches[$key]['ingredients'] = $ingredients;

            }

        }

        return $sandwiches;


    }


}
