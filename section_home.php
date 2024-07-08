<?php
$msg = $_REQUEST['msg'];
?>
<section class="services py-80" id="services-sec">
  <div class="container">
    <div class="tradetracker-text text-center mb-60">
      <h2 class="trade-h2"><?= strtoupper($services_row["heading"]) ?></h2>
      <p class="trade-p"><?= ucwords($services_row["description"]) ?></p>
    </div>
    <div class="row justify-content-center">
      <?php while ($ser = mysqli_fetch_array($services_result)) {

      ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="marketing-card" data-aos="fade-right">
            <!-- <img src="newAssets/images/assets.png"> -->
            <img src="https://performanceaffiliate.com/Admin/public/testimg/<?=$ser["card_icon"] ?>">
            <h3 class="market-h3 mt-3 mb-2"><?= ucwords($ser["card_heading"]) ?></h3>
            <p class="market-p"><?= ucwords($ser["card_paragraph"]) ?></p>
          </div>
        </div>
      <?php } ?>
      <!-- <div class="col-lg-4 col-md-6 mb-4">
            <div class="marketing-card">
              <img src="newAssets/images/assets2.png">
              <h3 class="market-h3 mt-3 mb-2">Design Development</h3>
              <p class="market-p">We have Designers, Developers and Video Content
                Creators at our disposal. With many years of experience to
                ensure your program has the best chance of success!</p>
            </div>
          </div> -->
      <!-- <div class="col-lg-4 col-md-6 mb-4">
            <div class="marketing-card" data-aos="fade-left">
              <img src="newAssets/images/assets3.png">
              <h3 class="market-h3 mt-3 mb-2">Introduce Build</h3>
              <p class="market-p">With over 19 years industry experience, get your products
                introduced to top Affiliates and start building revenues
                TODAY!</p>
            </div>
          </div> -->
    </div>
  </div>
</section>
<section class="pelum-video-area" id="searlco-net">
  <div class="container">
    <div class="pelum-h2 text-center">
      <h2 class="common-h2"><?= ucwords($network_row["heading"]) ?><span class="accent"> <?= ucwords($network_row["highlight_text"]) ?> </span> <?= ucwords($network_row["remaining_heading"]) ?></h2>
      <p class=""><?= ucwords($network_row["description"]) ?></p>
    </div>
    <div class="row">
      <?php while ($searlco = mysqli_fetch_array($searlco_result)) {

      ?>
        <div class="col-lg-4 col-md-12 mb-5">
          <div class="video-box" data-aos="zoom-in">
            <div class="video-inn">
              <a class="popup-youtube" href="#">
                <i class="fas fa-chart-line"></i>
              </a>
              <h2><?= ucwords($searlco["heading"]) ?></h2>
              <span class="heading_overlay"></span>
              <p class="merchant-info"><?= ucwords($searlco["description"]) ?></p>
            </div>
          </div>
        </div>
      <?php } ?>
      <!-- <div class="col-lg-4 col-md-12 mb-5">
               <div class="video-box" data-aos="zoom-in">
                  <div class="video-inn">
                     <a class="popup-youtube" href="#">
                      <i class="fas fa-users"></i> 
                     </a>
                     <h2>Merchants</h2>
                     <span class="heading_overlay"></span>
                     <p class="merchant-info">When you join with Searlco Affiliate Network, you are associating yourself with the best in the industry. We have simple, easy-to-use online account management tools.
                      Number one goal is to provide the best customer service possible, and we are living up to that goal. Make your life easier and simpler: join Searlco Affiliate Network</p>
                  </div>
               </div>
            </div> -->


      <!--             
            <div class="col-lg-4 col-md-12 mb-5">
              <div class="video-box" data-aos="zoom-in">
                <div class="video-inn">
                   <a class="popup-youtube" href="#">
                    <i class="fas fa-chart-line"></i>
                   </a>
                   <h2>Affiliates</h2>
                   <span class="heading_overlay"></span>
                   <p class="merchant-info">When you sign up as an affiliate, you trust the best in the industry. We have the best systems and the best staff to support your needs. Our systems are always being updated to bring you better service, and our staff has continual training. Save time, money, and sanity: sign up with Searlco Affiliate Network. You will not regret it.</p>
                </div>
             </div>
            </div> -->
    </div>
  </div>
</section>


<section class="Features py-80" id="aboutus">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 ">
        <div class="features-wrp d-flex align-items-center h-100">
          <div class="fea">
            <h2 class="features-h2 mb-4"><?= ucwords($features_row["heading"]) ?> <span style="color:#f7931e;"><?= ucwords($features_row["highlight_heading"]) ?> </span></h2>
            <p class="features-p"><?= ucwords($features_row["description"]) ?> </p>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row">
          <?php while ($features = mysqli_fetch_array($features_result)) {
          ?>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4 pop">
              <div class="feture-info bg-light">
                <!--<div class="features-icon"><i class="fas fa-chart-line"></i></div>-->
                <a href="" class="pop_modal" data-bs-toggle="modal" data-bs-target="#myModal">
                  <div class="features-text">
                    <h3 class="c_title"><?= ucwords($features["heading"]) ?></h3>
                    <p class="d_desc"><?= ucwords($features["description"]) ?></p>
                  </div>
                </a>
              </div>
            </div>
          <?php } ?>
          
          <!-- <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <div class="feture-info bg-light">
              <div class="features-icon"><i class="far fa-money-bill-alt"></i></div>
              <a href="" class="pop_modal" data-bs-toggle="modal" data-bs-target="#myModal">
                <div class="features-text">
                  <h3 class="c_title">Automation</h3>
                  <p class="d_desc">Automated E-mail Message.</p>
                </div>
              </a>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</section>
<section class="as-standar py-80">
  <div class="container">
    <div class="row">
      <div class="col-lg-5 col-md-12 mb-4">
        <div class="as-standar-txt">
          <h3 class="as-standar-h3"><span class="bg-fece1a"><?=ucwords($stand_row["highlight_heading"]) ?></span>–<?=ucwords($stand_row["remaining_heading"]) ?></h3>
          <p class="as-standar-p"><?=ucwords($stand_row["description"]);?></p>
        </div>
      </div>
      <div class="col-lg-7 col-md-12">
        <div class="row">
        <?php while ($standard = mysqli_fetch_array($standard_result)) {
          ?>
          <div class="col-md-6 mb-4">
            <div class="as-standar-txt-card" data-aos="zoom-in">
              <h3 class="mb-3"><?=ucwords($standard["heading"]) ?></h3>
              <p><?=ucwords($standard["description"]) ?></p>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="trusted-By-Brands py-80">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="trusted-info text-center">
          <h2 class="trade-h2"><?=ucwords($trusted_row["heading"]) ?></h2>
			<?php $str=htmlspecialchars(ucwords($trusted_row["description"])); ?>
			
          <p class="trad-p">
			  <?php 
	 echo substr($str,0,40);
        echo '</br>';
      echo substr($str,40); ?></p>
          <div class="owl-carousel owl-theme">
          <?php while ($trusted = mysqli_fetch_array($trusted_result)) {
          ?>
            <div class="item">
              <div class="custom-item"> <img src="https://performanceaffiliate.com/Admin/public/testimg/<?=ucwords($trusted["card_icon"]) ?>" alt="l1"> </div>
            </div>
            <?php } ?>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="contact-form py-80" id="contactus">
  <div class="container">
    <div class="contact-info">
      <div class="contact-h3">CONTACT US</div>
      <h3 class=""><?=ucwords($contact_row["heading"]) ?></h3>
      <p><?=ucwords($contact_row["description"]) ?></p>
      <span class="heading_overlay"></span>
    </div>
    <div class="row">
      <div class="col-md-7">
        <form id="frmGetInTouch" method="post">
			   <div class="row">
			 <div class="col-12 col-md-12 mb-4 p-4"  id="divContactMessage" >
				
			</div>
			  </div>
          <div class="row">
            <div class="col-12 col-md-6 mb-4">
              <p>
			
                <input class="form-control" type="text" name="Name" placeholder="Name">
              </p>
            </div>
            <div class="col-12 col-md-6 mb-4">
              <p>
                <input class="form-control" type="text" name="Subject" placeholder="Subject">
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 mb-4">
              <p>
                <input class="form-control" type="email" name="Email" placeholder="E-mail">
              </p>
            </div>
            <div class="col-lg-6 mb-4">
              <p>
                <input class="form-control" type="tel" name="Phone" placeholder="Phone">
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 mb-4">
              <p>
                <textarea class="form-control" name="Message" placeholder="Your Message..."></textarea>
              </p>
            </div>
          </div>
			 <div class="row">
				  <div class="col-lg-12 mb-4">
			<div class="g-recaptcha" name="g-recaptcha-response" data-sitekey="6Le5c1IiAAAAAHxPwO5TPt_BCHqQ9g1vokiJBJFy"></div>
            </div>
          </div>
          
          <div class="row">
			  
            <div class="col-lg-12">
              <p>
                <button type="submit" class="pelum-btn mb-5">Send Message <span></span></button>
              </p>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-5">
        <div class="contact-info">
          <div class="single-contact-info wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.3s" style="visibility: visible;animation-duration: 2s;animation-delay: 0.3s;animation-name: fadeInUp;">
            <div class="contact-info-icon">
              <i class="fas fa-location-arrow"></i>
            </div>
            <div class="contact-info-text">
              <h3><?=ucwords($contact_row["address_heading"]) ?></h3>
              <p><?=ucwords($contact_row["address_desc"]) ?></p>
            </div>
          </div>
      
          <div class="single-contact-info wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.7s" style="visibility: visible; animation-duration: 2s; animation-delay: 0.7s; animation-name: fadeInUp;">
            <div class="contact-info-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="contact-info-text">
              <h3><?=ucwords($contact_row["email_heading"]) ?></h3>
              <p><?=ucwords($contact_row["email_address"]) ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>