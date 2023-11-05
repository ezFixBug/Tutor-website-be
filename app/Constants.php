<?php

namespace App;

class Constants
{
    public const CD_ROLE_STUDENT = 1;
    public const CD_ROLE_TUTOR = 2;

    //admin approved become to tutor
    public const CD_APPROVED = 1;
    //waiting admin approve become to tutor
    public const CD_IN_PROGRESS = 2;
    //admin block user
    public const CD_BLOCKED = 3;

    public const CD_TYPE_OFFLINE = 1;
    public const CD_TYPE_ONLINE = 2;

    public const CD_MAN = 1;
    public const CD_WOMAN = 2;

    //waiting admin accept
    public const CD_WAITING_TO_ACCEPT = 1;
    //admin accept course
    public const CD_ACCEPT= 2;
    //admin REJECT course
    public const CD_REJECT = 3;

    public const CD_FREE = 1;
    public const CD_CHARGES = 2;

    public const CD_OFFER_REQUEST_DEFAULT = 1;
    public const CD_OFFER_REQUEST_APPROVE = 2;

}