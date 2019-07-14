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

    public function getUserData($data) {
        $sql = "";
        switch ($data) {
            case "comments":
                $sql = "select count(comment_id) as result from comments where comment_author='{$this->user['user_name']}'";
                break;
            case "reviews":
                $sql = "select count(review_id) as result from reviews where review_author='{$this->user['user_name']}'";
                break;
            case "votes":
                $sql = "select count(vote_id) as result from votes where vote_by='{$this->user['user_name']}'";
                break;
            case "warnings":
                $sql = "select count(warn_id) as result from warnings where warn_to='{$this->user['user_name']}'";
                break;
            default:
                return 0;
        }
        $result = mysqli_query($this->con, $sql);
        $this->confirmQuery($result);
        $row = mysqli_fetch_array($result);
        return $row['result'];
    }

    public function confirmQuery($query) {
        if (!$query) {
            die("QUERY FAILED" . " " . mysqli_error($this->con));
        }
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
