<?php

    // JSON encode the server's response, and quietly handle the case where the server has no response
    echo json_encode(
        (isset($response) ? $response : NULL
            )
    );
