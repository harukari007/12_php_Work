<?php

session_start();
include('functions.php');
check_session_id();


// include 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT height, weight, gender, age FROM user_info JOIN users ON user_info.user_id = users.id WHERE users.email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($height, $weight, $gender, $age);
    $stmt->fetch();
    $stmt->close();

    if ($gender == "male") {
        $bmr = 10 * $weight + 6.25 * $height - 5 * $age + 5;
    } else {
        $bmr = 10 * $weight + 6.25 * $height - 5 * $age - 161;
    }

    echo json_encode(array("bmr" => $bmr));
}
?>

<!DOCTYPE html>

<head>
    <title>Calculate BMR</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h2>Calculate BMR</h2>
    <form id="bmrForm">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <input type="submit" value="Calculate BMR">
    </form>
    <div id="result"></div>

    <script>
        $("#bmrForm").on("submit", function(event) {
            event.preventDefault();
            $.post("calculate_bmr.php", $(this).serialize(), function(data) {
                const result = JSON.parse(data);
                $("#result").text("Your BMR is " + result.bmr);
            });
        });
    </script>
</body>

</html>