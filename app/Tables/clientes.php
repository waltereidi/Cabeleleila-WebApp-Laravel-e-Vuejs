<?php

namespace App\Tables;


use Okipa\LaravelTable\Table;
use Okipa\LaravelTable\Abstracts\AbstractTableConfiguration;


class clientes extends AbstractTableConfiguration
{
    protected function table(): Table
    {
        return Table::make()->model(Clientes::class);
    }
    protected function columns(): array
    {
        return [
            // The table columns configuration.
        ];
    }

    protected function results(): array
    {
        return [
            // The table results configuration.
            // As results are optional on tables, you may delete this method if you do not use it.
        ];
    }
}
