<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ReChaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response=Http::get("https://www.google.com/recaptcha/api/siteverify",[
            "secret"=>env('CAPTCHA_SECRET'),
            "response"=>$value
        ])->json();
        if(!$response['success']){
            $fail("the google recaptcha not value");
        }

    }
}
