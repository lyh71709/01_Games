<?php include("topbit.php");

    $app_name = mysqli_real_escape_string($dbconnect, $_POST['app_name']);

    $find_sql = "SELECT * FROM `game_details` 
    JOIN genre ON (game_details.GenreID = genre.GenreID)
    JOIN developer ON (game_details.DeveloperID = developer.DeveloperID)
    WHERE `Name` LIKE '%chess%'
    ";
    $find_query = mysqli_query($db_connect, $find_sql);
    $find_rs = mysqli_fetch_assoc($find_query);
    $count = mysqli_num_rows($find_query);

?>
            
    <div class="box main">
            <h2>All Results</h2>
        
            <?php
                include("results.php")
            ?>


    </div> <!-- / main -->
        
<?php include("bottombit.php") ?>
            