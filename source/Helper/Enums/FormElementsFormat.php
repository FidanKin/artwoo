<?php

namespace Source\Helper\Enums;

enum FormElementsFormat: string
{
    case TEXT = 'text';
    case DATE = 'date';
    case SELECT = 'select';
    case CHECKBOX = 'checkbox';
    case MULTISELECT = 'multiselect';
    case FILE = 'file';
    case AUTOCOMPLETE = 'autocomplete';
}
