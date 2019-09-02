<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function validateRequest($rules, $messages = []) 
    {
        if (request()->getMethod() == 'PATCH') 
        {
            $rules = $this->validationRulesForUpdate($rules);
        }
        return request()->validate($rules, $messages);
    }

    protected function validationRulesForUpdate($rules)
    {
        foreach ($rules as $key => $rule) {
            if (is_array($rule)) {
                array_unshift($rule, 'sometimes');
                $rules[$key] = $rule;
            } else {
                $rules[$key] = 'sometimes|' . $rule;
            }
        }
        return $rules;
    }
}
