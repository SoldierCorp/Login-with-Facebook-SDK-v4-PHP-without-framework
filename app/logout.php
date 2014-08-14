<?php
session_start();

unset($_SESSION['facebook']);
header('Location: ../index.php');