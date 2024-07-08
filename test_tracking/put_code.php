<?php
error_reporting(E_ERROR | E_PARSE);
if (isset($_POST['submit'])) {
    $name = $_POST['code'];
    $response ='Tracking code send and save amount value in database successfully';
    $display='<div class="bg-secondary p-2 text-center">
    <h5 class="text-light">'.$response.'</h5> 
	
    </div>
	<div class="text-center">
	<a href="report.php" class="btn btn-primary ">Check Update Value</a>
	</div>';
}
?>
<html>

<head>
    <title>tracking system code</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            
            <div class="col-md-3"></div>
            <div class="col-md-6 mt-5">
                <center>
                <h2 class="bg-info p-2 mb-2 text-light">   Confirmation Page   </h2> 
                    <form action="#" method="post">
                        <label>Put Code Here</label>
                        <textarea name="code" id="code" cols="70" rows="2">
                       </textarea><br>
                    <button type="submit" name="submit" class="btn btn-primary mt-2">Test</button>
                    </form>
                </center>
                <?php echo $name; ?>
               <?php echo $display;?>
              
                </div>
            <img src="https://searlco.net/trackingcode_lead.php?mid=1&amp;sec_id=M_19cP0aE4gQ8nM&amp;orderId=23944159&amp;tid={tid}&amp;productids={productids}&amp;postage={postage}&amp;taxcosts={taxcost}&amp;cartid={cartid}&amp;auid={auid}&amp;trafficsource={trafficsource}&amp;keyword={keyword}" height="1" width="1" alt="">
            </div>
        </div>
       
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</html>