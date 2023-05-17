<?php
// Include configuration file  
require_once 'config.php';

// Include the database connection file 
include_once 'dbConnect.php';

// Fetch plans from the database 
$sqlQ = "SELECT * FROM plans";
$stmt = $db->prepare($sqlQ);
$stmt->execute();
$stmt->store_result();
?>

<html>

<head>
    <title>Stripe Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-8">

                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Subscription with Stripe</h3>

                        <!-- Plan Info -->
                        <div>
                            <b>Select Plan:</b>
                            <select id="subscr_plan" class="form-control">
                                <?php
                                if ($stmt->num_rows > 0) {
                                    $stmt->bind_result($id, $name, $price, $interval);
                                    while ($stmt->fetch()) {
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $name . ' [$' . $price . '/' . $interval . ']'; ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body">
                        <!-- Display status message -->
                        <div id="paymentResponse" class="hidden"></div>

                        <!-- Display a subscription form -->
                        <form id="subscrFrm">
                            <div class="form-group">
                                <label>NAME</label>
                                <input type="text" id="name" class="form-control" placeholder="Enter name" required=""
                                    autofocus="">
                            </div>
                            <div class="form-group">
                                <label>EMAIL</label>
                                <input type="email" id="email" class="form-control" placeholder="Enter email"
                                    required="">
                            </div>

                            <div class="form-group">
                                <label>CARD INFO</label>
                                <div id="card-element">
                                    <!-- Stripe.js will create card input elements here -->
                                </div>
                            </div>

                            <!-- Form submit button -->
                            <button id="submitBtn" class="btn btn-success">
                                <div class="spinner hidden" id="spinner"></div>
                                <span id="buttonText">Proceed</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://js.stripe.com/v3/"></script>
<script src="js/checkout.js" STRIPE_PUBLISHABLE_KEY="<?php echo STRIPE_PUBLISHABLE_KEY; ?>" defer></script>

</html>