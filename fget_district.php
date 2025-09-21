<?php
require_once("../sql.php");

if(!empty($_POST["state_id"])) {
    $state_id = mysqli_real_escape_string($conn, $_POST["state_id"]);

    $query = mysqli_query($conn, "SELECT DistrictName FROM district WHERE StCode = '$state_id' ORDER BY DistrictName");

    if ($query && mysqli_num_rows($query) > 0) {
        echo '<option value="">Select District</option>';
        while ($row = mysqli_fetch_assoc($query)) {
            echo '<option value="'.htmlspecialchars($row["DistrictName"]).'">'.htmlspecialchars($row["DistrictName"]).'</option>';
        }
    } else {
        echo '<option>No districts found</option>';
    }
}
?>
