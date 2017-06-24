<?php

namespace Opengento\Dontworry\Plugin\Block\Backend\Cache\Grid\Column;

class Statuses
{
    public function afterDecorateStatus($value, $result)
    {
        return '<span class="grid-severity-notice"><span>' . __('Everything is alright') . '</span></span>';
    }
}