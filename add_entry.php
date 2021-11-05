<?php include("topbit.php");

// Get Genre lsit from database
$genre_sql="SELECT * FROM `genre` ORDER BY `genre`.`Genre` ASC ";
$genre_query=mysqli_query($db_connect, $genre_sql);
$genre_rs=mysqli_fetch_assoc($genre_query);


// Initialise form variables

$app_name = "";
$subtitle = "";
$url = "";
$genreID="";
$dev_name;
$age = "";
$rating = "";
$rate_count = "";
$cost = "";
$in_app = 1;
$description = "";
$has_errors = "no";

// Code below executes when the form is submitted...
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get values from form...
    $app_name = mysqli_real_escape_string($db_connect, $_POST['app_name']);
    $subtitle = mysqli_real_escape_string($db_connect, $_POST['subtitle']);
    $url = mysqli_real_escape_string($db_connect, $_POST['url']);
    $genreID = mysqli_real_escape_string($db_connect, $_POST['genre']);
    $dev_name = mysqli_real_escape_string($db_connect, $_POST['dev_name']);
    $age = mysqli_real_escape_string($db_connect, $_POST['age']);
    $rating = mysqli_real_escape_string($db_connect, $_POST['rating']);
    $rate_count = mysqli_real_escape_string($db_connect, $_POST['count']);
    $cost = mysqli_real_escape_string($db_connect, $_POST['price']);
    $in_app = mysqli_real_escape_string($db_connect, $_POST['in_app']);
    $description = mysqli_real_escape_string($db_connect, $_POST['description']);
    

    echo "You pushed the button";
}   // end of the button submitted code

?>
            
        <div class="box main">
            <div class="add-entry">
            <h2>Add An Entry</h2>

            <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <!-- App Name (required) -->
            <input class="add-field" type="text" name="app_name" value="<?php echo $app_name; ?>" placeholder="App Name (required) ..."/>

            <!-- Subtitle (optiona) -->
            <input class="add-field" type="text" name="subtitle" size="40" value="<?php echo $subtitle; ?>" placeholder="Subtitle (optional)..."/>

            <!-- URL (required, must start hhtp://) -->
            <input class="add-field <?php echo $url_field; ?>" type="text" name="url" size="40" value="<?php echo $url; ?>" placeholder="URL (required)"/>

            <!-- Genre Dropdown (required) -->
            <select class="adv" name="genre">
            <option value="" selected>Genre (Choose something)....</option>
            do {
                    ?>
                <option value="<?php echo $genre_rs['GenreID']; ?>"><?php echo $genre_rs['Genre']; ?></option>

                    <?php

                } // end genre do loop

                while ($genre_rs=mysqli_fetch_assoc($genre_query))
            ?>
            </select>

            <!-- Developer Name (required) -->
            <input class="add-field <?php echo $dev_field?>" type="text" name="dev_name" value="<?php echo $dev_name; ?>" size="40" placeholder="Developer Name (required)..."/>

            <!-- Age (set to 0 if left blank) -->
            <input class="add-field" type="text" name="age" value="<?php echo $age; ?>" placeholder="Age (0 for all)"/>

            <!-- Rating (Number between 0 -5, 1dp) -->
            <div>
                <input class="add-field" type="number" name="rating" value="<?php echo $rating; ?>" step="0.1" min=0 max=5 placeholder="Rating (0-5)"/>

            </div>

            <!-- # of ratings (integer more than 0) -->
            <input class="add-field" type="text" name="count" value="<?php echo $rate_count; ?>" placeholder="# of Ratings"/>

            <!-- Cost (Decimal 2dp, must be mroe than 0) -->
            <input class="add-field" type="text" name="price" value="<?php echo $cost; ?>" placeholder="Cost (number only)"/>
            
            <br /><br />
            <!-- In App Purchase radio buttons -->
            <div>
                <b>In App Purchase</b>
                <!-- defaults to 'yes' -->
                <!-- NOTE: value in database is boolean, so 'no' becomes 0 and 'yes' becomes 1 -->

                <input type="radio" name="in_app" value="1" checked="checked" />Yes
                <input type="radio" name="in_app" value="0" />No
            </div>

            <br />
            <!-- Description text area -->
            <textarea class="add-field <?php echo $description_field ?>" name="description" placeholder="Description..." rows="6"><?php echo $description; ?></textarea>

            <!-- Submit Button -->
            <input class="submit advanced-button" type="submit" value="Submit" />

            

            </form>

            </div> <!-- / add entry -->
        </div> <!-- / main -->
        
<?php include("bottombit.php") ?>