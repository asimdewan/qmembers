

(function ($) {

    Drupal.behaviors.qmembers3 = {

        attach: function (context) {

// Activate popup
            $('.open-popup-link').magnificPopup({
                type:'inline',
                midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
            });

            $(document).ready(function(){

                $('#qmembers-restricted-uploads-search-field').keyup(function(){

                    $('form#qmembers-restricted-uploads-search').submit();

                });


                $('form').submit(function (event) {

                    event.preventDefault();
                    var form_id = $(this).attr('id');

                    if (form_id.includes("qmembers-restricted-uploads") == true){

                        if (form_id.includes("multipart") == true) submitMultipartForm(form_id);
                        else submitForm(form_id);
                    }
                });

                function submitForm(form_id){

                    var form            = $('form#' + form_id);
                    var form_data       = form.serialize(); //Encode form elements for submission
                    var post_url        = form.attr("action"); //get form action url
                    var request_method  = 'POST';

                   

                    jQuery.ajax({

                        url:  post_url,
                        type: request_method,
                        data: form_data

                    }).done(function (response) { //

                        response = response.trim();
                          //alert(response);
                        var isJson = true;

                        try {
                            responseObject = $.parseJSON(response);
                        }
                        catch (err) {
                            isJson = false;
                        }

                        if (isJson) {

                        } else {

							if(form_id == 'qmembers-restricted-uploads-delete'){
								window.location.href = '/mitgliederseiten/uploads';
							}							
							else{
                              $('#' + form_id + '-result').html(response);
							}

                        }
                    });

                }
             
                function submitMultipartForm(form_id){
					$('#qmembers-restricted-uploads-uploading-multipart-progress .progress_container').css('display','block');
					function progress(e){
						if(e.lengthComputable){
							var max = e.total;
							var current = e.loaded;
					
							var Percentage = (current * 100)/max;
							$('#qmembers-restricted-uploads-uploading-multipart-result').html(Percentage);
							if(Percentage >= 100)
							{
							   // process completed  
							}
						}  
					 }
                    
                    $('#qmembers-restricted-uploads-loading').show();
                    var form      = $('form#' + form_id);
                    var formData  = form.serialize(); //Encode form elements for submission
                    var post_url  = form.attr("action"); //get form action url
                    var request_method = 'POST';
                    if (window.FormData){
                        formData = new FormData(form[0]);
                    }
                    formData ? formData : form.serialize();
					//formData.append("json",true);
                    jQuery.ajax({
						url        : post_url,
						type       : request_method,
						contentType: false,
						cache      : false,
						processData: false,
						enctype: 'multipart/form-data',
						data       : formData,
						xhr        : function ()
						{
							var jqXHR = null;
							if ( window.ActiveXObject )
							{
								jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
							}
							else
							{
								jqXHR = new window.XMLHttpRequest();
							}
							//Upload progress
							jqXHR.upload.addEventListener( "progress", function ( evt )
							{
								if ( evt.lengthComputable )
								{
									var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
									//Do something with upload progress
									$('#qmembers-restricted-uploads-uploading-multipart-progress .progress_container').html('File Uploaded : '+percentComplete+'%');
									$('#qmembers-restricted-uploads-uploading-multipart-progress .progress_container').css('width',percentComplete+'%');
									$('#qmembers-restricted-uploads-uploading-multipart-progress .progress_container').css('min-width','200px');
								}
							}, false );
							return jqXHR;
						},
                    }).done(function (response) { //
                        $('#qmembers-restricted-uploads-uploading-multipart-progress .progress_container').css('display','block');
                        response = response.trim();

                        var isJson = true;

                        try {
                            responseObject = $.parseJSON(response);
                        }
                        catch (err) {
                            isJson = false;
                        }

                        // Clear error fields
                        $(":text,:password,[type='email'],select").each(function(){
                            $(this).css("background-color", "transparent");
                        });

                        $("[id*='_error']").each(function(){
                            $(this).html('');
                        });

                        if (isJson) {
                            $.each(responseObject, function (key, value) {
                                $('#' + key).css("background-color", "#EFB1B7");
                                $('#' + key + '_error').html(value);
								$('#qmembers-restricted-uploads-uploading-multipart-progress .progress_container').css('display','none');
                            });
                        } else {

                            $('#' + form_id + '-result').html(response);
                        }

                        $('#qmembers-restricted-uploads-loading').hide();

                    });
                }

                // Select all groups
                $('input#access_regional_groups1').change(function(){

                    if ($(this).prop('checked') == true){

                        $('.upload_doc_regional_group_cont .checkbox_new').each(function(){
                            $(this).prop('checked',true);
                        });
                    }
                    else{
                        $('.upload_doc_regional_group_cont .checkbox_new').each(function(){
                            $(this).prop('checked',false);
                        });
                    }
                });

                $('input#access_work_groups1').change(function(){

                    if ($(this).prop('checked') == true){

                        $('.upload_doc_working_group_cont .checkbox_new').each(function(){
                            $(this).prop('checked',true);
                        });
                    }
                    else{
                        $('.upload_doc_working_group_cont .checkbox_new').each(function(){
                            $(this).prop('checked',false);
                        });
                    }
                });


                /* Search Results Page START */
                // Fade out upload confirmation
                $('#qmembers-restricted-uploads-file-upload-confirmation').delay('5000').fadeOut('slow');

                // Delete file
                $('#qmembers-restricted-uploads-delete .delete-button').click(function(){
                  $(this).parent().find('.hidden_doc_id_valid').attr('name','hidden_doc_id'); // hidden_doc_id_valid
                  $(this).parent().find('.delete-submit').trigger('submit');
                });
                /* Search Results Page END */
                
				/* DRAG & Drop START */
				$('#qmembers-restricted-uploads-uploading-multipart #restricted-uploads-file').change(function () { 
					$('#qmembers-restricted-uploads-uploading-multipart .drag-drop-file-container').text(this.files[0].name);
				});
				/* DRAG & Drop END */






                // Upload Overlay JS

                /* Restrict 140 characters on the input file name FIELD for uplods overlay START */
   /*
                $('.upload_doc_file_name_cont .upload_doc_file_name').keyup(function(){
                    var input_file_name_str = $(this).val();
                    var total_chars = input_file_name_str.length;
                    total_chars = parseInt(total_chars);
                    if(total_chars>139){
                        var first_140_chars = input_file_name_str.substr(0,140);
                        $(this).val(first_140_chars);
                    }
                });
                */
                /* Restrict 140 characters on the input file name FIELD for uplods overlay END */

                /* Upload Document START */
     /*
                $('.qmember-white-popup-upload .submit_btn_con .button_right .add_new_document').click(function(){

                    var file_id = null;

                    var file_name = $('.upload_doc_file_name_cont .upload_doc_file_name').val();

                    var file_category = $('.upload_doc_category_cont .values_cont input:checked').val();

                    var access_user_roles = "";
                    $('.upload_doc_who_see_cont .values_cont input:checked').each(function(){
                        access_user_roles =  $(this).val() + ',' + access_user_roles;
                    });

                    var access_regional_groups = "";
                    $('.upload_doc_regional_group_cont .values_cont input:checked').each(function(){
                        access_regional_groups =  $(this).val() + ',' + access_regional_groups;
                    });

                    var access_work_groups = "";
                    $('.upload_doc_working_group_cont .values_cont input:checked').each(function(){
                        access_work_groups =  $(this).val() + ',' + access_work_groups;
                    });

                    var uploder_first_name = $('#qmembers-restricted-uploads-file-upload-overlay .uploder_first_name').val();
                    var uploder_last_name = $('#qmembers-restricted-uploads-file-upload-overlay .uploder_last_name').val();
                    var uploader_function_professional = $('#qmembers-restricted-uploads-file-upload-overlay .uploder_funct_prof').val();
                    var uploader_user_role  = $('#qmembers-restricted-uploads-file-upload-overlay .current_user_rid').val();
                    var drag_drop_doc_source_target = $('#qmembers-restricted-uploads-uploading .drag_drop_doc_source_target').val();

                    // EXCEPTIONAL HANDLING
                    if(file_category=="" || file_category == null){
                        $('.qmember-white-popup-upload .error_cont').html('Kategorie: Erforderlich');
                        $('.qmember-white-popup-upload .error_cont').css('display','block');
                    }
                    else if(access_user_roles =="" && access_regional_groups =="" && access_work_groups ==""){
                        $('.qmember-white-popup-upload .error_cont').html('Wahlen sie aus, wem sie das Dokument zur verfugung stellen mochten: Oder Landesgruppen	Oder			Fachgruppen');
                        $('.qmember-white-popup-upload .error_cont').css('display','block');
                    }
                    else if(drag_drop_doc_source_target=="" || drag_drop_doc_source_target == null || drag_drop_doc_source_target == 'file_type_error'){
                        $('.qmember-white-popup-upload .error_cont').html('Dokument: Erforderlich');
                        $('.qmember-white-popup-upload .error_cont').css('display','block');
                    }
                    else{
                        $('#qmembers-restricted-uploads-uploading-multipart-result').css('display','block');
                        $('.qmember-white-popup-upload .error_cont').css('display','none');
                        $('#qmembers-restricted-uploads-uploading-multipart-result').html('Uploading...');
                        $('#qmembers-restricted-uploads-uploading-multipart .submit_button').trigger('click');

                    }// NO ERROR, SUBMIT THE FORM, ELSE END

                });
                /* Upload Document END */

                /* Auto Trigger Drag & Drop on Browser File START */
               /*
                jQuery('#qmembers-restricted-uploads-uploading-multipart #dropArea .browse_file .uploading_file').change(function(e){
                    $("#dropArea").trigger('dragenter');
                    $("#dropArea").trigger('dragover');
                    var image = e.target.files;
                    createFormData(image);
                });
                /* Auto Trigger Drag & Drop on Browser File END */
/*
                jQuery("#dropArea").on('dragenter', function (e){
                    e.preventDefault();
                    $(this).css('background', '#BBD5B8');
                });

                jQuery("#dropArea").on('dragover', function (e){
                    e.preventDefault();
                });

                jQuery("#dropArea").on('drop', function (e){
                    $(this).css('background', '#D8F9D3');
                    e.preventDefault();
                    var image = e.originalEvent.dataTransfer.files;
                    createFormData(image);
                });
*/

                function createFormData(image)
                {
                    var formImage = new FormData();
                    formImage.append('userDoc', image[0]);
                    uploadFormData(formImage);
                }

                /*
                function uploadFormData(formData)
                {
                    var uploader_MemberId = $('.uploader_MemberId').val();

                    jQuery.ajax({
                        url: "/sites/all/modules/qmembers/vendor/magnific-popup-master/dist/drag_drop.php?uploader_MemberId="+uploader_MemberId ,
                        type: "POST",
                        data: formData,
                        contentType:false,
                        cache: false,
                        processData: false,
                        success: function(data){
                            if(data=='file_type_error'){
                                $('#dropArea').html('File Type Error');
                            }
                            else{
                                $('#dropArea').html('File Processed');
                            }
                            $('#qmembers-restricted-uploads-uploading-multipart .drag_drop_doc_source_target').val(data);
                            $("#dropArea").css('background','#fff');
                        }});

                }
                */


            });

        }

    }

})(jQuery);
