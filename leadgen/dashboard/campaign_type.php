<?php $postid = isset($_GET['cid']) ? $_GET['cid'] : -1; ?>
							
							 <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">                                   
                                    </p>
                                </div>
                                <div class="card-body all-icons">
                                    <div class="row">
                                        <div class="font-icon-list col-lg-8  ">
                                            <div class="font-icon-detail">
                                                <i class="nc-icon nc-zoom-split"></i>
                                                <a href="<?php echo LEADURL;?>index.php/?Act=standard&campid=<?=$postid?>"><b>Use our Standard template</b></a>
                                            </div>
                                        </div>                                   
                                        
                                    </div>
									<div class="row">
                                        <div class="font-icon-list col-lg-8 ">
                                            <div class="font-icon-detail">
                                                <i class="nc-icon nc-air-baloon"></i>
                                               <a href="<?php echo LEADURL;?>index.php/?Act=custom&campid=<?=$postid?>"><b>Use your own custom page design</b>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row">

					</div>
                   
                </div>
            </div>
