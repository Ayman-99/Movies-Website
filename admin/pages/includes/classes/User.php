<?php

class Person {

    public $user;
    public $con;

    public function __construct($con, $user) {
        $this->con = $con;
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE user_name='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
    }

    public function getUserId() {
        return $this->user['user_id'];
    }

    public function getUserName() {
        return $this->user['user_name'];
    }

    public function getFName() {
        return $this->user['user_FName'];
    }

    public function getLName() {
        return $this->user['user_LName'];
    }

    public function getFulLName() {
        return $this->user['user_FName'] . " " . $this->user['user_LName'];
    }

    public function getEmail() {
        return $this->user['user_email'];
    }

    public function getUserType() {
        return $this->user['user_type'];
    }

    public function getUserStatus() {
        return $this->user['user_status'];
    }

    public function getUserOnline() {
        return $this->user['user_online'];
    }

    public function getUserPic() {
        return $this->user['user_pic'];
    }

    public function confirmQuery($query) {
        if (!$query) {
            die("QUERY FAILED" . " " . mysqli_error($this->con));
        }
    }
    public function getNumOfWarnings() {
        $sql = "select warn_id from warnings where warn_to='{$this->getUserName()}'";
        $count = mysqli_num_rows(mysqli_query($this->con, $sql));
        return $count;
    }
}

class Moderator extends Person {

    public function getUserInsertedMovies() {
        $sql = "select movie_id from movies where movie_added_by='{$this->getUserName()}'";
        $count = mysqli_num_rows(mysqli_query($this->con, $sql));
        return $count;
    }

    public function getNumberOfIssuedWarning() {
        $sql = "select warn_id from warnings where warn_by='{$this->getUserName()}'";
        $count = mysqli_num_rows(mysqli_query($this->con, $sql));
        return $count;
    }

}

?>
