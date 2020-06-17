<?php

require_once 'models/user.dao.php';

echo password_hash("joueur",PASSWORD_DEFAULT);

echo '<pre>';
var_dump(getAllInfosUserByEmail("elhadjibabacarsene@gmail.com"));