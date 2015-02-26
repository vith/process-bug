#!/usr/bin/env php
<?php

include_once('vendor/autoload.php');

use Symfony\Component\Process\ProcessBuilder;

const TEST_FILE = 'vendor/twbs/bootstrap/dist/css/bootstrap.css';

function make_process($bin, array $args) {
    $processBuilder = new ProcessBuilder();
    $processBuilder->setPrefix($bin);

    foreach ($args as $arg) {
        $processBuilder->add($arg);
    }

    $process = $processBuilder->getProcess();

    return $process;
}

function check_success($process) {
    if (!$process->isSuccessful()) {
        throw new Exception("unsuccessful process");
    }
}

function get_expected_output($process) {
    if (file_exists('expected.out')) {
        throw new Exception("temp file 'expected.out' already exists");
    }

    $commandLine = $process->getCommandLine();
    $commandLine .= ' > expected.out';

    shell_exec($commandLine);

    $result = file_get_contents('expected.out');
    unlink('expected.out');

    return $result;
}

function check_output($process) {
    $output = $process->getOutput();
    $expectedOutput = get_expected_output($process);

    $outputBytes = strlen($output);
    $expectedOutputBytes = strlen($expectedOutput);

    if ($outputBytes < $expectedOutputBytes) {
        throw new Exception(sprintf("Process->run() output was truncated. Got %d bytes, expected %d", $outputBytes, $expectedOutputBytes));
    }

    if ($outputBytes > $expectedOutputBytes) {
        throw new Exception(sprintf("Process->run() returned too much data. Got %d bytes, expected %d", $outputBytes, $expectedOutputBytes));
    }

    if ($output !== $expectedOutput) {
        throw new Exception("Data mismatch");
    }
}

function cat_test() {
    $process = make_process('cat', [TEST_FILE]);
    $process->run();

    check_success($process);
    check_output($process);

    echo __FUNCTION__ . " OK" . PHP_EOL;
}

function slowcat_test() {
    $process = make_process('./slowcat.php', [TEST_FILE]);
    $process->run();

    check_success($process);
    check_output($process);

    echo __FUNCTION__ . " OK" . PHP_EOL;
}

function autoprefixer_test() {
    $process = make_process('./node_modules/.bin/autoprefixer', ['-o', '-', TEST_FILE]);
    $process->run();

    check_success($process);
    check_output($process);

    echo __FUNCTION__ . " OK" . PHP_EOL;
}

cat_test();
slowcat_test();
autoprefixer_test();
