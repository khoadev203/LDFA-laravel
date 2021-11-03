						<?php 
							session_start();
							include "../auth/auth.config.php";
							$Auth = $_POST['Auth'];
							$appid = $_POST['appid'];
							$GetApis = mysqli_query($ConClass, "SELECT * FROM `merchants` WHERE `APP_ID`='$appid' AND `user_id`='$Auth'"); 
							$GAPI = mysqli_fetch_assoc($GetApis);
						?>
						<tr>
                            
                            <td><?php echo $appid; ?></td>
                            <td><?php echo $GAPI['Publish_Key']; ?></td>
                            <td>
								<div class="sckey" id="sekey"><?php echo $GAPI['merchant_key']; ?></div>
								<button class="btn btn-primary" id="reveal">Reveal Key</button>
							</td>
                            
                            </td>
                        </tr>
						<script>
						$(document).ready(function(){
							$("#reveal").click(function(){
								$("#sekey").addClass("sckeyrel");
								$("#reveal").hide();
							});
						});
					  </script>