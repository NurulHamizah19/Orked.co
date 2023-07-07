<?php
require 'vendor/autoload.php';

use Symfony\Component\Process\Process;

$sqlFile = 'file.sql';
$command = "php -r \"require 'Database/database.php'; use Database\Database; Database::migrate('$sqlFile');\"";
$process = Process::fromShellCommandline($command);
$process->run();

// Display the output
echo $process->getOutput();
