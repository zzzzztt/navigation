<?php

session_destroy();
echo "<script>alert('vous avez deconnexion')</script>";
header("refresh:0;url=homepage.html");
?>
