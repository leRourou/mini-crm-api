<?php

namespace App\Trait;

trait ApiResourceConfigTrait
{
    public static function getStandardOperations(): array
    {
        return [
            'GET',
            'GET_COLLECTION',
            'POST',
            'PUT',
            'PATCH',
            'DELETE'
        ];
    }

    public static function getStandardPaginationConfig(): array
    {
        return [
            'paginationItemsPerPage' => 30,
            'paginationMaximumItemsPerPage' => 100,
            'paginationClientItemsPerPage' => true,
        ];
    }
}