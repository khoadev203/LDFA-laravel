
<?php 
	include "vendor/views/header/header.blade.php";
	if(isset($_GET['id'])){
		$token = $_GET['id'];
		$GetDetails = mysqli_query($ConClass, "SELECT * FROM `merchants` WHERE `id`='$token'");
		$GTD = mysqli_fetch_assoc($GetDetails);
	}
?>
<div class="content-page">
      <div class="container-fluid">
         <div class="row">                  
            <div class="col-lg-12">
               <div class="card card-block card-stretch card-height print rounded">
                  <div class="card-header d-flex justify-content-between bg-primary header-invoice">
                  </div>
                  <div class="card-body">
                        <div class="row">
                           <div class="col-sm-12">                                  
                              <img src="assets/images/logo.png" class="logo-invoice img-fluid mb-3">
                              
                        </div>
                        
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="table-responsive-sm">
                                    <table class="table">
                                       
                                       <tbody>
                                          <tr>
                                                <th>APP Name</th>
                                                <td><?php echo $GTD['name']; ?></td>
                                          </tr>
										  <tr>
                                                <th>API Currency</th>
                                                <td><?php if($GTD['currency_id'] == 1){ echo "USD"; }elseif($GTD['currency_id'] == 2){ echo "EUR"; }else{ echo "Undefined"; }; ?></td>
                                          </tr>
										  <tr>
                                                <th>APP ID</th>
                                                <td>APP-<?php echo $GTD['id']; ?></td>
                                          </tr>
										  <tr>
                                                <th>Site URL</th>
                                                <td><?php echo $GTD['site_url']; ?></td>
                                          </tr>
										  <tr>
                                                <th>Success Link</th>
                                                <td><?php echo $GTD['success_link']; ?></td>
                                          </tr>
										  <tr>
                                                <th>Fail Link</th>
                                                <td><?php echo $GTD['fail_link']; ?></td>
                                          </tr>
                                          <tr>
                                                <th>APP Logo</th>
                                                <td><img src="<?php echo $GTD['logo']; ?>" width="40" /></td>
                                          </tr>
                                          <tr>
                                                <th>Description</th>
                                                <td><?php echo $GTD['description']; ?></td>
                                          </tr>
										  <tr>
                                                <th>JSON DATA</th>
                                                <td><?php echo $GTD['json_data']; ?></td>
                                          </tr>
                                          
                                       </tbody>
                                    </table>
                              </div>
                           </div>                              
                        </div>                    
                  </div>
               </div>
            </div>                                    
         </div>
      </div>
      </div>
    </div>
   <?php include "vendor/views/footer/footer.blade.php"; ?>