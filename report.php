<?php
error_reporting(0);

require_once 'app/require.php';
require_once 'app/controllers/CheatController.php';

$user = new UserController;
Session::init();

if (!Session::isLogged()) { Util::redirect('/login.php'); }

$username = Session::get("username");

Util::banCheck();
Util::head($username);
Util::navbar();


?>

<?php if ($user->getSubStatus() <= 0) : ?>
<main class="container mt-2">

	<div class="row">
					<div class="col-lg-9 col-md-12">
						<div class="card">
							<div class="card-body">

								<h4 class="card-title text-center">You don't have permission to report!</h4>


								<form method="POST" action="./index.php">

									<button class="btn btn-outline-primary btn-block" type="submit" value="submit">Return</button>

								</form>


							</div>
						</div>
					</div>

							<div class="col-lg-3 col-md-12">
			<div class="rounded p-3 mb-3">
				<div class="h5 border-bottom border-secondary pb-1">Price List:</div>
				<div class="row text-muted">

					<!--Detected // Undetected-->
					<div class="col-12 clearfix">
						1 Month: <p class="float-right mb-0">2,00€</p>
					</div>

					<div class="col-12 clearfix">
						Lifetime: <p class="float-right mb-0">3,50€</p>
					</div>

		            <div class="col-12 clearfix">
						Whitelist: <p class="float-right mb-0">1,50€</p>
					</div>


				</div>
			</div>
			<?php endif; ?>

		</div>
</main>


<?php if ($user->getSubStatus() > 0) : ?>
<main class="container mt-2">
					<div class="col-12 mb-4">
						<div class="card">
							<div class="card-body">

								<h4 class="card-title text-center">Report</h4>

								<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

									<div class="form-group">
										<input type="text" class="form-control form-control-sm" placeholder="Steam Profile URL" name="id" required>
									</div>

									<button class="btn btn-outline-primary btn-block" name="report" type="submit" value="submit">Report</button>

								</form>

								<?php
    if(isset($_POST['report'])) {
    $test = $_POST['id'];
    $word = "https://steamcommunity.com";
    if(strpos($test, $word) !== false){
    header('location: ?message=' . base64_encode(file_get_contents("http://185.248.140.100:3000/report?key=897fc94372c303b2591fa308f797a62c802af934&profile=" . $test)));
    exit();
} else{
    header('location: ?message=' . base64_encode('{"success":false,"message":"Invalid steam profile link!"}'));
    exit();
}
}

 $datafinal = "Waiting for steam profile link..";

if (isset($_GET["message"])) {
    $messageinfo = base64_decode($_GET["message"]);
    $data = json_decode($messageinfo);
    $datafinal = $data->message;
}

								?>

							</div>
						</div>
					</div>
		</div>



	</div>

			<div class="col-12 mt-3 mb-2">
			<div class="alert alert-primary" role="alert">
			<tr><a style="text-align: center;"><?php echo $datafinal; ?></a></tr>
			</div>
		</div>
		<?php endif; ?>

</main>
<?php Util::footer(); ?>