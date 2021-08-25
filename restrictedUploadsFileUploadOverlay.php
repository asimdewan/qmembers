<?php //Add overlay content for file upload here and hide this div id via SCSS later. ?>

<div id="qmembers-restricted-uploads-upload-button-top-container">
    <?php
    if($user_has_file_upload_permission):?>
        <?php echo $qmembers_text->get('restricted-uploads-here-you-can-upload-a-new-file');?>
        <br/>
        <a href="#" id="qmembers-restricted-uploads-button-top" data-mfp-src="#upload-overlay-qmem" class="open-popup-link"><?php echo $qmembers_text->get('restricted-uploads-upload-doc-button-on-top');?></a>
    <?php endif;?>
</div>

<div id="upload-overlay-qmem" class="qmember-white-popup-upload mfp-hide upload_over_qmembers">

    <div id="qmembers-restricted-uploads-overlay-close-button" class="mfp-close">
         X
    </div>

    <h1 class="qmembers-node-title">
        <?php echo $qmembers_text->get('restricted-uploads-overlay-title');?>
        <?php // echo $qmembers_text->get('restricted-uploads-overlay-title-edit');?>
    </h1>

    <form id="qmembers-restricted-uploads-uploading-multipart" action="<?php echo QMEMBERS_DRUPAL_AJAX_PATH;?>">
        <input type="hidden" id="drag_drop_doc_source_target" value="" class="drag_drop_doc_source_target" name="drag_drop_doc_source_target" />
        <div id="wrapper">
            <div id="dropArea">
			        <input id="restricted-uploads-file" type="file" name="browse_file" class="uploading_file button_new browse_file submit_btn_con" value="Datei auswahlen" multiple>
                    <h3 class="drop-text"><?php echo $qmembers_text->get('restricted-uploads-place-file-here');?></h3>
					<div class="upload-btn-wrapper">
                        <!-- <button class="btn">Upload a file</button> -->
                          <div class="drag-drop-file-container"><?php echo $qmembers_text->get('restricted-uploads-or');?></div>
                    </div>                    
                <div id="qmembers-restricted-uploads-allowed-extensions"><?php echo $qmembers_text->get('restricted-uploads-file-formats') . ' ' . $display_allowed_file_types;?></div>
            </div>
        </div>

        <div class="qmembers-error" id="browse_file_error"></div>


        <div class="progress_bar_cont"></div>
        <div class="error_cont"></div>

        <div class="upload_doc_file_name_cont"><!-- Filename START -->
            <div class="label_cont"><?php echo $qmembers_text->get('restricted-uploads-label-upload-doc-file-name');?></div>
	        <div class="values_cont"><input type="text" id="upload_doc_file_name" name="upload_doc_file_name" class="upload_doc_file_name" size="7" /> </div>
            <div class="qmembers-error" id="upload_doc_file_name_error"></div>
        </div><!-- Filename END -->

        <div class="upload_doc_category_cont"><!-- Category START -->
            <div class="label_cont"><?php echo $qmembers_text->get('restricted-uploads-label-file-category');?></div>
	        <div class="values_cont">
                <?php
                $i = 1;
		        foreach($categories as $category_arr):?>
                    <div class='category_div'>
                        <input type="radio" value="<?php echo $category_arr['id'];?>" id="file_category<?php echo $i;?>" name="file_category" />
                        <label for="file_category<?php echo $i;?>">
                            <?php echo $category_arr['title'];?>
                        </label>
                    </div>
                <?php
                    $i++;
		        endforeach;
		        ?>
	        </div>
            <div class="qmembers-error" id="file_category_error"></div>
        </div><!-- Category END -->

        <div class="upload_doc_who_see_cont"><!-- Who See START -->
            <div class="label_cont"><?php echo $qmembers_text->get('restricted-uploads-label-access-user-roles');?></div>
	        <div class="values_cont">
	            <div>
                    <input id="access_user_roles1" type="checkbox" class="checkbox_new" value="user_with_uploads" name="access_user_roles[]" />
                    <label for="access_user_roles1">
                        <?php echo $qmembers_text->get('restricted-uploads-label-user-with-upload-permission');?>
                    </label>
                </div>
	            <div>
                    <input id="access_user_roles2" type="checkbox" class="checkbox_new" value="content_team" name="access_user_roles[]" />
                    <label for="access_user_roles2">
                        <?php echo $qmembers_text->get('restricted-uploads-label-user-content-team');?>
                    </label>
                </div>
	        </div>
        </div><!-- Who See END -->

        <div id="restricted-uploads-overlay-groups-container">
            <div class="cols_cont_left"><!-- cols cont left START -->
	   	        <div class="upload_doc_regional_group_cont"><!-- Regional Groups START -->
			        <div class="restricted-uploads-overlay-group-type-title"><?php echo $qmembers_text->get('restricted-uploads-label-regional-groups');?>:</div>
			        <div class="values_cont">
                        <div>
                            <input id="access_regional_groups1" type='checkbox' class='checkbox_new'/>
                            <label for="access_regional_groups1">
                                <?php echo $qmembers_text->get('restricted-uploads-checkbox-all');?>
                            </label>
                        </div>

                        <?php
                        $i=2;
			            foreach($getRegionalGroups as $group_arr):?>
				            <div>
                                <input id="access_regional_groups<?php echo $i;?>" type="checkbox" class="checkbox_new" value="<?php echo $group_arr['id'];?>" name="access_regional_groups[]" />
				                <label for="access_regional_groups<?php echo $i;?>">
                                    <?php echo $group_arr['title'];?>
                                </label>
                            </div>
				        <?php
                            $i++;
                        endforeach;
			            ?>
			        </div>
		        </div><!-- Regional Groups END -->
	        </div><!-- cols cont left END -->

            <div class="cols_cont_right"><!-- cols cont right START -->
	   	        <div class="upload_doc_working_group_cont"><!-- Working Groups START -->
			        <div class="restricted-uploads-overlay-group-type-title"><?php echo $qmembers_text->get('restricted-uploads-label-work-groups');?>:</div>
			        <div class="values_cont">
                        <div>
                            <input id="access_work_groups1" type='checkbox' class='checkbox_new' />
                            <label for="access_work_groups1">
                                <?php echo $qmembers_text->get('restricted-uploads-checkbox-all');?>
                            </label>
                        </div>

                        <?php
                        $i = 2;
                        foreach($getWorkGroups as $group_arr):?>
				            <div>
                                <input id="access_work_groups<?php echo $i;?>" type="checkbox" class="checkbox_new" value="<?php echo $group_arr['id'];?>" name="access_work_groups[]" />
				                <label for="access_work_groups<?php echo $i;?>">
                                    <?php echo $group_arr['title'];?>
                                </label>
                            </div>
				        <?php
                            $i++;
                        endforeach;
			            ?>
			        </div>
		        </div><!-- Working Groups END -->
	        </div><!-- cols cont right END -->

        </div> <!-- cols cont END -->

        <div class="qmembers-error" id="access_error"></div>
        <div class="qmembers-error" id="form_error"></div>

        <input type="hidden" name="request_id" value="submitRestrictedUploadsUploading"/>

        <!-- RESPONSE DIV FOR AJAX -->
        <div id="qmembers-restricted-uploads-uploading-multipart-result"></div>
		<div id="qmembers-restricted-uploads-uploading-multipart-progress"><div class="progress_container">&nbsp;</div></div>
        <!-- RESPONSE DIV FOR AJAX -->

        <div id="qmembers-restricted-uploads-loading"></div>

         <div id="qmembers-restricted-uploads-overlay-action-buttons"><!-- bottom buttons START -->
            <button type="button" id="qmembers-restricted-uploads-overlay-cancel" class="mfp-close qmembers-restricted-uploads-action-button">
                <?php echo $qmembers_text->get('restricted-uploads-cancel-button');?>
            </button>

             <!--
            <button type="button" id="qmembers-restricted-uploads-overlay-reset" class="qmembers-restricted-uploads-action-button">
                <?php //echo $qmembers_text->get('restricted-uploads-reset-button');?>
            </button>
            -->

            <button type="submit" id="qmembers-restricted-uploads-overlay-upload" class="qmembers-restricted-uploads-action-button">
                <?php echo $qmembers_text->get('restricted-uploads-upload-doc-button');?>
            </button>
        </div><!-- bottom buttons END -->

     </form>
</div> <!-- upload-overlay-qmem END -->
