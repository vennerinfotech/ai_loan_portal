<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Loan Type - LoanHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* General Body and Container Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff; /* White background */
            padding-top: 20px;
        }

        .container {
            max-width: 1200px;
        }

        /* Header Styling */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }

        .page-header p {
            font-size: 1rem;
            color: #6c757d;
        }

        /* Navbar Styling */
        .navbar {
            padding: 1rem 3rem;
        }
        .navbar-brand {
            font-weight: 600;
        }

        .user-info .fa-bell {
            color: #ffc107; /* Yellow alert icon */
        }
        .user-info img {
            width: 30px;
            height: 30px;
            object-fit: cover;
        }

        /* Card Base Styling */
        .loan-card {
            border: none;
            border-radius: 8px; /* Slightly rounded corners */
            padding: 20px;
            margin-bottom: 20px; /* Space between rows */
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        .loan-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 5px;
        }

        .loan-card p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 20px;
        }

        /* Feature List Styling */
        .loan-features {
            list-style: none;
            padding: 0;
            margin-bottom: 30px;
        }

        .loan-features li {
            font-size: 0.9rem;
            color: #fff;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .loan-features i {
            margin-right: 10px;
            font-size: 0.8rem;
        }

        /* Specific Loan Card Styles */

        /* Home Loan (Green) */
        .home-loan {
            background-color: #28a745;
        }
        .home-loan .fa-home { color: #fff; }
        .home-loan .fa-check-circle { color: #fff; }
        .home-loan .badge { background-color: #ffc107 !important; color: #fff; } /* Yellow Star */
        .home-loan .btn-apply {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Personal Loan (Blue) */
        .personal-loan {
            background-color: #007bff;
        }
        .personal-loan .fa-user { color: #fff; }
        .personal-loan .fa-check-circle { color: #fff; }
        .personal-loan .badge { background-color: #007bff !important; color: #fff; } /* Blue Lightning */
        .personal-loan .btn-apply {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Business Loan (Purple) */
        .business-loan {
            background-color: #6f42c1;
        }
        .business-loan .fa-briefcase { color: #fff; }
        .business-loan .fa-check-circle { color: #fff; }
        .business-loan .badge { background-color: #6f42c1 !important; color: #fff; } /* Purple Chart */
        .business-loan .btn-apply {
            background-color: #6f42c1;
            border-color: #6f42c1;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Loan Against Property (Orange) */
        .lap-loan {
            background-color: #fd7e14;
        }
        .lap-loan .fa-building { color: #fff; }
        .lap-loan .fa-check-circle { color: #fff; }
        .lap-loan .badge { background-color: #fd7e14 !important; color: #fff; } /* Orange Shield */
        .lap-loan .btn-apply {
            background-color: #fd7e14;
            border-color: #fd7e14;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Education Loan (Dark Blue) */
        .education-loan {
            background-color: #5d5dff; /* Using a darker blue close to the image */
        }
        .education-loan .fa-user-graduate { color: #fff; }
        .education-loan .fa-check-circle { color: #fff; }
        .education-loan .badge { background-color: #5d5dff !important; color: #fff; } /* Dark Blue Book */
        .education-loan .btn-apply {
            background-color: #5d5dff;
            border-color: #5d5dff;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Icon Wrapper and Badge Placement */
        .icon-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .icon-wrapper i {
            font-size: 1.5rem;
        }
        .icon-wrapper .badge {
            font-size: 1rem;
            padding: .3em .6em;
            border-radius: .25rem;
        }

        /* Match the specific icon colors/styling from the image */
        .home-loan .fa-home { background-color: #28a745; border-radius: 5px; padding: 5px; }
        .personal-loan .fa-user { background-color: #007bff; border-radius: 5px; padding: 5px; }
        .business-loan .fa-briefcase { background-color: #6f42c1; border-radius: 5px; padding: 5px; }
        .lap-loan .fa-building { background-color: #fd7e14; border-radius: 5px; padding: 5px; }
        .education-loan .fa-user-graduate { background-color: #5d5dff; border-radius: 5px; padding: 5px; }

    </style>
</head>
<body>

<nav class="navbar navbar-light bg-white border-bottom">
    <a class="navbar-brand text-dark" href="#">LoanHub</a>
    <div class="user-info d-flex align-items-center">
        <i class="fas fa-bell me-3"></i>
        <span class="text-dark me-2">John Doe</span>
        <img src="https://via.placeholder.com/30/808080/FFFFFF?text=JD" class="rounded-circle" alt="User Avatar">
    </div>
</nav>

<div class="container py-5">

    <header class="page-header">
        <h1>Choose Your Loan Type</h1>
        <p>Select the loan option that best fits your requirements and start your application journey</p>
    </header>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

        <div class="col">
            <div class="card loan-card home-loan">
                <div class="icon-wrapper">
                    <i class="fas fa-home"></i>
                    <span class="badge"><i class="fas fa-star"></i></span>
                </div>
                <h3>Home Loan</h3>
                <p>Make your dream home a reality</p>

                <ul class="loan-features">
                    <li><i class="fas fa-check-circle"></i> Up to 90% financing</li>
                    <li><i class="fas fa-check-circle"></i> Competitive interest rates</li>
                    <li><i class="fas fa-check-circle"></i> Flexible tenure options</li>
                </ul>

                <a href="#" class="btn btn-apply w-100">Apply Now</a>
            </div>
        </div>

        <div class="col">
            <div class="card loan-card personal-loan">
                <div class="icon-wrapper">
                    <i class="fas fa-user"></i>
                    <span class="badge"><i class="fas fa-bolt"></i></span>
                </div>
                <h3>Personal Loan</h3>
                <p>For your personal financial needs</p>

                <ul class="loan-features">
                    <li><i class="fas fa-check-circle"></i> Quick approval process</li>
                    <li><i class="fas fa-check-circle"></i> No collateral required</li>
                    <li><i class="fas fa-check-circle"></i> Instant disbursement</li>
                </ul>

                <a href="#" class="btn btn-apply w-100">Apply Now</a>
            </div>
        </div>

        <div class="col">
            <div class="card loan-card business-loan">
                <div class="icon-wrapper">
                    <i class="fas fa-briefcase"></i>
                    <span class="badge"><i class="fas fa-chart-line"></i></span>
                </div>
                <h3>Business Loan</h3>
                <p>Fuel your business growth</p>

                <ul class="loan-features">
                    <li><i class="fas fa-check-circle"></i> High loan amounts</li>
                    <li><i class="fas fa-check-circle"></i> Flexible repayment terms</li>
                    <li><i class="fas fa-check-circle"></i> Business-friendly rates</li>
                </ul>

                <a href="#" class="btn btn-apply w-100">Apply Now</a>
            </div>
        </div>

        <div class="col">
            <div class="card loan-card lap-loan">
                <div class="icon-wrapper">
                    <i class="fas fa-building"></i>
                    <span class="badge"><i class="fas fa-shield-alt"></i></span>
                </div>
                <h3>Loan Against Property</h3>
                <p>Leverage your property value</p>

                <ul class="loan-features">
                    <li><i class="fas fa-check-circle"></i> Lower interest rates</li>
                    <li><i class="fas fa-check-circle"></i> Higher loan amounts</li>
                    <li><i class="fas fa-check-circle"></i> Longer tenure options</li>
                </ul>

                <a href="#" class="btn btn-apply w-100">Apply Now</a>
            </div>
        </div>

        <div class="col">
            <div class="card loan-card education-loan">
                <div class="icon-wrapper">
                    <i class="fas fa-user-graduate"></i>
                    <span class="badge"><i class="fas fa-book"></i></span>
                </div>
                <h3>Education Loan</h3>
                <p>Invest in your future</p>

                <ul class="loan-features">
                    <li><i class="fas fa-check-circle"></i> Cover full education costs</li>
                    <li><i class="fas fa-check-circle"></i> Flexible repayment</li>
                    <li><i class="fas fa-check-circle"></i> Student-friendly terms</li>
                </ul>

                <a href="#" class="btn btn-apply w-100">Apply Now</a>
            </div>
        </div>

        <div class="col">
            <div class="card loan-card business-loan" style="background-color: #17a2b8;">
                 <div class="icon-wrapper">
                    <i class="fas fa-car" style="background-color: #17a2b8;"></i>
                    <span class="badge" style="background-color: #17a2b8 !important;"><i class="fas fa-tag"></i></span>
                </div>
                <h3>Vehicle Loan</h3>
                <p>Get your dream vehicle today</p>

                <ul class="loan-features">
                    <li><i class="fas fa-check-circle"></i> Competitive rates</li>
                    <li><i class="fas fa-check-circle"></i> Quick documentation</li>
                    <li><i class="fas fa-check-circle"></i> Low processing fees</li>
                </ul>

                <a href="#" class="btn btn-apply w-100" style="background-color: #17a2b8; border-color: #17a2b8;">Apply Now</a>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
