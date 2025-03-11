<?php

namespace formhandeling\controllers;

require_once __DIR__ . '/../models/users.php';
session_unset();
session_destroy();
header("Location: ../views/dashboard.php");
