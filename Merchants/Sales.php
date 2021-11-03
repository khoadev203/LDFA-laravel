<?php include "vendor/views/header/header.blade.php"; ?>
<div class="content-page">
     <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Sales List</h4>
                        <p class="mb-0">View your all sales transactions here...!</p>
                    </div>
                    <a href="#" class="btn btn-primary add-list"><i class="fa fa-print mr-3"></i>Print</a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive rounded mb-3">
                <table class="data-table table mb-0 tbl-server-info">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Available On</th>
                            
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
						<?php 
							$GetSales = mysqli_query($ConClass, "SELECT * FROM `api_purchase` WHERE `user_id`='$Auth'");
							while($GS = mysqli_fetch_assoc($GetSales)){
						?>
                        <tr>
                            <td><div class="badge badge-success"><?php echo $GS['type']; ?></div></td>
                            <td>$ <?php echo $GS['amount']; ?></td>
                            <td><?php echo $GS['description']; ?></td>
                            <td><?php $Old = $GS['available']; echo date("H:i A (F d, Y) ", strtotime($Old)); ?></td>
                        </tr>
                        <?php
							}
						?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <!-- Page end  -->
    </div>
    <!-- Modal Edit -->
    
      </div>
    </div>
	
<?php include "vendor/views/footer/footer.blade.php"; ?>