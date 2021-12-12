<?php

	$pageTitle = 'Restaurant Register';
	$headerTitle = 'Restaurant Register';
	include 'init.php';
?>
<section id="container">
			<div class="wrap-container clearfix">
				<div id="main-content">
					<div class="wrap-content zerogrid ">
						<article class="background-transparent" style="margin-top: 112px;margin-bottom: 15px;height: 100%;">
							<div class="art-header">
								<hr class="line-2">
								<h2><?php echo $headerTitle; ?></h2>
							</div>
							<div class="art-content">
								<div class="row">
									<div class=".form">
										<form name="form1"  method="" action="">
											<div class="row">
												<div class="col-1-3 offset-1-3">
													<div class="wrap-col">
														<input type="text" name="res_name" id="res_name" placeholder="Enter Restaurant name" required="required" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-1-3 offset-1-3">
													<div class="wrap-col">
														<input type="text" name="owner_name" id="owner_name" placeholder="Enter Owner name" required="required" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-1-3 offset-1-3">
													<div class="wrap-col">
														<input type="email" name="email" id="email" placeholder="Enter email" required="required" />
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-1-3 offset-1-3">
													<div class="wrap-col">
														<input type="text" name="phone" id="phone" placeholder="Enter phone" required="required" />
													</div>
												</div>
											</div>
											<div class="row">
                                                <div class="col-1-3 offset-1-3">
                                                    <div class="wrap-col">
														<textarea name="address" id="address" class="form-control" rows="6" required="required"
														placeholder="Enter Address"></textarea>                                                    
													</div>
                                                </div>
                                            </div>
											<div class="row">
                                                <div class="col-1-3 offset-1-3">
                                                    <div class="wrap-col">
														<textarea name="description" id="description" class="form-control" rows="7" required="required"
														placeholder="Enter Description about Restaurant"></textarea>                                                    
													</div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-1-3 offset-1-3">
                                                    <div class="wrap-col">
                                                        <input type="password" name="pass" id="password" placeholder="Enter Password" required="required" />
                                                    </div>
                                                </div>
                                            </div>
											<div class="row">
												<div class="col-1-3 offset-1-3">
													<div class="wrap-col">
														<input type="password" name="confirm_passowrd" id="password" placeholder="Enter password again" required="required" />
													</div>
												</div>
											</div>
                                            
                                            <div class="row">
                                                <div class="col-1-3 offset-1-3">
                                                    <div class="wrap-col">
											            <center><input class="submit" type="submit" name="Submit" value="Register"></center>
                                                    </div>
                                                </div>
                                            </div>

										</form>
									</div>
								</div>
							</div>
						</article>
					</div>
				</div>
			</div>
</section>
<?php
	include $tpl . 'footer.php'; 
?>