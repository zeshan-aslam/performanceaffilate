
<?php
echo "<h1>Screen Resolution:</h1>";
echo "Width  : ".$_GET['width']."<br>";
echo "Height : ".$_GET['height']."<br>";
?>
<script type="text/javascript">

width = screen.width;
height = screen.height;

if (width > 0 && height >0) {
    window.location.href = "https://avaz.co.uk/leadgen/dataget.php?width=" + width + "&height=" + height;
} else 
    exit();

</script>

