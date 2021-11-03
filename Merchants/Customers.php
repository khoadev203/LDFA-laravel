<?php include "vendor/views/header/header.blade.php"; ?>
<div class="content-page">
     <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="mb-3">Customer List</h4>
                        <p class="mb-0">A customer dashboard lets you easily gather and visualize customer data from optimizing <br>
                         the customer experience, ensuring customer retention. </p>
                    </div>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone No.</th>
                            <th>Country</th>
                            <th>Order</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        <?php
							$GetCustomers = mysqli_query($ConClass, "SELECT ");
						?>
                        <tr>
                            <td>
                                <div class="checkbox d-inline-block">
                                    <input type="checkbox" class="checkbox-input" id="checkbox10">
                                    <label for="checkbox10" class="mb-0"></label>
                                </div>
                            </td>
                            <td>Paige Turner</td>
                            <td><a href="http://iqonic.design/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="394958505e5c795e54585055175a5654">[email&#160;protected]</a></td>
                            <td>0125856789</td>
                            <td>UK</td>
                            <td>9</td>
                            
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <!-- Page end  -->
    </div>
    
      </div>
    </div>
<?php include "vendor/views/footer/footer.blade.php"; ?>