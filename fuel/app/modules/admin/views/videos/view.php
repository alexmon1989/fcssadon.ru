<h2>Viewing <span class='muted'>#<?php echo $video->id; ?></span></h2>

<p>
	<strong>Videoid:</strong>
	<?php echo $video->videoid; ?></p>

<?php echo Html::anchor('videos/edit/'.$video->id, 'Edit'); ?> |
<?php echo Html::anchor('videos', 'Back'); ?>