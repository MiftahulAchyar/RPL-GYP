<?php 
if (isset($img) ) {
 ?>
	<div style="
		max-width: 700px;
		max-height: 200px;
		background-position: center;
		background-image: url('<?=$img;?>');
		background-repeat: no-repeat;
		background-size: 100%;
		width: 800px;
		height: 200px;
	">	
	</div>
<?php 
	}
	if (isset($content)) {
?>
		<article><?= $content; ?></article>
<?php 
}
 ?>