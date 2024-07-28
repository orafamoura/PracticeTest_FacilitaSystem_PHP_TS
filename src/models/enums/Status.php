<?php

namespace src\models\enums;

enum Status: string {
    case NaoIniciada = 'Nao iniciada';
    case EmProgresso = 'Em progresso';
    case Concluida = 'Concluida';
}
