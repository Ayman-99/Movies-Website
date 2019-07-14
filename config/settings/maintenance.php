<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Under Maintenance</title>       
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">
        <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
        <style type="text/css">
            html, body {
                height: 100%;
            }
            body {
                background-color: #fff;
                background: radial-gradient(circle at center, #fff 0%, #f8f8f8 75%, #ebebeb 100%);
                color: #222;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                font-size: 1rem;
                line-height: 1.5;
                margin: 0;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            main {
                padding: 1rem;
                text-align: center;
            }
            h1 {
                font-size: 2.5rem;
                line-height: 1.1;
                margin: 0;
            }
            @media screen and (max-width: 480px) {
                h1 {
                    font-size: 1.5rem;
                }
            }
            h1::after {
                content: "";
                background-color: #ffe800;
                background: repeating-linear-gradient(45deg, #ffe800, #ffe800 0.5rem, #222 0.5rem, #222 1.0rem);
                display: block;
                height: 0.5rem;
                margin-top: 1rem;
            }
            p {
                margin: 1rem 0 0 0;
            }
        </style>
    </head>
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5c8132e1101df77a8be167ff/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <body>
        <main>
            <h1>YourMovies</h1>
            <p>Our website is currently under maintenance.</p>
            <p id="demo" style="font-size:30px; color: black;"></p>
            <p>- Project Staff</p>
        </main>
        <script>
            // Set the date we're counting down to
            var countDownDate = new Date("<?php echo $time; ?>").getTime();

            // Update the count down every 1 second
            var countdownfunction = setInterval(function () {

                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now an the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                        + minutes + "m " + seconds + "s ";

                // If the count down is over, write some text 
                if (distance < 0) {
                    clearInterval(countdownfunction);
                    $.ajax({
                        url: 'includes/handlers/handler.php', //page
                        data: {offIt: "yes"}, //what data 
                        type: 'POST', //post method
                        success: function (data) {
                            if (!data.error) {
                                alert("You can login now!");
                                window.location.href = "index.php";
                            }
                        }
                    });

                }
            }, 1000);
        </script>
    </body>
</html>
