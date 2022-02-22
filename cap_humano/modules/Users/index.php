<?php
require '../../core/access_private.php';
ob_start();
require 'model.php';
require 'controller.php';
ob_end_clean();
