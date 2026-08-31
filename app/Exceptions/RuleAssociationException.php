<?php

namespace App\Exceptions;

use Exception;

class RuleAssociationException extends Exception
{
    public function __construct(string $message = 'Não é possível deletar o registro pois há registros associados')
    {
        parent::__construct($message);
    }

    public function render()
    {
        return response()->json([
            'message' => $this->getMessage()
        ], 400);
    }
}
