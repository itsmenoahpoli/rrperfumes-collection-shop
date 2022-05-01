<?php

class HttpResponse
{
  function send($data, $httpStatusCode = 200) {
    http_response_code($httpStatusCode);
    
    echo json_encode($data);
  }
}