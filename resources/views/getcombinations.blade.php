

<div class="container">
    <?php foreach ($results as $sections): ?>
        <?php foreach ($sections as $section): ?>
        	<?php echo $section->id; ?>
   		<?php endforeach; ?>
    <?php endforeach; ?>
</div>

<?php echo $results->render(); ?>
