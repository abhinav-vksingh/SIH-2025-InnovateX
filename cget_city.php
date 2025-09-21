<?php
require_once("../sql.php");

if (!empty($_POST["district_id"])) {
    echo "DEBUG: Received district_id = " . $_POST["district_id"] . "<br>";

    $query = mysqli_query($conn, "SELECT * FROM city WHERE DistrictCode = '" . $_POST["district_id"] . "'");

    if (!$query) {
        echo "SQL Error: " . mysqli_error($conn);
        exit;
    }

    if (mysqli_num_rows($query) == 0) {
        echo "<option>No cities found</option>";
    } else {
        echo '<option value="">Select City</option>';
        while ($row = mysqli_fetch_array($query)) {
            echo '<option value="'.$row["CityName"].'">'.$row["CityName"].'</option>';
        }
    }
}
?>
