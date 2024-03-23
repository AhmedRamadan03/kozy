<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\StudentExam;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderExport  implements WithHeadings, WithStyles, FromQuery, WithColumnWidths, WithMapping

{

    use Exportable;


    protected $filiters;

     /**
     * @param $filiters
     * @return \Illuminate\Support\Collection
     */
    public function __construct($filiters)
    {
        $this->filiters = $filiters;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Order::latest();

        if (isset($this->filiters['country_id'])) {
            $query->where('country_id', $this->filiters['country_id']);
        }
        if (isset($this->filiters['datefilter'])) {
            $date = explode(' - ', $this->filiters['datefilter']);
                $startDate = date('Y-m-d', strtotime($date[0]));
                $endDate = date('Y-m-d', strtotime($date[1]));
                $query->whereBetween('created_at', [
                        $startDate,
                        $endDate,
                    ]);
        }

        if (isset($this->filiters['search']) && $this->filiters['search'] != null ) {
            $query->where('total', 'like', '%' . ltrim(request()->search, '#') . '%');
            $query->orWhere('name', 'like', '%' . ltrim(request()->search, '#') . '%');
            $query->orWhere('address', 'like', '%' . ltrim(request()->search, '#') . '%');
            $query->orWhere('ref', 'like', '%' . ltrim(request()->search, '#') . '%');

        }
        if (isset($this->filiters['status'])) {
            $query->where('status', $this->filiters['status']);

        }

        return $query;
    }


    public function map($order): array
    {
        $details = $order->details()
            ->selectRaw("CONCAT(quantity, ' x ', (select title from product_translations where locale = '" . app()->getLocale() . "' and product_translations.product_id = order_details.product_id)) as text")
            ->get()
            ->pluck('text')
            ->toArray();
        return [
            $order->ref,
            $order->name,
            json_decode($order->address)->name?? '',
            json_decode($order->address)->phone?? '',
            json_decode($order->address)->street?? '',
            json_decode($order->address)->district  ?? '',
            json_decode($order->address)->postal_code  ?? '',
            $order->total,
            $order->sub_total,
            $order->shipping,
            $order->tax,
            __('lang.order_status.'.$order->status),
            $order->country->title,
            $order->created_at,
            implode(" - " . PHP_EOL, $details),
        ];
    }

      /**
     * show head of table
     * @return array
     */
    public function headings(): array
    {
        return [
            'رقم الطلب',
            'اسم المستخدم',
            'اسم العميل',
            'رقم هاتف العميل',
            'العنوان',
            'المنطقة',
            'الرمز البريدي',
            'المجموع الكلي',
            'المجموع الفرعي',
            'الشحن',
            'الضريبة',
            'الحالة',
            'الدولة',
            'التاريخ',
            'المنتجات',
        ];
    }


    /**
     * styles of table
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['argb' => 'dcc861']],
            ],
        ];
    }


    public function columnWidths(): array
    {
        return [
            'A' => 18,
            'B' => 18,
            'C' => 18,
            'D' => 18,
            'E' => 70,
            'F' => 18,
            'G' => 18,
            'H' => 18,
            'I' => 20,
            'J' => 15,
            'K' => 22,
            'L' => 30,
            'M' => 30,
            'N' => 30,
            'O' => 50,
        ];
    }

}
