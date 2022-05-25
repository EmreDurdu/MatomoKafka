<?php

namespace Piwik\Validators;

class ValidUrl extends BaseValidator
{
    public function validate($value)
    {

        console.log($value);
        $arr = explode(',', $value);
        foreach ($arr as $url) {
            console.log($url);
            if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
                throw new Exception('Invalid url: ' . $url);

            }
        }
    }
}