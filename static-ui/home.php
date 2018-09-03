<?php require_once ("head-utils.php");?>
<?php require_once "navbar.php"; ?>
<!--
 this component is the landing page that will provide the
 user with a brief description of the application as well as
 the option to search for activities (by activity), to sign up
 for an account, to sign into an account, or to navigate to
 other features (such as the map or browse rec areas)

 This component will require the use of Bootstrap 4, Popper, and JQuery

-->
	<div class="container-home">
		<div class="content">
			<h1>NM Outdoors</h1>
			<p>
				Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches to corporate strategy foster collaborative thinking to further the overall value proposition. Organically grow the holistic world view of disruptive innovation via workplace diversity and empowerment.
			</p>
		</div>
		<div class="image-box"></div>
	</div>



<!-- This will need to be updated, and content added prior to deployment -->
<h3>Exploring New Mexico, one trail at a time...</h3>

<div class="input-group">
	<select class="custom-select" id="inputGroupSelect04" aria-label="Select drop-down menu to search activities">
		<option selected>Search activities...</option>
		<option value="1">Biking</option>
		<option value="2">Camping</option>
		<option value="3">Fishing</option>
		<option value="4">Hiking</option>
		<option value="5">Water Sports</option>
		<option value="6">Wildlife Viewing</option>
		<option value="7">Winter Sports</option>
	</select>
	<div class="input-group-append">
		<button class="btn btn-outline-secondary" type="button">Go</button>
	</div>
</div>
<?php require_once "footer.php"; ?>