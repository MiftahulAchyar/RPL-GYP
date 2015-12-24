<?php
// seed with microseconds
function make_seed()
{
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}
srand(make_seed());
$randval = (int)(rand()%2+3);

?>