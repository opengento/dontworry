<?php

namespace Opengento\Dontworry\Plugin\Block\Indexer\Backend\Grid\Column\Renderer;

class Scheduler
{
    public function afterRender(\Magento\Framework\DataObject $row)
    {

        $class = 'grid-severity-notice';
        $text = __('Always up to date');
        return '<span class="' . $class . '"><span>' . $text . '</span></span>';

    }
}