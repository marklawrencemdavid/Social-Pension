<?php
    if(isset($_POST['todo_id'])){
        include '../../../assets/php/database.php';
        $result = mysqli_query($con, " SELECT * FROM tbl_todo WHERE todo_id = '".$_POST['todo_id']."' ");
        $row = mysqli_fetch_array($result);
        $output = '
            <div class="modal-header">
                <div>
                    <h4 class="modal-title">To Do item</h4>
                    <p><i class="fas fa-exclamation text-danger"></i> Setting the date and time later than todays will not be updated.</p>
                </div>
            </div>
            <form id="todo_update_form">
                <div class="modal-body">
                    <div class="col-12 row mb-2">
                        <div class="col-3">
                            <label>Action <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-9">
                            <textarea name="todo_action" type="text" class="form-control" required>'.$row['todo_action'].'</textarea>
                        </div>
                    </div>
                    <div class="col-12 row">
                        <div class="col-3">
                            <label>Due Date <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-9 row pr-0">
                            <div class="col-md-6 col-12 pr-0">
                                <input name="todo_date_due" type="date" class="form-control" value="'.$row['todo_date_due'].'" required>
                            </div>
                            <div class="col-md-6 col-12 pr-0">
                                <input name="todo_time_due" type="time" class="form-control" value="'.$row['todo_time_due'].'" required>
                                <input name="todo_id" type="text" value="'.$_POST['todo_id'].'" hidden>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button name="todo_update" type="submit" class="btn btn-primary">Save</button>
                    <button name="todo_create" type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                </div>
            </form>
        ';
        echo $output;
    }
?>