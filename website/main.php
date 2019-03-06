<?php
	include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Teams</h2>
		<div class="tab">
			<ul>
				<li><a href="index.php"></a></li>
			</ul>
			  <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">Man City</button>
			  <button class="tablinks" onclick="openCity(event, 'Paris')">Man United</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Tottenham</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Liverpool</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Chelsea</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Arsenal</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Burnley</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Everton</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Leicester City</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Newcastle</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Crystal Palace</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Bournemouth</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">West Ham</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Watford</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Brighton</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Huddersfield</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Southampton</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Swansea City</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Stoke City</button>
			  <button class="tablinks" onclick="openCity(event, 'Tokyo')">West Brom</button>
		</div>

		<div id="London" class="tabcontent">
		  <h3>London</h3>
		  <p>London is the capital city of England.</p>
		</div>

		<div id="Paris" class="tabcontent">
		  <h3>Paris</h3>
		  <p>Paris is the capital of France.</p> 
		</div>

		<div id="Tokyo" class="tabcontent">
		  <h3>Tokyo</h3>
		  <p>Tokyo is the capital of Japan.</p>
		</div>
		<script>
			function openCity(evt, cityName) {
			  var i, tabcontent, tablinks;
			  tabcontent = document.getElementsByClassName("tabcontent");
			  for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			  }
			  tablinks = document.getElementsByClassName("tablinks");
			  for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			  }
			  document.getElementById(cityName).style.display = "block";
			  evt.currentTarget.className += " active";
			}

			// Get the element with id="defaultOpen" and click on it
			document.getElementById("defaultOpen").click();
		</script>
		
	</div>
</section>

<?php
	include_once 'footer.php';
?>