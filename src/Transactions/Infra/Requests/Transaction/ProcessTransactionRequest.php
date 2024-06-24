<?php

namespace Src\Transactions\Infra\Requests\Transaction;

use Illuminate\Auth\Events\Validated;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Src\Transactions\Application\Commands\ProcessTransaction\ProcessTransactionCommand;

class ProcessTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'required|numeric',
            'payer' => 'required|int',
            'payee' => 'required|int'
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => 'O campo value é obrigatório.',
            'value.numeric' => 'O campo value deve ser numerico.',
            'payer.required' => 'O campo payer é obrigatório.',
            'payer.int' => 'O campo payer deve ser um inteiro.',
            'payee.required' => 'O campo payee é obrigatório.',
            'payee.int' => 'O campo payee deve ser um inteiro.'
        ];
    }


    public function toCommand(): ProcessTransactionCommand
    {
        return new ProcessTransactionCommand(
            $this->value * 100,
            $this->payer,
            $this->payee
        );
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
