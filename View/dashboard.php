<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art Web - Admin Dashboard</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz@9..144&display=swap" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="admin-body">
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <a class="navbar-brand fs-2 p-0 fw-bold text-white" href="index.php">
                    <i class="fa fa-pencil col_pink me-1 align-middle"></i> art <span class="col_pink span_1">WEB</span>
                    <br> <span class="font_12 span_2">ADMIN PANEL</span>
                </a>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="admin.html"><i class="fa fa-dashboard col_pink me-2"></i> Dashboard</a>
                </li>
                <li>
                    <a href="#portfolioSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-picture-o col_pink me-2"></i> Portfolio
                    </a>
                    <ul class="collapse list-unstyled" id="portfolioSubmenu">
                        <li>
                            <a href="admin-portfolio.html">Manage Portfolio</a>
                        </li>
                        <li>
                            <a href="admin-add-portfolio.html">Add New Item</a>
                        </li>
                        <li>
                            <a href="admin-categories.html">Categories</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#blogSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fa fa-file-text col_pink me-2"></i> Blog
                    </a>
                    <ul class="collapse list-unstyled" id="blogSubmenu">
                        <li>
                            <a href="admin-blog.html">Manage Posts</a>
                        </li>
                        <li>
                            <a href="admin-add-blog.html">Add New Post</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="admin-products.html"><i class="fa fa-shopping-cart col_pink me-2"></i> Products</a>
                </li>
                <li>
                    <a href="admin-orders.html"><i class="fa fa-list-alt col_pink me-2"></i> Orders</a>
                </li>
                <li>
                    <a href="admin-users.html"><i class="fa fa-users col_pink me-2"></i> Users</a>
                </li>
                <li>
                    <a href="admin-settings.html"><i class="fa fa-cog col_pink me-2"></i> Settings</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-pink">
                        <i class="fa fa-align-left"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-bell col_pink"></i>
                                    <span class="badge bg-pink">3</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">New order received</a></li>
                                    <li><a class="dropdown-item" href="#">New user registered</a></li>
                                    <li><a class="dropdown-item" href="#">New comment to approve</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user col_pink"></i> Admin User
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="font_40">Dashboard</h2>
                        <p class="mb-0">Welcome back, Admin!</p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card border-left-pink shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-pink text-uppercase mb-1">
                                            Portfolio Items</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">124</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-picture-o fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card border-left-pink shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-pink text-uppercase mb-1">
                                            Blog Posts</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">42</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-file-text fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card border-left-pink shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-pink text-uppercase mb-1">
                                            New Orders</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">8</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-shopping-cart fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card border-left-pink shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-pink text-uppercase mb-1">
                                            Registered Users</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">156</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="row">
                    <!-- Sales Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-pink">Monthly Sales</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-pink">Revenue Sources</h6>
                            </div>
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="revenueChart"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <span class="me-2">
                                        <i class="fa fa-circle text-primary"></i> Prints
                                    </span>
                                    <span class="me-2">
                                        <i class="fa fa-circle text-pink"></i> Originals
                                    </span>
                                    <span class="me-2">
                                        <i class="fa fa-circle text-info"></i> Commissions
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-pink">Recent Orders</h6>
                                <a href="admin-orders.html" class="btn btn-sm btn-pink">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Customer</th>
                                                <th>Items</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>#1256</td>
                                                <td>John Smith</td>
                                                <td>2</td>
                                                <td>$245.00</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-pink">View</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#1255</td>
                                                <td>Sarah Johnson</td>
                                                <td>1</td>
                                                <td>$120.00</td>
                                                <td><span class="badge bg-warning">Processing</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-pink">View</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#1254</td>
                                                <td>Michael Brown</td>
                                                <td>3</td>
                                                <td>$375.00</td>
                                                <td><span class="badge bg-danger">Cancelled</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-pink">View</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#1253</td>
                                                <td>Emily Davis</td>
                                                <td>1</td>
                                                <td>$85.00</td>
                                                <td><span class="badge bg-info">Shipped</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-pink">View</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>#1252</td>
                                                <td>Robert Wilson</td>
                                                <td>2</td>
                                                <td>$210.00</td>
                                                <td><span class="badge bg-success">Completed</span></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-pink">View</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/main.js">
    </script>
</body>

</html>