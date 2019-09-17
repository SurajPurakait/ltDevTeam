<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content" id="import_lead_div">
                  <?php if(count($all_leads)>0){ ?>
                  <form name="import_lead_form" method="post" id="import_lead_form">
                           <?php 
                           echo '<input type="hidden" id="lead_count" value="'.count($all_leads).'">';
                           foreach($all_leads as $al){
                            $city = ($al['domain_city_name']=="Unknown") ? 'Taxleaf Corporate' : 'Taxleaf '.$al['domain_city_name'];
                            echo '<input type="checkbox" name="import_lead[]" value="'.$al['insert_id'].'">';
                            echo '<p><b>Lead Name</b> : '.$al['lname'].', '.$al['fname'].'</p>';
                            echo '<p><b>Office Name</b> : '.$city.'</p>';
                            echo '<hr>';
                           } ?>
                    <button class="btn btn-success" type="button" onclick="insert_import_lead()">Import</button>
                  </form>
                <?php } else { ?>
                  <div class="text-center m-t-30">
                      <div class="alert alert-danger">
                          <i class="fa fa-times-circle-o fa-4x"></i> 
                          <h3><strong>Sorry !</strong> no lead found</h3>
                      </div>
                  </div>
                <?php } ?>
                 </div>
            </div>
           </div>
          </div>
         </div>        