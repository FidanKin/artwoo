<?php

namespace Source\Helper\Enums;

enum Crud: string
{
    case CREATE = 'c';
    case READ = 'r';
    case UPDATE = 'u';
    case DELETE = 'd';
}
