<?php

// Credit to the "PHP for Beginners" playlist by TeachMeComputer on YouTube: https://youtube.com/playlist?list=PLB62A1B486A575897
// print statement
echo "Hello, World!\n";


function print_date_and_time() {
    // display the today's day, current date, and time
    $date = date('m-d-y');
    $time = date('H-i-s');
    $day = date('l');

    echo "Today is $day. The current date and time are: $date $time.";
}

print_date_and_time();
?>
