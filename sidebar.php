<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Example</title>
    <style>
        /* Sidebar styling */
        .sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #d3d3d3 ; /* Forest Green color */
    overflow-x: hidden;
    padding-top: 20px;
    transition: 0.5s;
}
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 25px;
            color: #000000;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        .main-content {
    margin-left: 250px; /* Same as the width of the sidebar */
    padding: 20px; /* Add padding inside the main content */
    transition: margin-left 0.5s; /* Smooth transition for responsive adjustments */
}

        /* Close button (optional) */
        .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        /* Media query for smaller screens */
        @media screen and (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .sidebar a {float: left;}
            .main-content {margin-left: 0;}
        }

        @media screen and (max-width: 400px) {
            .sidebar a {
                text-align: center;
                float: none;
            }
        }
        .dropdown-btn {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 25px;
            color: #000000;
            display: block;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            outline: none;
        }

        /* Container for dropdown links */
        .dropdown-container {
            display: none;
            background-color: #808080;
            padding-left: 8px;
        }

        /* Style the dropdown links */
        .dropdown-container a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 20px;
            color: #000000;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-container a:hover {
            color: #f1f1f1;
        }
/* Add to ensure no overlap */
body {
    padding: 0;
    margin: 0;
    overflow-x: hidden; /* Prevent horizontal scroll */
}

/* Adjust the .main-content class to include padding and proper margin */

/* Media queries */
@media screen and (max-width: 1024px) { /* Adjust based on when your sidebar layout changes */
    .sidebar {
        width: 100%; /* Full width on smaller screens */
        position: relative; /* Position relative to allow content below */
        padding-top: 0; /* Adjust padding as needed */
    }
    .main-content {
        margin-left: 0; /* No margin on the left on smaller screens */
    }
}

/* Ensure this is the same breakpoint where your sidebar's CSS changes */
@media screen and (max-width: 700px) {
    .sidebar a, .dropdown-btn {
        text-align: left;
        float: none;
    }
}
.sidebar-logo {
    padding: 10px;
    text-align: center; /* Center logo image */
}

/* Style the image within the sidebar logo container */
.sidebar-logo img {
    max-width: 100%; /* Ensure the image is responsive and fits the container */
    height: auto; /* Maintain aspect ratio */
    margin-bottom: 20px; /* Space below the logo */
}
    </style>
</head>
<body>

<div class="sidebar">
    <!-- Logo at the top of the sidebar -->
    <div class="sidebar-logo">
        <img src="./img/aer.png" alt="Your Logo" />
    </div>
    <a href="dashboard.php">Dashboard</a>
    <a href="index.php">Analytical</a>
    <button class="dropdown-btn">Water Condition
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="ph.php">PH LEVEL</a>
        <a href="ec.php">EC LEVEL</a>
        <a href="wt.php">Water Temp</a>
    </div>
    <button class="dropdown-btn">Green House
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="ph.php">PH LEVEL</a>
        <a href="ec.php">EC LEVEL</a>
        <a href="wt.php">Water Temp</a>
    </div>
    <a href="logout.php">Logout</a>
</div>

<div class="main-content">
  
</div>

<script>
    // JavaScript to toggle the dropdown
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }
</script>
</body>

</html>
