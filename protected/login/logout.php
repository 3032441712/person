<?php
unset($_SESSION);
session_destroy();
header('Location:index.php?d=login');
exit(0);