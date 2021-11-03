<?php 
include "vendor/views/header/header.blade.php";
	$GetApps = mysqli_query($ConClass, "SELECT * FROM `merchants` WHERE `user_id`='$Auth'");
	if(isset($_GET['del'])){
		$del = $_GET['del'];
		$Delete = mysqli_query($ConClass, "DELETE FROM `merchants` WHERE `id`='$del'");
		if($Delete){
			echo "<script>location.href='Application'</script>";
		}else{
			echo "<script>alert('Unable to delete this APP. Please try again')</script>";
		}
	}
?>
     <div class="content-page">
     <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Marchant Application</h4>
                        <p class="mb-0">Check out your all the Marchent Application here and get there API Keys and Other Details </p>
                    </div>
                    <a href="" class="btn btn-primary add-list" data-toggle="modal" data-target="#new-app"><i class="fa fa-plus mr-3"></i>Create New Application</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                <table class="data-table table mb-0 tbl-server-info">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>
                                <div class="checkbox d-inline-block">
                                    <input type="checkbox" class="checkbox-input" id="checkbox1">
                                    <label for="checkbox1" class="mb-0"></label>
                                </div>
                            </th>
                            <th>App ID</th>
                            <th>App Website</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        <?php 
							while($GP = mysqli_fetch_assoc($GetApps)){
						?>
						<tr>
                            <td>
                                <div class="checkbox d-inline-block">
                                    <input type="checkbox" class="checkbox-input" id="checkbox2">
                                    <label for="checkbox2" class="mb-0"></label>
                                </div>
                            </td>
                            
                            <td><?php echo $GP['APP_ID'] ?></td>
                            <td><?php echo $GP['site_url'] ?></td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"
                                        href="ViewApplication?token=<?php echo $GP['merchant_key'] ?>&id=<?php echo $GP['id'] ?>"><i class="ri-eye-line mr-0"></i></a>
                                    <!--<a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"
                                        href="#"><i class="ri-pencil-line mr-0"></i></a>-->
                                    <a class="badge bg-warning mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"
                                        href="?token=<?php echo $GP['merchant_key'] ?>&del=<?php echo $GP['id'] ?>" onclick="return confirm('Are you sure you want to delete this app. You will not be able to undo this & your site which is working with this App API will stop working.')"><i class="ri-delete-bin-line mr-0"></i></a>
                                </div>
                            </td>
                        </tr>
							<?php } ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <!-- Page end  -->
    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="edit-note" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <div class="media align-items-top justify-content-between">                            
                            <h3 class="mb-3">Product</h3>
                            <div class="btn-cancel p-0" data-dismiss="modal"><i class="las la-times"></i></div>
                        </div>
                        <div class="content edit-notes">
                            <div class="card card-transparent card-block card-stretch event-note mb-0">
                                <div class="card-body px-0 bukmark">
                                    <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">                                                    
                                        <div class="quill-tool">
                                        </div>
                                    </div>
                                    <div id="quill-toolbar1">
                                        <p>Virtual Digital Marketing Course every week on Monday, Wednesday and Saturday.Virtual Digital Marketing Course every week on Monday</p>
                                    </div>
                                </div>
                                <div class="card-footer border-0">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-end">
                                        <div class="btn btn-primary mr-3" data-dismiss="modal">Cancel</div>
                                        <div class="btn btn-outline-primary" data-dismiss="modal">Save</div>
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
    </div>
	<div class="modal fade" id="new-app" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 700px;">
              <div class="modal-content">
				  <div class="modal-header">
					<h5 class="header-mb-3">New Application</h5>
				  </div>
				  <form id="NewAPP">
                  <div class="modal-body">
                      <div class="popup text-left">
                          <div class="content create-workform bg-body">
								<div id="show_message"></div>
								<div class="form-row">
								  <div class="col-md-6">
									  <label class="mb-2">APP Name</label>
									  <input type="hidden" class="form-control" name="userid" value="<?php echo $Auth; ?>">
									  <input type="text" class="form-control" name="app_name" required placeholder="APP Name">
								  </div>
								  <div class="col-md-6">
									  <label class="mb-2">Site URL</label>
									  <input type="text" class="form-control" name="site_url" required placeholder="Site URL">
								  </div>
                              </div>
							  <div class="form-row">
								  <div class="col-md-6">
									  <label class="mb-2">API Success Link</label>
									  <input type="text" class="form-control" name="success_link" required placeholder="API Success Link">
								  </div>
								  <div class="col-md-6">
									  <label class="mb-2">API Fail Link</label>
									  <input type="text" class="form-control" name="fail_link" required placeholder="API Fail Link">
								  </div>
                              </div>
							  <div class="form-row">
								  <div class="col-md-6">
									  <label class="mb-2">Logo</label>
									  <input type="text" class="form-control" name="logo_url" required placeholder="Logo">
								  </div>
								  <div class="col-md-6">
									  <label class="mb-2">Thumb</label>
									  <input type="text" class="form-control" name="thumb" placeholder="Thumb">
								  </div>
                              </div>
							  <div class="form-row">
								  <div class="col-md-12">
									  <label class="mb-2">Currency</label>
										<select class="selectpicker form-control" name="currency" required>
											<option value="1">USD</option>
											<option value="2">EUR</option>
										</select>
								  </div>
                              </div>
							  <div class="form-row">
								  <div class="col-md-12">
									  <label class="mb-2">Description</label>
									  <textarea type="text" name="description" required class="form-control"></textarea>
								  </div>
                              </div>
							  <div class="modal-footer">
								  <div class="col-lg-12">
									  <div class="d-flex flex-wrap align-items-ceter justify-content-center">
										  <div class="btn btn-primary mr-4" data-dismiss="modal">Cancel</div>
										  <button class="btn btn-outline-primary" type="submit">Create Application</button>
									  </div>
								  </div>
							  </div>
                          </div>
						  
						</form>
						
                      </div>
                  </div>
              </div>
          </div>
      </div>
						<script>
							$(document).ready(function(){
								$("#NewAPP").submit(function(e){
									e.preventDefault();
										$.ajax({
											url: "vendor/Models/NewApp.php",
											method: "post",
											data: $("#NewAPP").serialize(),
											dataType: "html",
											success: function(strMessage){
												$("#show_message").html(strMessage);
												$("#NewAPP")[0].reset();
											}
									});
								});
							});
						</script>
  <?php include "vendor/views/footer/footer.blade.php"; ?>