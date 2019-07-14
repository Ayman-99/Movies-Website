<?php
include './includes/head.php';
echo "<div style='background: #333; color: #fff;' class='text-center'>This website is just beta version visit >> <a href='https://github.com/Ayman-Hunjul/Movies-Website' target='_blank'><h5 style='display:inline;'><b>YourMovies (Source code)</b></h5></a></div>"
?>
<body>
    <!-- begin Header -->
    <?php include './includes/header.php'; ?>
    <!-- end Header -->
    <!-- begin Content -->
    <section>

        <?php include './includes/home-content/slider.php'; ?>

        <?php include './includes/home-content/movies.php'; ?>

        <?php include './includes/home-content/widgets.php'; ?>

        <?php include './includes/home-content/pricing.php'; ?>

    </section>

    <?php include './includes/footer.php'; ?>
    <script>
<?php
if (!isset($_SESSION['showBetaAlert'])) {
    ?>
            alert("This website is just beta version \n View >> https://github.com/Ayman-Hunjul/Movies-Website");
    <?php
}
$_SESSION['showBetaAlert'] = 1;
?>
    </script>
    
    
    
