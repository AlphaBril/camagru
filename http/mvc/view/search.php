<div class="flex">
	<form id='formsearch' action='index.php?page=search' method='POST' autocomplete='off'>
		<div class='autocomplete'>
			<input class='inputs' name='input_search' type='text' id='myInput'>
		</div>
		<button class='button' type='submit'>Search</button>
	</form>
	<div class='flex' id='results_search'>
		<?php get_result(); ?>
		<div id='iframe-cont'>
			<?php 
				if ($_POST['input_search'])
					echo "<iframe id='iframe' src='index.php?page=home&iframe=on&user=" . $_POST['input_search'] . "'></iframe>";
			?>
		</div>
	</div>
	<div class='flex-row' id='suggestion'>
		<?php get_suggestion(); ?>
	</div>
</div>
<script type="text/javascript" src="public/js/search.js"></script>
<script type="text/javascript">
	var searchList = JSON.parse('<?= $search_list; ?>');
	var List = [""];
	if (searchList)
	{
		for (i = 0; i < searchList.length; i++)
			List.push(searchList[i].username);
		autocomplete(document.getElementById("myInput"), List);
	}
</script>
