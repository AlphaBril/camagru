<div style='display:flex' id=filter>
	<?php get_filters(); ?>
</div>
<video id=video></video>
<canvas id=canvas></canvas>
<button style="display:none;" id=smile></button>
<button style="display:none;" onclick="sendPicture()" id=conf>&#10004</button>
<button style="display:none;" onclick="resetPicture()" id=del>&#10008</button>
<input type='file' accept='.png' name='upload' value='img' style="display:none;" id=upload></button>
<label id='uploadview' for='upload'>&#10010</label>
<script type="text/javascript" src="public/js/camera.js"></script>
