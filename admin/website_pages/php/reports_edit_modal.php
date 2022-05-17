<?php
    if(isset($_POST['rep_id'])){
        include '../../../assets/php/database.php';

        $result = mysqli_query($con, " SELECT * FROM tbl_reports WHERE rep_id = '".$_POST['rep_id']."' ");
        $row = mysqli_fetch_array($result);
        $output = '<div class="modal-header">
                        <h3>Edit Report</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="update_report">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label>Report Title</label> <span class="text-red">*</span>
                                </div>
                                <div class="col-10">
                                    <div class="col-xl-9 col-lg-12 col-input">
                                        <input name="rep_title" type="text" class="form-control" value="'.$row['rep_title'].'" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label>Report Notes</label>
                                </div>
                                <div class="col-10">
                                    <div class="col-xl-9 col-lg-12 col-input">
                                        <textarea name="rep_notes" rows="3" class="form-control">'.$row['rep_notes'].'</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label>Report Content</label> <span class="text-red">*</span>
                                </div>
                                <div class="col-10">
                                    <div class="col-xl-9 col-lg-12 col-input">
                                        <textarea id="rep_content_edit" name="rep_content" row="7" required>'.$row['rep_content'].'</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="text" name="rep_id" value="'.$row['rep_id'].'" hidden>
                            <button id="update_report_sp" type="submit" class="btn btn-success">Save & Publish</button>
                            <button id="update_report_sd" type="submit" class="btn btn-info">Save & Draft</button>
                            ';
        if ($row['rep_status'] == 'Trashed') {
                $output .= '<button id="update_report_d" type="submit" class="btn btn-danger">Delete</button>';
        } else {
                $output .=  '<button id="update_report_t" type="submit" class="btn btn-warning">Trash</button>';
        }
        $output .= '
                        </div>
                    </form>
        ';
        echo $output;
    }
?>
<script>
    $(function () {
        // Summernote
        $('#rep_content_edit').summernote({
            placeholder: 'Write something...',
            height: 300,
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
    })
    btnUpdate = 0;
    $("#update_report_sp").click(function(){
        btnUpdate = '1';
    });
    $("#update_report_sd").click(function(){
        btnUpdate = '2';
    });
    $("#update_report_t").click(function(){
        btnUpdate = '3';
    });
    $("#update_report_d").click(function(){
        btnUpdate = '4';
    });
</script>