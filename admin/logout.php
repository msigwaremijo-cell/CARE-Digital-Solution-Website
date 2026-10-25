<?php
declare(strict_types=1);

require __DIR__ . '/../src/bootstrap.php';

auth_logout();

redirect('login.php');
