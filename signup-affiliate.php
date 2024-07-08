<?php

    require_once("includes/header.php");

?>

   

   <main id="home" role="main">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class=""></li>
          <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="2" class=""></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item">
            <img class="first-slide" src="assets/slides/slide-1.jpg" alt="First slide">
            <div class="container d-none">
              <div class="carousel-caption text-left">
                <h1>Example headline.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item active">
            <img class="second-slide" src="assets/slides/slide-2.jpg" alt="Second slide">
            <div class="container d-none">
              <div class="carousel-caption">
                <h1>Another example headline.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img class="third-slide" src="assets/slides/slide-3.jpg" alt="Third slide">
            <div class="container d-none">
              <div class="carousel-caption text-right">
                <h1>One more for good measure.</h1>
                <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
              </div>
            </div>
          </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>


      <!-- Marketing messaging and featurettes
      ================================================== -->
      <!-- Wrap the rest of the page in another container to center all the content. -->
      <div id="join-now" class="pt-5 pb-5">
        <!-- START THE FEATURETTES -->
        <div class="container">

          <div class="row featurette pb-5">
            <div class="col-12 col-md-8">
              <div class="signup-main">
                <h4>Sign Up as an Affiliate</h4> 
                <p class="mb-4">Sign up for free. Then place our offers on your website, email list or any other traffic source and start earning!</p>

                <form id="signup-affiliate" class="">
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="first_name">First Name</label> 
                    <div class="col-9">
                      <input id="first_name" name="first_name" placeholder="First Name" type="text" required="required" class="form-control here">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="last_name">Last Name</label> 
                    <div class="col-9">
                      <input id="last_name" name="last_name" placeholder="Last Name" type="text" required="required" class="form-control here">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="email">Email Address</label> 
                    <div class="col-9">
                      <input id="email" name="email" placeholder="Email Address" type="text" required="required" class="form-control here">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="phone">Phone</label> 
                    <div class="col-9">
                      <input id="phone" name="phone" placeholder="Phone" type="text" class="form-control here" required="required">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="fax">Fax</label> 
                    <div class="col-9">
                      <input id="fax" name="fax" placeholder="Fax" type="text" class="form-control here">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="company">Company</label> 
                    <div class="col-9">
                      <input id="company" name="company" placeholder="Company" type="text" class="form-control here" required="required">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="url">URL</label> 
                    <div class="col-9">
                      <input id="url" name="url" placeholder="URL" type="text" class="form-control here" required="required">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="address">Address</label> 
                    <div class="col-9">
                      <textarea id="address" name="address" cols="40" rows="3" class="form-control" required="required"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="country">Country</label> 
                    <div class="col-9">
                      <select id="country" name="country" class="custom-select" required="required">
                        <option value="rabbit">Rabbit</option>
                        <option value="duck">Duck</option>
                        <option value="fish">Fish</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="city">City</label> 
                    <div class="col-9">
                      <input id="city" name="city" placeholder="City" type="text" class="form-control here" required="required">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="state">State</label> 
                    <div class="col-9">
                      <input id="state" name="state" placeholder="State" type="text" class="form-control here" required="required">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="zip-code">Zip Code</label> 
                    <div class="col-9">
                      <input id="zip-code" name="zip-code" placeholder="Zip Code" type="text" class="form-control here" required="required">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="tax-id">Tax Id</label> 
                    <div class="col-9">
                      <input id="tax-id" name="tax-id" placeholder="Tax Id" type="text" class="form-control here" required="required">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="timezone">TimeZone</label> 
                    <div class="col-9">
                      <select id="timezone" name="timezone" class="custom-select" required="required">
                        <option value="rabbit">Rabbit</option>
                        <option value="duck">Duck</option>
                        <option value="fish">Fish</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-3 col-form-label" for="category">Category</label> 
                    <div class="col-9">
                      <select id="category" name="category" class="custom-select" required="required">
                        <option value="rabbit">---Select a category---</option>
                        <option value="duck">Duck</option>
                        <option value="fish">Fish</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="paymet-method" class="col-3 col-form-label">Mode of Payment</label> 
                    <div class="col-9">
                      <select id="paymet-method" name="paymet-method" class="custom-select" aria-describedby="paymet-methodHelpBlock" required="required">
                        <option value="rabbit">Paypal</option>
                        <option value="duck">CheckbyMail</option>
                      </select> 
                      <span id="paymet-methodHelpBlock" class="form-text text-muted">* All Fields Are Required</span>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-3"></div> 
                    <div class="col-9">
                      <label class="custom-control custom-checkbox">
                        <input name="checkbox" type="checkbox" class="" value="" required="required"> 
                        <span class="custom-control-description">Click here to indicate that you have read and agree to the User Agreement and Privacy Policy.</span>
                      </label>
                    </div>
                  </div> 
                  <div class="form-group row">
                    <div class="offset-3 col-9">
                      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>

            </div>
            <div class="col-12 col-md-4">
              <div class="signup-sidebar">
                <h4>WHY JOIN?</h4> 
                  <ul class="mt-3">
                    <li>Feature reason 1</li>
                    <li>Feature reason 2</li>
                    <li>Feature reason 3</li>
                    <li>Feature reason 4</li>
                    <li>Feature reason 5</li>
                    <li>Feature reason 6</li>
                    <li>Feature reason 7</li>
                    <li>Feature reason 8</li>
                  </ul>
              </div>
            </div>
          </div>
        </div>
      </div>


      <section id="contact-us" class="contact-area section-big">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center">
              <div class="section-title mb-60">
                <h2 class="featurette-heading f-neuton">Get in touch</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
              </div>
            </div>
          </div>
        </div>
        
          <!--CONTACT Us starts-->
        <div class="map-contact-area">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                
                <div class="contact-form">
                  <!-- Submition status -->
                  <div id="form-messages"></div>
                  <form id="ajax-contact" action="" method="post">
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group in_name">
                          <input type="text" name="name" class="form-control" id="name" placeholder="Name" required="required">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group in_email">
                          <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" required="required">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group in_email">
                          <input type="text" name="location" class="form-control" id="location" placeholder="Location" required="required">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group in_email">
                          <input type="text" name="address" class="form-control" id="address" placeholder="Address" required="required">
                        </div>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group in_message"> 
                          <textarea name="message" class="form-control" id="message" rows="5" placeholder="Message" required="required"></textarea>
                        </div>
                        <div class="actions text-center">
                          <input type="submit" value="Send Message" name="submit" id="contactSubmitButton" class="btn small" title="Submit Your Message!">
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              <!-- Contact form ends-->

              </div>
            </div>
          </div>
        </div>
        <!-- CONTACT Us ends-->

      
      </section>

      <!-- FOOTER -->
        <footer id="siteFooter">
            <div class="container">
                <p class="float-right"> 
                    <a href="#">Privacy</a> | <a href="#">Terms</a>
                </p>
                <p>&copy; 2018 Avaz Affiliate Network, All Right Reserved.</p>
             </div>
        </footer>


        <div class="modal fade login" id="loginModal">
          <div class="modal-dialog login animated">
              <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title">Sign in</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                    <div class="modal-body">  
                        <div class="box">
                             <div class="content">
                                <div class="error"></div>
                                <div class="form loginBox">
                                    <form method="post" action="/login" accept-charset="UTF-8">
                                    <select id="userType" class="form-control" placeholder="User type" name="userType">
                                      <option value="">--Select User Type--</option>
                                      <option value="Merchant">Merchant</option>
                                      <option value="Affiliate">Affiliate</option>
                                    </select>
                                    <br/>

                                    <input id="username" class="form-control" type="text" placeholder="Username" name="username">
                                    <input id="password" class="form-control" type="password" placeholder="Password" name="password">
                                    <br/>
                                    <input class="btn btn-default btn-login" type="button" value="Login" onclick="loginAjax()">
                                    </form>
                                </div>
                             </div>
                        </div>
                        <div class="box">
                            <div class="content registerBox" style="display:none;">
                             <div class="form">
                                <form method="post" html="{:multipart=>true}" data-remote="true" action="/register" accept-charset="UTF-8">
                                <input id="reg_username" class="form-control" type="text" placeholder="Email" name="reg_username">
                                <input id="reg_password" class="form-control" type="password" placeholder="Password" name="reg_password">
                                <input id="password_confirmation" class="form-control" type="password" placeholder="Repeat Password" name="password_confirmation">
                                <input class="btn btn-default btn-register" type="submit" value="Create account" name="commit">
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="forgot login-footer">
                            <span>Looking to 
                                 <a class="js-scroll-trigger" href="#join-now" onclick="showRegisterForm();">create an account</a>
                            ?</span>
                        </div>
                        <div class="forgot register-footer" style="display:none">
                             <span>Already have an account?</span>
                             <a href="javascript: showLoginForm();">Login</a>
                        </div>
                    </div>        
              </div>
          </div>
      </div>


    </main>
    
<?php

    require_once("includes/footer.php");

?>