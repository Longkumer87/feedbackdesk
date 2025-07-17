<?php require 'classes/Database.php';

$db = new Database();
$conn = $db->getDb();

$username = $email = $phone = $password = $cpassword = '';
$errors = [];

if ($conn instanceof PDO) {

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = htmlspecialchars(strtoupper($_POST['username']));
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $password = htmlspecialchars($_POST['password']);
        $cpassword = htmlspecialchars($_POST['cpassword']);
        $submit = $_POST['submit'];
        $check = $_POST['check'] ?? null;

        if (isset($submit)) {
            if (empty($username)) {
                $errors[] = "User name required";
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format";
            }
            if (empty($phone)) {
                $errors[] = "Phone Number needed";
            }
            if (strlen($password) < 6) {
                $errors[] = "Password should me more than 6 character";
            }
            if (empty($cpassword) || $cpassword !== $password) {
                $errors[] = "Password does not match";
            }
            if (!isset($check)) {
                $errors[] = "You must agree to the terms and conditions";
            }

            //checking user email

            if (empty($errors)) {
                $sql = "SELECT * 
                       FROM `users`
                       WHERE `email`=:email";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $userEmail = $stmt->fetch(PDO::FETCH_ASSOC);
                    if($userEmail){
                        $errors[] = "Email already exist";
                    }else{
                        $errors[] = "404 Please try after sometime";
                    }
                }
            }
        //register if no email exist

        }
    }
} else {
    echo "Connection fail";
}


?>

<?php
$titles = 'signup';
require 'includes/header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center"> Sign Up </h2>
</div>

<div class="container text-danger">
    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $err): ?>
            <ul>
                <li><?= $err; ?></li>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="container mt-4">
    <form method="post">
        <div class="mb-3">
            <label for="username" class="form-label">User Name</label>
            <input type="test" class="form-control" id="username" name="username" value="<?= htmlspecialchars($username); ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="phone" class="form-control" id="phone" name="phone">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="cpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="cpassword" name="cpassword">
        </div>

        <div class="mb-3 form-check">
            <label class="form-check-label" for="check"> I agree to the terms and conditions</label>
            <input type="checkbox" class="form-check-input" id="check" name="check">
        </div>

        <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
    </form>
</div>


<?php require 'includes/script.php'; ?>
<?php require 'includes/footer.php' ?>