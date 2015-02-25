#!/usr/bin/env php
<?php

const CHUNKS = 4;
const RUNTIME = 1; // seconds

if (count($argv) !== 2) {
    throw new \Exception("must pass a single argument: filename");
}

$filename = $argv[1];
$filesize = filesize($filename);
$chunkSize = ceil($filesize / CHUNKS);

$handle = fopen($filename, "r");

do {
    $chunk = fread($handle, $chunkSize);

    if (!feof($handle)) {
        usleep(RUNTIME/CHUNKS * 1E6);
    }

    echo $chunk;
} while (!feof($handle));

fclose($handle);
