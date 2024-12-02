<?php

namespace App\Enumerators;


class UsersEnumerator
{
    public const USER_ROLE_ADMINISTRATOR = 1;
    public const USER_ROLE_CUSTOMER = 2;
    public const USER_ROLE_EXECUTOR = 3;


    public static function getTypes()
    {
        return [
            self::USER_ROLE_ADMINISTRATOR => 'Администратор',
            self::USER_ROLE_CUSTOMER => 'Заказчик',
            self::USER_ROLE_EXECUTOR => 'Исполнитель',
        ];
    }
}
