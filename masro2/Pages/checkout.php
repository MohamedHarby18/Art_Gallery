<?php
require_once '../App/connection.php';
require_once '../App/Admin.php';


session_start();
if(!isset($_SESSION['userId']) && !isset($_COOKIE['userid']))
{
  $_SESSION['error'] = "you have to login first";
  header('Location: login.php');
  exit();
}
$userid = isset($_SESSION['userId']) ? $_SESSION['userId'] : $_COOKIE['userid'];

$user = mysqli_fetch_array(mysqli_query($con,"SELECT CONCAT(Fname,' ',Lanme) as name,Email,Address FROM users WHERE UserID='$userid'"));
$grandSum = 0;
// $allItems = '';
// $items = array();

$sql = "SELECT art.ArtworkID,art.Title,art.Image,art.Description,art.Price,cart.quantity FROM artworks as art INNER JOIN shoppingcart as cart ON art.ArtworkID = cart.ItemID AND '$userid'= cart.userId";

$result = mysqli_query($con,$sql);
$result2 = mysqli_query($con,$sql);

// $add = "INSERT INTO purchases(UserID,) VALUES()";

if(isset($_POST['PlaceOrder']))
{

    $address = $_POST['billing-address'];

$invoicehtml = '
    <style>
    body{margin-top:20px;
        color: #2e323c;
        background: #f5f6fa;
        position: relative;
        height: 100%;
    }
    .invoice-container {
        padding: 1rem;
    }
    .invoice-container .invoice-header .invoice-logo {
        margin: 0.8rem 0 0 0;
        display: inline-block;
        font-size: 1.6rem;
        font-weight: 700;
        color: #2e323c;
    }
    .invoice-container .invoice-header .invoice-logo img {
        max-width: 130px;
    }
    .invoice-container .invoice-header address {
        font-size: 0.8rem;
        color: #9fa8b9;
        margin: 0;
    }
    .invoice-container .invoice-details {
        margin: 1rem 0 0 0;
        padding: 1rem;
        line-height: 180%;
        background: #f5f6fa;
    }
    .invoice-container .invoice-details .invoice-num {
        text-align: right;
        font-size: 0.8rem;
    }
    .invoice-container .invoice-body {
        padding: 1rem 0 0 0;
    }
    .invoice-container .invoice-footer {
        text-align: center;
        font-size: 0.7rem;
        margin: 5px 0 0 0;
    }
    
    .invoice-status {
        text-align: center;
        padding: 1rem;
        background: #ffffff;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        margin-bottom: 1rem;
    }
    .invoice-status h2.status {
        margin: 0 0 0.8rem 0;
    }
    .invoice-status h5.status-title {
        margin: 0 0 0.8rem 0;
        color: #9fa8b9;
    }
    .invoice-status p.status-type {
        margin: 0.5rem 0 0 0;
        padding: 0;
        line-height: 150%;
    }
    .invoice-status i {
        font-size: 1.5rem;
        margin: 0 0 1rem 0;
        display: inline-block;
        padding: 1rem;
        background: #f5f6fa;
        -webkit-border-radius: 50px;
        -moz-border-radius: 50px;
        border-radius: 50px;
    }
    .invoice-status .badge {
        text-transform: uppercase;
    }
    
    @media (max-width: 767px) {
        .invoice-container {
            padding: 1rem;
        }
    }
    
    
    .custom-table {
        border: 1px solid #e0e3ec;
    }
    .custom-table thead {
        background: #007ae1;
    }
    .custom-table thead th {
        border: 0;
        color: #ffffff;
    }
    .custom-table > tbody tr:hover {
        background: #fafafa;
    }
    .custom-table > tbody tr:nth-of-type(even) {
        background-color: #ffffff;
    }
    .custom-table > tbody td {
        border: 1px solid #e6e9f0;
    }
    
    
    .card {
        background: #ffffff;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        border: 0;
        margin-bottom: 1rem;
    }
    
    .text-success {
        color: #00bb42 !important;
    }
    
    .text-muted {
        color: #9fa8b9 !important;
    }
    
    .custom-actions-btns {
        margin: auto;
        display: flex;
        justify-content: flex-end;
    }
    
    .custom-actions-btns .btn {
        margin: .3rem 0 .3rem .3rem;
    }
    </style>
    <div class="container">
    <div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-body p-0">
					<div class="invoice-container">
						<div class="invoice-header">
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
									<div class="custom-actions-btns mb-5">
										<a href="#" class="btn btn-primary">
											<i class="icon-download"></i> Download
										</a>
										<a href="#" class="btn btn-secondary">
											<i class="icon-printer"></i> Print
										</a>
									</div>
								</div>
							</div>
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									<a href="http://localhost/art_gallery/index.php" class="invoice-logo">
										ArtGallery.com
									</a>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6">
									<address class="text-right">
										Maxwell admin Inc, 45 NorthWest Street.<br>
										Sunrise Blvd, San Francisco.<br>
										00000 00000
									</address>
								</div>
							</div>
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
									<div class="invoice-details">
										<address>
										    ' .$user['name'] .'<br>
											'. $address . '<br>
										</address>
									</div>
								</div>
								<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
									<div class="invoice-details">
										<div class="invoice-num">
											<div>Invoice - #009</div>
											<div>' .  date("Y-m-d") . '</div>
										</div>
									</div>													
								</div>
							</div>
							<!-- Row end -->
						</div>
						<div class="invoice-body">
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="table-responsive">
										<table class="table custom-table m-0">
											<thead>
												<tr>
													<th>Items</th>
													<th>Product ID</th>
													<th>Quantity</th>
													<th>Sub Total</th>
												</tr>
											</thead>
											<tbody>';
                                            while($row = mysqli_fetch_array($result)){
                                                $grandSum += $row['Price'] * $row['quantity'];
                                                // ...
                                                $invoicehtml .= '<tr>
                                                    <td>
                                                        ' . $row['Title'] .'
                                                        <p class="m-0 text-muted">
                                                            ' . $row['Description'] .'
                                                        </p>
                                                    </td>
                                                    <td>#'. $row['ArtworkID'].'</td>
                                                    <td>' .$row['quantity'] .'</td>
                                                    <td>$ '. $row['Price'] .'</td>
                                                </tr>
                                                ';
                                            }
                                            $invoicehtml .= '
												<tr>
													<td>&nbsp;</td>
													<td colspan="2">
														<p>
															Subtotal<br>
															Shipping &amp; Handling<br>
															Tax<br>
														</p>
														<h5 class="text-success"><strong>Grand Total</strong></h5>
													</td>			
													<td>
														<p>
															$'. $grandSum .'<br>
															$50.00<br>
															$49.00<br>
														</p>
														<h5 class="text-success"><strong>$' . ($grandSum +=99) .'</strong></h5>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Row end -->
						</div>
						<div class="invoice-footer">
							Thank you for your Business.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>';


require_once  '../vendor/autoload.php';
$check = new \Mpdf\Mpdf();
$check->WriteHTML($invoicehtml);

$_SESSION['succespay'] = "Success";
$check->Output('invoice.pdf','D');
header('Location: checkout.php');
exit();

}
// Admin::sendEmial($user['Email'],"RECEIPT","this is your receipt",$path);

?>  
<?php 
    require_once '../Partials/head.php';
?>
<body class="flex items-center justify-center" style="height:100vh;">
    
    <?php
        if(isset($_SESSION['succespay'])){
    ?>
    <h1 class="text-green">SUCCESS PAYMENT</h1>
    <?php 
    unset($_SESSION['succespay']) ;
    } else{?>
<div class="grid sm:px-10 lg:grid-cols-2 lg:px-20 xl:px-32">
  <div class="px-4 pt-8">
    <p class="text-xl font-medium">Order Summary</p>
    <p class="text-gray-400">Check your items. And select a suitable shipping method.</p>
    <div class="mt-8 space-y-3 rounded-lg border bg-white px-2 py-4 sm:px-6">
        <?php
         if(mysqli_num_rows($result2) == 0)
         {
            echo "<h2> No Products Found </h2>"
        ?>

        
        <?php }else{ while($roww = mysqli_fetch_array($result2)){
            ?>
        <div class="flex flex-col rounded-lg bg-white sm:flex-row">
        <img class="m-2 h-24 w-28 rounded-md border object-cover object-center" src="../Images/artworks/<?php echo $roww['Image']?>" alt="<?php echo $roww['Title'] ?>"  />
        <div class="flex w-full flex-col px-4 py-4">
          <span class="font-semibold"><?php echo $roww['Title'] ?></span>
          <span class="float-right text-gray-400"><?php echo $roww['Description'] ?></span>
          <p class="text-lg font-bold"><?php echo $roww['Price'] ?></p>
          <p class="text-lg font-bold"><?php echo $roww['quantity'] ?></p>
        </div>
      </div>
        <?php } }?>

    </div>

   
  </div>
  <div class="mt-10 bg-gray-50 px-4 pt-8 lg:mt-0">
    <p class="text-xl font-medium">Payment Details</p>
    <p class="text-gray-400">Complete your order by providing your payment details.</p>
    <div class="">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <label for="email" class="mt-4 mb-2 block text-sm font-medium">Email</label>
      <div class="relative">
        <input type="text" id="email" name="email" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="your.email@gmail.com" value="<?php echo $user['Email']?>" disabled/>
        <div class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
          </svg>
        </div>
      </div>
      <label for="card-holder" class="mt-4 mb-2 block text-sm font-medium">Card Holder</label>
      <div class="relative">
        <input type="text" id="card-holder" name="card-holder" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm uppercase shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Your full name here" />
        <div class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
          </svg>
        </div>
      </div>
      <label for="card-no" class="mt-4 mb-2 block text-sm font-medium">Card Details</label>
      <div class="flex">

        <div class="relative w-7/12 flex-shrink-0">
          <input type="text" id="card-no" name="card-no" class="w-full rounded-md border border-gray-200 px-2 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="xxxx-xxxx-xxxx-xxxx" />
          <div class="pointer-events-none absolute inset-y-0 left-0 inline-flex items-center px-3">
            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M11 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1z" />
              <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm13 2v5H1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-1 9H2a1 1 0 0 1-1-1v-1h14v1a1 1 0 0 1-1 1z" />
            </svg>
          </div>
        </div>
        <input type="text" name="credit-expiry" class="w-full rounded-md border border-gray-200 px-2 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="MM/YY" />
        <input type="text" name="credit-cvc" class="w-1/6 flex-shrink-0 rounded-md border border-gray-200 px-2 py-3 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="CVC" />
      </div>
      <label for="billing-address" class="mt-4 mb-2 block text-sm font-medium">Billing Address</label>
      <div class="flex flex-col w-full sm:flex-row">
        <div class="relative flex-shrink-0 sm:w-7/12" style="width:100%;">
          <input required type="text" id="billing-address" name="billing-address" class="w-full rounded-md border border-gray-200 px-4 py-3 pl-11 text-sm shadow-sm outline-none focus:z-10 focus:border-blue-500 focus:ring-blue-500" placeholder="Street Address" />
          
        </div>
        
      </div>

      <!-- Total -->
      <div class="mt-6 border-t border-b py-2">
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-gray-900">Subtotal</p>
          <p class="font-semibold text-gray-900">$<?php echo $grandSum ?></p>
        </div>
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-gray-900">Shipping</p>
          <p class="font-semibold text-gray-900">$50.00</p>
        </div>
        <div class="flex items-center justify-between">
          <p class="text-sm font-medium text-gray-900">Taxes</p>
          <p class="font-semibold text-gray-900">$49.00</p>
        </div>
      </div>
      <div class="mt-6 flex items-center justify-between">
        <p class="text-sm font-medium text-gray-900">Total</p>
        <p class="text-2xl font-semibold text-gray-900">$<?php echo $grandSum?></p>
      </div>
      <input type="submit" class="mt-4 mb-8 w-full rounded-md bg-gray-900 px-6 py-3 font-medium text-white" value="Place Order" name="PlaceOrder"/>
      </form>
    </div>
    
  </div>
</div>
<?php } ?>
</body>