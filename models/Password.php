<?php
/**
 * yii2-pluto
 * ----------
 * User management module for Yii2 framework
 * Version 1.0.0
 * Copyright (c) 2019
 * Sjaak Priester, Amsterdam
 * MIT License
 * https://github.com/wsidebottom/yii2-pluto
 */

namespace wsidebottom\pluto\models;

/**
 * Trait Password
 * @package wsidebottom\pluto\models
 */
trait Password
{
    public $password_repeat;

    public function passwordRules()
    {
        return in_array('double', $this->flags) ? [
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ] : [];
    }
}
