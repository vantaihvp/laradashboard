<?php

namespace App\Enums;

enum ActionType: string
{
    case CREATED = 'created';
    case UPDATED = 'updated';
    case DELETED = 'deleted';
    case VIEWED = 'viewed';
    case EXPORTED = 'exported';
    case IMPORTED = 'imported';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case ASSIGNED = 'assigned';
    case UNASSIGNED = 'unassigned';
    case COMMENTED = 'commented';
    case ATTACHED = 'attached';
    case DETACHED = 'detached';
}