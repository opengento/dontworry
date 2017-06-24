<?php

namespace Opengento\Dontworry\Plugin\Block\Indexer\Backend\Grid\Column\Renderer;

class Status
{
    public function afterRender(\Magento\Framework\DataObject $row)
    {
        $class = 'grid-severity-notice';
        $text = __('Don\'t worry');
        return '<span class="' . $class . '"><span>' . $text . '</span></span>';
    }
}