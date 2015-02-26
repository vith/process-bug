# Process Bug

When using [symfony/Process](https://github.com/symfony/Process) to run [postcss/autoprefixer](https://github.com/postcss/autoprefixer), the output gets truncated.

This only happens on Arch Linux.

It won't happen if you rebuild the nodejs package from ABS without `--shared-libuv` passed to `./configure`.

## Setup
```shell
git clone https://github.com/vith/process-bug.git
cd process-bug
composer install
npm install
```

## Run Test
```shell
./test.php
```

## Failure Output
```plain
cat_test OK
slowcat_test OK
PHP Fatal error:  Uncaught exception 'Exception' with message 'Process->run() output was truncated. Got 65536 bytes, expected 136967' in /home/jasonp/Software/process-bug/test.php:53
Stack trace:
#0 /home/jasonp/Software/process-bug/test.php(90): check_output(Object(Symfony\Component\Process\Process))
#1 /home/jasonp/Software/process-bug/test.php(97): autoprefixer_test()
#2 {main}
  thrown in /home/jasonp/Software/process-bug/test.php on line 53
```

## Success Output
```plain
cat_test OK
slowcat_test OK
autoprefixer_test OK
```
