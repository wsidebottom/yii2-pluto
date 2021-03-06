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

namespace wsidebottom\pluto\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use wsidebottom\pluto\Module;

class LoginMenu extends Widget
{
    /**
     * @var array HTML options for the dropdown
     */
    public $options = [];

    /**
     * @var array more items for the dropdown
     */
    public $extraItems = [];

    /**
     * @var string route to profile update
     */
    public $profileUpdate = '/profile/update';

    /**
     * @var string
     */
    public $userMaxWidth = '12em';

    /**
     * @throws InvalidConfigException
     */
    public function run()
    {
        $mod = Module::getInstance();
        $pluto = $mod->id;
        $user = Yii::$app->user;

        if ($user->isGuest) {
            return Html::tag('li', Html::a('Login', ["/$pluto/login"], ['class' => 'nav-link']), ['class' => 'nav-item']);
        }
        $liOptions = [
            'class' => 'dropdown nav-item',
        ];
        $aOptions = [
            'data-toggle' => 'dropdown',
            'class' => 'dropdown-toggle nav-link',
            'style' => "max-width:{$this->userMaxWidth};overflow:hidden;whitespace:nowrap;text-overflow:ellipsis;"
        ];

        $manageUsers = $user->can('manageUsers');
        $manageRoles = $user->can('manageRoles');

        $items = [
            [
                'label' => 'Settings',
                'url' => ["/$pluto/settings"],
            ],
            [
                'label' => 'Profile Settings',
                'url' => [$this->profileUpdate, 'id' => $user->id ],
                'visible' => ! is_null($mod->profileClass),
            ],
            '<div class="dropdown-divider"></div>',
            [
                'label' => 'Manage Users',
                'url' => ["/$pluto/user"],
                'visible' => $manageUsers,
            ],
            [
                'label' => 'Manage Roles',
                'url' => ["/$pluto/role"],
                'visible' => $manageRoles,
            ],
        ];
        if ($manageUsers || $manageRoles)   {
            $items[] = '<div class="dropdown-divider"></div>';
        }
        if (count($this->extraItems))   {
            $items = array_merge($items, $this->extraItems);
            $items[] = '<div class="dropdown-divider"></div>';
        }
        $items[] = [
            'label' => 'Logout',
            'url' => ["/$pluto/logout"],
            'linkOptions' => ['data-method' => 'post']
        ];

        $ddClass = 'yii\bootstrap4\Dropdown';
        $dropdown = $ddClass::widget([
            'items' => $items,
            'options' => $this->options
        ]);
        return Html::tag('li', Html::a(Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->lastname, '#', $aOptions) . $dropdown, $liOptions);
    }
}
