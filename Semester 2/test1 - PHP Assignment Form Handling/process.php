<?php

// Initialize variables to store form data and errors
$name = $email = $password = $confirmPassword = "";
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$successMessage = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate Name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    // Validate Email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = htmlspecialchars($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate Password
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = htmlspecialchars($_POST["password"]);
    }

    // Validate Confirm Password
    if (empty($_POST["confirmPassword"])) {
        $confirmPasswordErr = "Confirm Password is required";
    } else {
        $confirmPassword = htmlspecialchars($_POST["confirmPassword"]);
        if ($password !== $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    // If there are no errors, display success message
    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
        $successMessage = "Registration successful! <br> Name: " . $name . "<br> Email: " . $email;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-lg">
        <?php if (!empty($successMessage)) : ?>
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($nameErr) || !empty($emailErr) || !empty($passwordErr) || !empty($confirmPasswordErr)) : ?>
            <h2 class="text-2xl font-bold text-center text-red-700">Error!</h2>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-600" for="name">Full Name</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="John Doe" value="<?php echo $name; ?>">
                <span class="text-red-500"><?php echo $nameErr; ?></span>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600" for="email">Email</label>
                <input type="email" class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="john@example.com" id="email" name="email" value="<?php echo $email; ?>">
                <span class="text-red-500"><?php echo $emailErr; ?></span>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="********" name="password">
                <span class="text-red-500"><?php echo $passwordErr; ?></span>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600">Confirm Password</label>
                <input type="password" class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300"
                    placeholder="********" name="confirmPassword">
                <span class="text-red-500"><?php echo $confirmPasswordErr; ?></span>
            </div>
            <button type="submit"
                class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-lg hover:bg-blue-600">Register</button>
        </form>
    </div>
</body>

</html>