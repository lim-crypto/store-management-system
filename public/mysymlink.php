<?php
$targetFolder =  '/home/u993972610/domains/premiumkennel.online/pet_reservation/storage/app/public';
$linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
symlink($targetFolder,$linkFolder);
echo 'success';