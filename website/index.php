<?php
	include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Welcome to Football Fan Hub</h2>
		<?php
			if (isset($_SESSION['u_id'])){
				include_once 'footer.php';
			}
		?>
	</div>	
</section>