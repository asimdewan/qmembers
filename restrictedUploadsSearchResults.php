<?php ?>



<div id="<?php echo $form_id;?>-result">



    <?php
	  include_once('restrictedUploadsFileUploadOverlay.php');
	?>



    <!-- Example: How to check if user belongs to the content team -->

    <?php if($user_belongs_to_content_team):?>

        This user belongs to the content team.

    <?php else:?>

        This user doesn't belong to the content team.

    <?php endif;?>



</div>

