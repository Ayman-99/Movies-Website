<?php

class Movie {

    public $movie;
    public $con;

    public function __construct($con, $movie) {
        $this->con = $con;
        $movie_details = mysqli_query($con, "SELECT * FROM movies inner join categories on movies.movie_category_id=categories.category_id"
                . " WHERE movie_id='$movie'");
        $this->movie = mysqli_fetch_array($movie_details);
    }

    public function getMovieId() {
        return $this->movie['movie_id'];
    }

    public function getMovieName() {
        return $this->movie['movie_Name'];
    }

    public function getMovieURL() {
        return $this->movie['movie_URL'];
    }

    // 264 x 396
    public function getMoveiImage() {
        return $this->movie['movie_image'];
    }

    public function getMovieDirector() {
        return $this->movie['movie_director'];
    }

    public function getMovieLength() {
        return $this->movie['movie_length'];
    }

    public function getReleaseDate() {
        return $this->movie['movie_release_date'];
    }

    public function getMovieLanguage() {
        return $this->movie['movie_language'];
    }

    public function getMovieDesc() {
        return $this->movie['movie_description'];
    }

    public function getCategoryName() {
        return $this->movie['category_name'];
    }

    public function getRating() {
        $result = mysqli_query($this->con, "SELECT round(avg(vote_hit),1) as rating from votes where vote_on='{$this->movie['movie_id']}'");
        confirmQuery($result);
        $row = mysqli_fetch_array($result);
        return $row['rating'];
    }

    public function updateViews() {
        mysqli_query($this->con, "update movies set movie_views = movie_views + 1 where movie_id={$this->movie['movie_id']}");
    }

    public function confirmQuery($query) {
        if (!$query) {
            die("QUERY FAILED" . " " . mysqli_error($this->con));
        }
    }

}
