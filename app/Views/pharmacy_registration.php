<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Pharmacy - MedFinder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .card-header {
            background-color: transparent;
            border-bottom: none;
            padding-bottom: 0.5rem;
        }
        .form-control {
            border-radius: 0.5rem;
            background-color: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .btn-primary {
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2 class="mb-0">Register Your Pharmacy</h2>
                    </div>
                    <div class="card-body">
                        <?php if(session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <p><?= esc($error) ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php
// Original password
$password = 'goodhealth';

// Generate a hash from the password
$hash = password_hash($password, PASSWORD_BCRYPT);

// Now verify the password against the generated hash
if (password_verify($password, $hash)) {
    echo "Password matches.";
} else {
    echo "Password does not match.";
}

echo "<br>Generated Hash: " . $hash; // You can see the generated hash
?>

                        <form action="<?= base_url('pharmacy-registration/register') ?>" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="<?= old('password') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="passconf" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="passconf" name="passconf" value="<?= old('passconf') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= old('phone') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="pharmacy_name" class="form-label">Pharmacy Name</label>
                                <input type="text" class="form-control" id="pharmacy_name" name="pharmacy_name" value="<?= old('pharmacy_name') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Pharmacy Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required><?= old('address') ?></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register Pharmacy</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
