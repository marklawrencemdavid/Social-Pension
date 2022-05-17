<?php 
    if(isset($_POST['pur_id'])){
        include 'database.php';
        date_default_timezone_set('Asia/Manila');
        $pur = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM tbl_purchases WHERE pur_id = '".$_POST['pur_id']."'"));
        $form = '<form id="update_purchase_form" class="needs-validation" novalidate>
            <input name="pot" type="text" class="visually-hidden">
            <div class="form-floating mb-2">
                <select name="pur_commodity" class="form-control" required>
                    <option value="" selected disabled>Select a commodity..</option>
                    <option value="Canned Sardines, Tuna" ';if($pur['pur_commodity'] == 'Canned Sardines, Tuna'){$form .= 'selected';}$form .= '>Canned Sardines, Tuna</option>
                    <option value="Evaporated, Condensed & Powdered Filled Milk" ';if($pur['pur_commodity'] == 'Evaporated, Condensed & Powdered Filled Milk'){$form .= 'selected';}$form .= '>Evaporated, Condensed & Powdered Filled Milk</option>
                    <option value="Coffee" ';if($pur['pur_commodity'] == 'Coffee'){$form .= 'selected';}$form .= '>Coffee</option>
                    <option value="Bread" ';if($pur['pur_commodity'] == 'Bread'){$form .= 'selected';}$form .= '>Bread</option>
                    <option value="Sugar" ';if($pur['pur_commodity'] == 'Sugar'){$form .= 'selected';}$form .= '>Sugar</option>
                    <option value="Cooking Oil" ';if($pur['pur_commodity'] == 'Cooking Oil'){$form .= 'selected';}$form .= '>Cooking Oil</option>
                    <option value="Instant Noodles" ';if($pur['pur_commodity'] == 'Instant Noodles'){$form .= 'selected';}$form .= '>Instant Noodles</option>
                    <option value="Luncheon Meat, Meatloaf, Corned Beef, Pork, Frozen/Preserved/Ready-to-Cook Beef, and Chicken" ';if($pur['pur_commodity'] == 'Luncheon Meat, Meatloaf, Corned Beef, Pork, Frozen/Preserved/Ready-to-Cook Beef, and Chicken'){$form .= 'selected';}$form .= '>Luncheon Meat, Meatloaf, Corned Beef, Pork, Frozen/Preserved/Ready-to-Cook Beef, and Chicken</option>
                    <option value="Powdered, Liquid, Bar Laundry & Detergent Soap" ';if($pur['pur_commodity'] == 'Powdered, Liquid, Bar Laundry & Detergent Soap'){$form .= 'selected';}$form .= '>Powdered, Liquid, Bar Laundry & Detergent Soap</option>
                </select>
                <span class="focus-border"></span>
                <label>Commodity <span class="text-danger">*</span></label>
            </div>
            <div class="form-group row mb-2">
                <div class="col-sm-6">
                    <div class="form-floating">
                        <input name="pur_quantity" type="text" class="form-control" onkeypress="return numberInputOnly(event)" placeholder=" " value="'.$pur['pur_quantity'].'" required>
                        <span class="focus-border"></span>
                        <label>Quantity <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating">
                        <input name="pur_amount" type="text" class="form-control" onkeypress="return numberInputOnly(event)" placeholder=" " value="'.$pur['pur_amount'].'" required>
                        <span class="focus-border"></span>
                        <label>Amount in Php <span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>
            <div class="form-group mb-2">
                <div class="form-floating">
                    <input name="pur_establishment" type="text" class="form-control" placeholder=" " value="'.$pur['pur_establishment'].'" required>
                    <span class="focus-border"></span>
                    <label>Name of Establishment <span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="form-group mb-2">';
                // <b class="form-label">Select an image for proof</b>
                // <div class="input-group">
                //     <input name="pur_proof" id="file-input" class="form-control" type="file" accept=".png, .jpg, .jpeg, .bmp, .gif, .tiff" type="file" required>
                //     <span class="focus-border"></span>
                //     <div class="input-group-append">
                //         <label id="file-clear" class="btn btn-danger">Clear</label>
                //     </div>
                // </div>
                // <span id="error_file" class="text-danger"></span>
                $form .= '<div id="preview" class="form-group row mt-1">
                    <div class="col-12"><img src="/assets/img/pensioner_proof/'.$pur['pur_proof'].'" style="width:100%"/><p class="text-center">'.$pur['pur_proof'].'</p></div>
                </div>
            </div>
            <div class="float-end">';
                if($pur['pur_status'] == 'Pending'){
                    $form .= '<button id="'.$pur['pur_id'].'" type="submit" class="btn btn-primary pur_update">Update</button>
                    <button id="'.$pur['pur_id'].'" type="submit" class="btn btn-danger pur_delete">Delete</button>';
                }
                $form .= '<button type="button" class="btn btn-secondary ms-1" data-bs-dismiss="modal">Close</button>
            </div>
        </form>';
        echo $form;
    }
?>
<script>
    btnUpdate = 0;
    $(".pur_update").click(function(){
        btnUpdate = '1';
        pur_id = this.id;
    });
    $(".pur_delete").click(function(){
        btnUpdate = '2';
        pur_id = this.id;
    });
</script>