<?php
    if(isset($_POST['faq_id'])){
        include '../../../assets/php/database.php';

        $result = mysqli_query($con, " SELECT * FROM tbl_faqs WHERE faq_id = '".$_POST['faq_id']."' ");
        $row = mysqli_fetch_array($result);
        $output = '<div class="modal-header">
                        <h3>Edit Activity</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="update_faq">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label>Question <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-10">
                                    <div class="col-xl-9 col-lg-12 col-input">
                                        <input name="faq_question" type="text" class="form-control" value="'.$row['faq_question'].'" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label>Answer <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-10">
                                    <div class="col-xl-9 col-lg-12 col-input">
                                        <textarea name="faq_answer" id="text2" rows="3" class="form-control" required>'.$row['faq_answer'].'</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="text" name="faq_id" value="'.$row['faq_id'].'" hidden>
                            <button id="faq_update_p" type="submit" class="btn btn-success">Save & Publish</button>
                            <button id="faq_update_d" type="submit" class="btn btn-info">Save & Draft</button>
                            ';
        if ($row['faq_status'] == 'Trashed') {
                $output .= '<button id="faq_update_de" type="submit" class="btn btn-danger">Delete</button>';
        } else {
                $output .=  '<button id="faq_update_t" type="submit" class="btn btn-warning">Trash</button>';
        }
        $output .= '
                        </div>
                    </form>
        ';
        echo $output;
    }
?>
<script>
    /* ---------------------------------------------- /*
    * Summernote
    /* ---------------------------------------------- */
    $('#text2').summernote({
            placeholder: 'Write something...',
            height: 200,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    btnUpdate = 0;
    $("#faq_update_p").click(function(){
        btnUpdate = '1';
    });
    $("#faq_update_d").click(function(){
        btnUpdate = '2';
    });
    $("#faq_update_de").click(function(){
        btnUpdate = '3';
    });
    $("#faq_update_t").click(function(){
        btnUpdate = '4';
    });
</script>