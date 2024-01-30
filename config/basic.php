<?php 
return [
    "currency" => "NGN",
    "c_s" => "&#8358;",
    "date" => function ($date) {
        return date('jS \of F Y h:i:s A', strtotime($date));
    },
];