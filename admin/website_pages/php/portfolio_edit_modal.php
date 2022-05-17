<?php
    if(isset($_POST['port_id'])){
        include '../../../assets/php/database.php';

        $result = mysqli_query($con, " SELECT * FROM tbl_portfolios WHERE port_id = '".$_POST['port_id']."' ");
        $row = mysqli_fetch_array($result);
        $output = '<div class="modal-header">
                        <h3>Edit Activity</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="update_portfolio">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label>Title <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-10">
                                    <div class="col-xl-9 col-lg-12 col-input">
                                        <input name="port_title" type="text" class="form-control" value="'.$row['port_title'].'" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label>Short text <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-10">
                                    <div class="col-xl-9 col-lg-12 col-input">
                                        <textarea name="port_notes" rows="3" class="form-control" required>'.$row['port_notes'].'</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2">
                                    <label>Images <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-10">
                                    <div class="col-xl-9 col-lg-12 col-input row">';
                                        $image_explode = explode('|',$row['port_image']);
                                        foreach ($image_explode as $image) {
                                            if(strlen($image) < 21){
                                                $filename = $image;
                                            }else{
                                                $filename = $image." ";
                                                $filename = substr($filename,0,21);
                                                $filename = substr($filename,0,strrpos($filename,' '));
                                                $filename = $filename."...";
                                            }
                                            $output .= '<div class="col-2"><img src="/assets/img/portfolio/'.$image.'" style="width:100%"/><p class="text-center">'.$filename.'</p></div>';
                                        }
                        $output .= '</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="text" name="port_id" value="'.$row['port_id'].'" hidden>
                            <button id="port_update_p" type="submit" class="btn btn-success">Save & Publish</button>
                            <button id="port_update_d" type="submit" class="btn btn-info">Save & Draft</button>
                            ';
        if ($row['port_status'] == 'Trashed') {
                $output .= '<button id="port_update_de" type="submit" class="btn btn-danger">Delete</button>';
        } else {
                $output .=  '<button id="port_update_t" type="submit" class="btn btn-warning">Trash</button>';
        }
        $output .= '
                        </div>
                    </form>
        ';
        echo $output;
    }
?>
<script>
    btnUpdate = 0;
    $("#port_update_p").click(function(){
        btnUpdate = '1';
    });
    $("#port_update_d").click(function(){
        btnUpdate = '2';
    });
    $("#port_update_de").click(function(){
        btnUpdate = '3';
    });
    $("#port_update_t").click(function(){
        btnUpdate = '4';
    });
</script>