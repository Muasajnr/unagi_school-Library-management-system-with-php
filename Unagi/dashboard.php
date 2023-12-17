<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unagi"; 
// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count items in the books table****
$sql = "SELECT COUNT(*) as total_items FROM books";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    $books= $row['total_items'];
  
} else {
    // Display an error message if the query fails
    echo "Error: " . $sql . "<br>" . $conn->error;
}
//**** *

// Query to count items in the borrowed table****
$sql = "SELECT COUNT(*) as total_items FROM borrowed";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    $borrowed= $row['total_items'];
  
} else {
    // Display an error message if the query fails
    echo "Error: " . $sql . "<br>" . $conn->error;
}
//**** *

// Query to count items in the returned table****
$sql = "SELECT COUNT(*) as total_items FROM returned";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    $returned= $row['total_items'];
  
} else {
    // Display an error message if the query fails
    echo "Error: " . $sql . "<br>" . $conn->error;
}
//**** *

// Query to count items in the lostbooks table****
$sql = "SELECT COUNT(*) as total_items FROM lostbooks";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    $lostbooks= $row['total_items'];
  
} else {
    // Display an error message if the query fails
    echo "Error: " . $sql . "<br>" . $conn->error;
}
//**** *

// Close the connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Unagi | Dashboard </title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-Ff0t4P/HSI6vz24s6K9TdMbpF12xtKj/K1JCW9IqpoYGj3zeG8LOLT5bPVc5E3Pw9AqX71QQi8Yg5f2WIv2VRg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" /> -->

        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3 shadow-sm " href="dashboard.php">UNAGI</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <!-- Add this to your HTML where you want the search input and button -->

                <div class="input-group">
    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search here..." aria-describedby="btnNavbarSearch" id="searchInput" />
    <button class="btn btn-primary" id="btnNavbarSearch" type="button" onclick="searchDatabase()"><i class="fas fa-search"></i></button>
</div>

<div id="searchResults">
    <!-- Display search results here -->
</div>

<div id="loadingSpinner" style="display: none;">
    <!-- Loading spinner (font awesome spinner) -->
    <i class="fas fa-spinner fa-spin"></i> Searching...
</div>

<script>
    function performSearch(query) {
        // Display loading spinner during the AJAX request
        document.getElementById('loadingSpinner').style.display = 'block';

        // Make an AJAX request using the Fetch API
        fetch('search.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `searchTerm=${encodeURIComponent(query)}`,
})
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => displaySearchResults(data))
        .catch(error => {
            console.error('Error:', error);
            displayError('An error occurred during the search.');
        })
        .finally(() => {
            // Hide loading spinner after the AJAX request is complete
            document.getElementById('loadingSpinner').style.display = 'none';
        });
    }

    function displaySearchResults(results) {
        var resultsContainer = document.getElementById('searchResults');
        resultsContainer.innerHTML = ''; // Clear previous results

        if (results.length === 0) {
            resultsContainer.innerHTML = '<p>No results found</p>';
        } else {
            var ul = document.createElement('ul');
            results.forEach(function(result) {
                var li = document.createElement('li');
                li.textContent = JSON.stringify(result); // Adjust as needed based on your data structure
                ul.appendChild(li);
            });
            resultsContainer.appendChild(ul);
        }
    }

    function displayError(message) {
        var resultsContainer = document.getElementById('searchResults');
        resultsContainer.innerHTML = `<p>${message}</p>`;
    }

    function searchDatabase() {
        // Get the search input value
        var query = document.getElementById('searchInput').value;

        // Call the performSearch function with the query
        performSearch(query);
    }
</script>

            </form>
            <!-- Display the search results here -->
<div id="searchResults"></div>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Home</div>
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Update Books</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                New Books
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="newbook.php">Add New Book</a>
                                    
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                 Books
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Lend/Recieve Book
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="lendbook.php">Lend a Book</a>
                                            <a class="nav-link" href="recieveback.php">Recieve a Book </a>
                        
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        List a Lost Book
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="lostbooks.php">Add a Lost Book</a>
                                            
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Reports</div>
                            <a class="nav-link" href="viewallbooks.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                All Books
                            </a>
                            <a class="nav-link" href="viewborrowed.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Borrowed Books
                            </a>
                            <a class="nav-link" href="viewreturned.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Returned Books
                            </a>
                            <a class="nav-link" href="viewlost.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Lost Books
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Unagi Library</div>
                        Management System
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">UNAGI LIBRARY MANAGEMENT SYSTEM</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                        <div class="col-xl-6 col-md-6">
    <div class="card bg-primary text-white mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fas fa-book fs-4 me-3"></i>
            <div class="text-center">
                <div class="h3">All Books</div>
                <p class="mb-0"><?php echo $books?></p>
            </div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="viewallbooks.php">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>

<div class="col-xl-6 col-md-6">
    <div class="card bg-warning text-white mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fas fa-book-reader fs-4 me-3"></i> <!-- Use the appropriate Font Awesome class for a borrowed book -->
            <div class="text-center">
                <div class="h3">Borrowed Books</div>
                <p class="mb-0"><?php echo $borrowed?></p>
            </div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="viewborrowed.php">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>
<div class="col-xl-6 col-md-6">
    <div class="card bg-success text-white mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fas fa-book-open fs-4 me-3"></i> <!-- Use the appropriate Font Awesome class for a returned book -->
            <div class="text-center">
                <div class="h3">Returned Books</div>
                <p class="mb-0"><?php echo $returned?></p>
            </div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="viewreturned.php">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>

<div class="col-xl-6 col-md-6">
    <div class="card bg-danger text-white mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fas fa-book-times fs-4 me-3"></i> <!-- Use the appropriate Font Awesome class for a lost book -->
            <div class="text-center">
                <div class="h3">Lost Books</div>
                <p class="mb-0"><?php echo $lostbooks?></p>
            </div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="viewlost.php">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>

<div class="col-xl-12 col-md-4">
    <div class="card bg-info text-white mb-4">
        <div class="card-body d-flex align-items-center">
            <i class="fas fa-user-graduate fs-4 me-3"></i> <!-- Use the appropriate Font Awesome class for a student -->
            <div class="text-center">
                <div class="h3">All Students</div>
                <p class="mb-0">560</p>
            </div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#">View Details</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
</div>


                        </div>
                        
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Unagi 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="script.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    </body>
</html>
