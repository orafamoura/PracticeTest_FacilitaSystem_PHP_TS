<?php

namespace src\models\enums;

enum Status: string {
    case Pendente = 'Pendente';
    case EmProgresso = 'Em progresso';
    case Concluida = 'Concluida';
}
