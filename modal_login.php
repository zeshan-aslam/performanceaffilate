
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
                                <div id="divLoginMessage" class="error"></div>
                                <div class="form loginBox">
                                    <form id="frmLogin" method="post" action="/login" accept-charset="UTF-8">
                                        <select id="userType" class="form-control required" placeholder="User type" name="flag">
                                            <option value="">--Select User Type--</option>
                                            <option value="merchant">Merchant</option>
                                            <option value="affiliate">Affiliate</option>
                                        </select>
                                        <br/>

                                        <input id="username" class="form-control required" type="text" placeholder="Username" name="login">
                                        <input id="password" class="form-control required" type="password" placeholder="Password" name="password">
                                        <br/>
                                        <input class="btn btn-default btn-login" type="submit" value="Login" >

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
                            <span>Can't remember password? 
                                 <a class="js-scroll-trigger" href="javacript:void(0);">reset it.</a>
                            </span>
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

        
        
        
        