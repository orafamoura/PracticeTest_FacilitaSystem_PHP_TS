<?php

namespace src\models\enums;

enum Status: string
{
    case NAOINICIADA = 'NAOINICIADA';
    case EMPROGRESSO = 'EMPROGRESSO';
    case CONCLUIDA = 'CONCLUIDA';
}
