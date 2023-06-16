<?php

namespace App\Http\Responses;

use JsonSerializable;

class AbstractResponse implements JsonSerializable
{
    protected $success;
    protected $message;
    protected $data;
    protected $code;

    /**
     * AbstractResponse constructor.
     *
     * @param string $message
     * @param null $data
     * @param int|null $code
     */
    public function __construct(string $message, $data = null, int $code = 200)
    {
        $this->message = $message;
        $this->data = $data;
        $this->code = $code;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize() : array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'code' => $this->code,
            'data' => $this->data
        ];
    }

    public function getCode() : int
    {
        return $this->code;
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function response()
    {
        return response()->json($this->jsonSerialize(), $this->code);
    }
}
