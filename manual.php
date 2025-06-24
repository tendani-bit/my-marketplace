<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Manual | Community Marketplace</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="container py-5">

    <h1 class="mb-4 text-center">Community Marketplace - User Manual</h1>

    <div class="accordion" id="manualAccordion">
        <!-- Introduction -->
        <div class="card">
            <div class="card-header" id="headingIntro">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#intro" aria-expanded="true">
                        Introduction
                    </button>
                </h2>
            </div>
            <div id="intro" class="collapse show" data-parent="#manualAccordion">
                <div class="card-body">
                    Welcome to the marketplace — a digital platform created to empower informal businesses. Our goal is to help local entrepreneurs and small vendors connect with customers, manage sales, and grow their businesses online.
                </div>
            </div>
        </div>

        <!-- Getting Started -->
        <div class="card">
            <div class="card-header" id="headingStart">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#start">
                        Getting Started
                    </button>
                </h2>
            </div>
            <div id="start" class="collapse" data-parent="#manualAccordion">
                <div class="card-body">
                    <ol>
                        <li>Go to www.marketplace.com</li>
                        <li>Click on “Sign Up”</li>
                        <li>Choose whether you’re a Buyer or Seller</li>
                        <li>Fill in name, phone number, email, location</li>
                        <li>Confirm account via SMS or email</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Dashboard Navigation -->
        <div class="card">
            <div class="card-header" id="headingDashboard">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#dashboard">
                        Navigating the Dashboard
                    </button>
                </h2>
            </div>
            <div id="dashboard" class="collapse" data-parent="#manualAccordion">
                <div class="card-body">
                    <ul>
                        <li><strong>Sellers:</strong> Manage listings, track orders, view earnings</li>
                        <li><strong>Buyers:</strong> Browse products, manage orders, contact sellers</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Listing a Product -->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#listing">
                        Listing a Product or Service
                    </button>
                </h2>
            </div>
            <div id="listing" class="collapse" data-parent="#manualAccordion">
                <div class="card-body">
                    <strong>Uploading Items:</strong>
                    <ol>
                        <li>Go to “My Listings” > “Add New”</li>
                        <li>Enter name, description, category</li>
                        <li>Upload clear photos</li>
                        <li>Set delivery options and availability</li>
                    </ol>
                    <strong>Setting Prices:</strong>
                    <ul>
                        <li>Enter price</li>
                        <li>Optionally add discounts or bulk pricing</li>
                    </ul>
                    <strong>Managing Inventory:</strong>
                    <ul>
                        <li>Update stock manually</li>
                        <li>Get low-stock alerts</li>
                        <li>Deactivate listings when out of stock</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Buying on the Marketplace -->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#buying">
                        Buying on the Marketplace
                    </button>
                </h2>
            </div>
            <div id="buying" class="collapse" data-parent="#manualAccordion">
                <div class="card-body">
                    <strong>Searching:</strong> Use search bar or filters.<br>
                    <strong>Placing Orders:</strong>
                    <ul>
                        <li>Select item and quantity</li>
                        <li>Choose delivery or pickup</li>
                        <li>Click “Order Now” and confirm payment</li>
                    </ul>
                    <strong>Tracking Orders:</strong> Go to “My Orders” to:
                    <ul>
                        <li>Check delivery status</li>
                        <li>Contact seller</li>
                        <li>Leave a rating</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Payment -->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#payment">
                        Payment & Payouts
                    </button>
                </h2>
            </div>
            <div id="payment" class="collapse" data-parent="#manualAccordion">
                <div class="card-body">
                    <strong>Accepted Methods:</strong>
                    <ul>
                        <li>Mobile money</li>
                        <li>Bank transfer</li>
                        <li>Cash on delivery (if enabled by seller)</li>
                    </ul>
                    <strong>Sellers receive payments:</strong>
                    <ul>
                        <li>After order is completed</li>
                        <li>Withdraw via bank or mobile wallet</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Support -->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#support">
                        Messaging & Support
                    </button>
                </h2>
            </div>
            <div id="support" class="collapse" data-parent="#manualAccordion">
                <div class="card-body">
                    <ul>
                        <li>Use in-app chat to contact sellers</li>
                        <li>Report issues via chat</li>
                        <li>Or email <strong>support@marketplace.com</strong></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Rules -->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#rules">
                        Rules & Guidelines
                    </button>
                </h2>
            </div>
            <div id="rules" class="collapse" data-parent="#manualAccordion">
                <div class="card-body">
                    <ul>
                        <li>List only legal and authentic products</li>
                        <li>No harassment, spam, or scams</li>
                        <li>Violations may result in suspension</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Troubleshooting -->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#troubleshooting">
                        Troubleshooting
                    </button>
                </h2>
            </div>
            <div id="troubleshooting" class="collapse" data-parent="#manualAccordion">
                <div class="card-body">
                    <strong>Issue: Can’t log in</strong><br>→ Reset password via email/SMS<br><br>
                    <strong>Issue: Item not showing</strong><br>→ Check if published or awaiting approval<br><br>
                    <strong>Issue: Didn't receive payment</strong><br>→ Check transaction or contact support
                </div>
            </div>
        </div>

        <!-- FAQs -->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#faq">
                        Frequently Asked Questions
                    </button>
                </h2>
            </div>
            <div id="faq" class="collapse" data-parent="#manualAccordion">
                <div class="card-body">
                    <strong>Q: Do I need a business license?</strong><br>
                    A: No, this platform supports informal businesses.<br><br>
                    <strong>Q: Can I sell services?</strong><br>
                    A: Yes, services like tailoring and repairs are allowed.<br><br>
                    <strong>Q: How are disputes handled?</strong><br>
                    A: Use the in-app resolution center or contact support.
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#contact">
                        Contact Information
                    </button>
                </h2>
            </div>
            <div id="contact" class="collapse" data-parent="#manualAccordion">
                <div class="card-body">
                    <ul>
                        <li><strong>Website:</strong> www.marketplace.com</li>
                        <li><strong>Email:</strong> support@marketplace.com</li>
                        <li><strong>WhatsApp:</strong> +27 63 156 7901</li>
                        <li><strong>Hours:</strong> Mon–Sat, 9:00 AM – 6:00 PM</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="settings.php" class="btn btn-secondary">Back to Settings</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
