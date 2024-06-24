<?php 

declare(strict_types=1);

namespace Src\Users\Enums;

enum DocumentTypeEnum: string 
{
    case CPF = 'cpf';
    case CNPJ = 'cnpj';
}