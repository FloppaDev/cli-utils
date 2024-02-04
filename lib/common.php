<?php

/**
 * Reads a single character from standard input.
 * https://stackoverflow.com/questions/3684367#answer-21628935
 */
function raw_read() {
    readline_callback_handler_install('', function() { });
    $ch = null;

    while (true) {
      $read = [STDIN];
      $write = null;
      $except = null;

      $n = stream_select($read, $write, $except, null);

      if ($n && in_array(STDIN, $read)) {
        return stream_get_contents(STDIN, 1);
      }
    }
}
