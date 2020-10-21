<?php

namespace App\Http\Requests;

use App\Exceptions\CustomValidationException;
use App\Helper\ResponseApi;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{

    public $responseApi;

    public function __construct(ResponseApi $responseApi, array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->responseApi = $responseApi;
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'seat_id' => 'required|exists:bus_seats,id',
            'start_station_id' => 'required|exists:stations,id',
            'end_station_id' => 'required|exists:stations,id'
        ];
    }

    /**
     * @param Validator $validator
     * @throws CustomValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new CustomValidationException($validator->errors(), $this->responseApi);
    }

}
