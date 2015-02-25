#Process Bug

For reasons unknown to me, when using [symfony/Process](https://github.com/symfony/Process) to run [postcss/autoprefixer](https://github.com/postcss/autoprefixer), the output gets truncated.

```
./test.php                                                                             ◼
cat_test OK
slowcat_test OK
PHP Fatal error:  Uncaught exception 'Exception' with message 'Process->run() output was truncated. Got 65536 bytes, expected 136967' in /home/jasonp/Software/process-bug/test.php:53
Stack trace:
#0 /home/jasonp/Software/process-bug/test.php(90): check_output(Object(Symfony\Component\Process\Process))
#1 /home/jasonp/Software/process-bug/test.php(97): autoprefixer_test()
#2 {main}
  thrown in /home/jasonp/Software/process-bug/test.php on line 53
```
