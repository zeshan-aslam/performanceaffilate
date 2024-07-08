<section class="banner py-100">
            <div class="container">
                <div class="row">
                  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                <?php
                   $i=0;
                  // //  $count=$slider_rows;
                  //  echo $count;
                     while($row =mysqli_fetch_array($slider_result)){
                     if($i==0)
                       {
                     echo ' <button type="button" id="btn" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide1"></button>';
                     $i++;
                    }
                       else{
                         echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="'.$i.'" aria-label="Slide2"></button>';
                         $i=$i+1; 
                        //  echo $i;
                        }
                       
                     }
                   
                  ?>
    
                </div>
                <div class="carousel-inner">
                  <?php while($sliderrow = mysqli_fetch_array($slider_new)){
                   ?>
                  <div class="carousel-item">
                    <div class="row justify-content-center">
                      <div class="col-md-8">
                        <div class="text-center my-70">
                          <h1 class="text-responsive-h1 mb-3 slide-in-from-left aos-init aos-animate" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom"><?=ucwords($sliderrow["heading"])?></h1>
                          <div class="lead mb-5 description-bottom "><?=ucwords($sliderrow["description"])?></div>
                          <div class="banner-btn d-flex justify-content-center">
                            <a type="button" class="btn btn-banner bg-y me-4" href="<?=($sliderrow["href1"])?>"><?=ucwords($sliderrow["button1"])?></a>
                            <a type="button" class="btn btn-outline-banner" href="<?=($sliderrow["href2"])?>"><?=ucwords($sliderrow["button2"])?></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                   <?php }?>
                  <!-- <div class="carousel-item">
                    <div class="row justify-content-center">
                      <div class="col-md-8">
                        <div class="text-center my-70">
                          <h1 class="text-responsive-h1 mb-3 slide-in-from-left aos-init aos-animate" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">Merchants</h1>
                          <div class="lead mb-5 description-bottom ">Increase your sales/leads, NO Sign Up Fees, NO Monthly Fees<br>
                            ONLY 20% Override on affiliate payments, The RISK FREE Affiliate Network.
                            </div>
                          <div class="banner-btn d-flex justify-content-center">
                            <a type="button" class="btn btn-banner bg-y me-4" href="signup.php">Start for Free</a>
                           <a type="button" class="btn btn-outline-banner" href="#aboutus">Learn More</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> -->
                  <!-- <div class="carousel-item">
                    <div class="row justify-content-center">
                      <div class="col-md-8">
                        <div class="text-center my-70">
                          <h1 class="text-responsive-h1 mb-3 slide-in-from-left aos-init aos-animate" data-aos="fade-up" data-aos-anchor-placement="bottom-bottom">Affiliates</h1>
                          <div class="lead mb-5 description-bottom ">Generate income via your website traffic: Fastest payment times,<br>
                          Live Reports, Easy to use, Superb Tools.
                          </div>
                          <div class="banner-btn d-flex justify-content-center">
                            <a type="button" class="btn btn-banner bg-y me-4" href="signup.php">Start for Free</a>
                            <a type="button" class="btn btn-outline-banner" href="#aboutus">Learn More</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> -->
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
                </div>
            </div>
    </section>