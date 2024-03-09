<?php

namespace PouchScanner\Domain;

enum RollStatus: string
{
    case NOT_INSPECTED = 'Not Inspected';

    case IN_PROGRESS = 'In Progress';

    case FINALIZED = 'Finalized';
}
