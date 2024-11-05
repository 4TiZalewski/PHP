<?php

function db_name() {
    if (file_exists("../test-teacher-DEFINITLY-THERE-WILL-NOT-BE-DUPLICATE.php")) {
        return "5ti_gr1_mecze2";
    } else {
        return "5ti_g1_mecze2";
    }
}

function get_connection() {
    return mysqli_connect("127.0.0.1", "root", "", db_name());
}