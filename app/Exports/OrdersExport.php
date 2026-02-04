<?php

namespace App\Exports;

use App\Models\OrderItem;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromQuery, Responsable, ShouldAutoSize, WithHeadings, WithMapping
{
    use Exportable;

    private string $fileName = 'orders.xlsx';

    public function query(): Builder
    {
        return OrderItem::query()->with(['order', 'product']);
    }

    /**
     * @param  OrderItem  $row
     */
    public function map($row): array
    {
        return [
            $row->order->name,
            $row->order->email,
            $row->order->phone,
            $row->product->name,
            $row->size,
            $row->color,
            $row->quantity,
            $row->order->payment_intent,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Product',
            'Size',
            'Color',
            'Quantity',
            'payment_intent',
        ];
    }
}
