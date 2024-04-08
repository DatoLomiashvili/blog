<?php

namespace App\Request;

use App\Rules\CryptoCoinValidation;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

class TradingBotRequest extends FormRequest
{
    /**
     * @return string[]
     * @throws Exception
     */
    public function rules(): array
    {
        return [
            'crypto_coin' => ['nullable', 'string', new CryptoCoinValidation()],
            'low_moving_average' => 'nullable|integer',
            'high_moving_average' => 'nullable|string',
        ];
    }
}
