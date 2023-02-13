<?php
exit;
require_once('../config.php');
$sql = "CREATE TABLE IF NOT EXISTS `Table_Admin`(
        `Admin_ID` INT(10) NOT NULL AUTO_INCREMENT,
        `Admin_Email` VARCHAR(150) COLLATE utf8_general_ci NOT NULL,
        `Admin_Password` VARCHAR(200) COLLATE utf8_general_ci NOT NULL,
        `Admin_Date` DATETIME NOT NULL,
        `Admin_Update` DATETIME NOT NULL,
        PRIMARY KEY(`Admin_ID`)
)";
// On exécute la requête
$db->exec($sql);
echo 'Database Table_Admin créée<br />';
$admin = $db->prepare('INSERT INTO `Table_Admin` SET
                Admin_Email = :email,
                Admin_Password = :password,
                Admin_Date = NOW(),
                Admin_Update = NOW()
        ');
$admin->bindValue(':email','florian.mancieri@campuscci18.fr',PDO::PARAM_STR);
$admin->bindValue(':password',sha1(md5('cci18000')),PDO::PARAM_STR); 
$admin->execute();
echo 'Utilisateur créé avec succès<br />';       
?>