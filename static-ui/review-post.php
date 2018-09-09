<?php require_once ("head-utils.php");?>
<?php require_once "navbar.php"; ?>

<div>
<h3>Rating</h3>
<p>Please leave a rating from 1-5 for this rec Area</p>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star checked"></span>
	<span class="fa fa-star"></span>
	<span class="fa fa-star"></span>

</div>
<hr>
<div>
	<h3>Review</h3>
	<p>Please leave a review below</p>
<form action="#">
	<textarea name="review" id="review" cols="30" rows="10">

	</textarea>

</form>
<button type="submit">Submit</button>
<button type="submit">Edit</button>
<button type="submit">Delete</button>
<button type="submit">Reset</button>

</div>

<div>
	<p id="content">This is an awesome rec Area</p>
	<p id="date"> August 18th, 2018</p>
</div>

<?php require_once "footer.php"; ?>
