<?php

namespace App\Helpers\Utils;

class JsonView
{
    /*
     * data for getting data resource of api response
     * @var array|null
     */
    public $data;

    /**
     * code for getting code of api response
     * @var int
     */
    public $code;

    /**
     * message for getting message of api response
     * @var string
     */
    public $message;

    /**
     * @var array
     */
    public $errors;

    public $meta;

    public function __construct($data = null, $message = '', $code = 200, $errors = [], $meta = [])
    {
        $this->data = $data;
        $this->code = $code;
        $this->message = $message;
        $this->errors = $errors;
        $this->meta = $meta;
    }

    public function toArray()
    {
        return [
            'data'=>$this->data,
            'code'=>$this->code,
            'message'=>$this->message,
            'errors'=>$this->errors,
            'meta'=>$this->meta
        ];
    }
}
