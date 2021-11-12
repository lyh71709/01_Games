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
$developer="";
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
    // if GenreID, is not blank, get genre so that genre box does not lose its value if there are errors
    if ($genre_ID != "") {
        $genreitem_sql="";
        $genreitem_query=mysqli_query($db_connect, $genreitem_sql);
        $genreitem_rs=mysqli_fetch_assoc($genreitem_query);

        $genre = $genreitem_rs['Genre'];

    } // End genreID if

    $developer = mysqli_real_escape_string($db_connect, $_POST['dev_name']);
    $age = mysqli_real_escape_string($db_connect, $_POST['age']);
    $rating = mysqli_real_escape_string($db_connect, $_POST['rating']);
    $rate_count = mysqli_real_escape_string($db_connect, $_POST['count']);
    $cost = mysqli_real_escape_string($db_connect, $_POST['price']);
    $in_app = mysqli_real_escape_string($db_connect, $_POST['in_app']);
    $description = mysqli_real_escape_string($db_connect, $_POST['description']);

    // error checking will go here...
    
    // if there are no errors
    if ($has_errors=="no") {

    // Go to success page...
    header('Location: add_success.php');
    
    // get developer ID if it exists...
    $dev_sql = "SELECT * FROM `developer` WHERE `Developer` LIKE '$developer'";
    $dev_query=mysqli_query($db_connect, $dev_sql);
    $dev_rs=mysqli_fetch_assoc($dev_query);
    $dev_count=mysqli_num_rows($dev_query);

    // if developer not already in developer table, add them and get the 'new' developerID
    if ($dev_count>0) {
        $developerID = $dev_rs['DeveloperID'];
    }

    else{
        $add_dev_sql="INSERT INTO `developer` (`DeveloperID`, `Developer`) VALUES (NULL, '$developer');";
        $add_dev_query=mysqli_query($db_connect, $add_dev_sql);

        // Get developer ID
        $newdev_sql="SELECT * FROM `developer` WHERE `Developer` LIKE '$developer'";
        $newdev_query=mysqli_query($db_connect, $newdev_sql);
        $newdev_rs=mysqli_fetch_assoc($newdev_query);

        $developerID= $newdev_rs['DeveloperID'];

    } // end adding developer to developer table

    // Add entry to database
    $addentry_sql="INSERT INTO `game_details` (`ID`, `Name`, `Subtitle`, `URL`, `GenreID`, `DeveloperID`, `Age`,
    `User Rating`, `Rating Count`, `Price`, `In App`, `Description`) VALUES (NULL, '$app_name', '$subtitle', '$url', 
    $genreID, $developerID, $age, $rating, $rate_count, $cost, $in_app, '$description');";
    $addentry_query=mysqli_query($db_connect, $addentry_sql);

    } // end of 'no errors' if

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
            <!-- first / selected option -->
            <?php 
            if ($genreID=="") {
                ?>
                <option value="" selected>Genre (Choose something)....</option>
                <?php
            }
            else{
                ?>
            <option value="<?php echo $genreID?>" selected></option>
            <?php
            }
            ?>
            <!-- get options from database -->
            <?php

            do {
                    ?>
                <option value="<?php echo $genre_rs['GenreID']; ?>"><?php echo $genre_rs['Genre']; ?></option>

                    <?php

                } // end genre do loop

                while ($genre_rs=mysqli_fetch_assoc($genre_query))
            ?>
            </select>

            <!-- Developer Name (required) -->
            <input class="add-field <?php echo $dev_field?>" type="text" name="developer" value="<?php echo $developer; ?>" size="40" placeholder="Developer Name (required)..."/>

            <!-- Age (set to 0 if left blank) -->
            <input class="add-field" type="text" name="age" value="<?php echo $age; ?>" placeholder="Age (0 for all)"/>

            <!-- Rating (Number between 0 -5, 1dp) -->
            <div>
                <input class="add-field" type="number" name="rating" size="40" value="<?php echo $rating; ?>" step="0.1" min=0 max=5 placeholder="Rating (0-5)"/>

            </div>

            <!-- # of ratings (integer more than 0) -->
            <input class="add-field" type="text" name="count" value="<?php echo $rate_count; ?>" placeholder="# of Ratings"/>

            <!-- Cost (Decimal 2dp, must be mroe than 0) -->
            <input class="add-field" type="text" name="price" value="<?php echo $cost; ?>" placeholder="Cost (number only)"/>
            
            <br /><br />
            <!-- In App Purchase checkbox -->
            <div>
                <b>In App Purchase</b>
                <!-- defaults to 'yes' -->
                <!-- NOTE: value in database is boolean, so 'no' becomes 0 and 'yes' becomes 1 -->

                <?php
                if($in_app==1) {
                //Default value, 'Yes' is selected
                    ?>
                <input type="radio" name="in_app" value="1" checked="checked" />Yes
                <input type="radio" name="in_app" value="0" />No
                    <?php
                } // end 'yes in_app' if

                else{
                    ?>
                <input type="radio" name="in_app" value="1" />Yes
                <input type="radio" name="in_app" value="0" checked="checked" />No
                <?php
                } // end 'in_app' else
                ?>
                
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