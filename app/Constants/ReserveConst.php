<?php

namespace app\Constants;

class ReserveConst
{
  const RESERVE_TIME = [
    '10:00:00',
    '10:30:00',
    '11:00:00',
    '11:30:00',
    '12:00:00',
    '12:30:00',
    '13:00:00',
    '13:30:00',
    '14:00:00',
    '14:30:00',
    '15:00:00',
    '15:30:00',
    '16:00:00',
    '16:30:00',
    '17:00:00',
    '17:30:00',
    '18:00:00',
    '18:30:00',
    '19:00:00',
    '19:30:00',
    '20:00:00',
  ];

  const CUT = 1;
  const CUT_SHAMPOO = 2;
  const CUT_SHAVING = 3;
  const CUT_SHAMPOO_SHAVING = 4;

  const CUT_NAME = 'カット';
  const CUT_SHAMPOO_NAME = 'カット＋シャンプー';
  const CUT_SHAVING_NAME = 'カット＋シェービング'	;
  const CUT_SHAMPOO_SHAVING_NAME = 'カット＋シャンプー＋シェービング';

  public const MENU_STATUS_ARRAY = [
    self::CUT,
    self::CUT_SHAMPOO,
    self::CUT_SHAVING,
    self::CUT_SHAMPOO_SHAVING,
];

}
