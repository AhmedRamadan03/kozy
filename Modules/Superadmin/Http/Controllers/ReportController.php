<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\ActivityLog;
use App\Models\Admin;
use App\Models\Exam;
use App\Models\Group;
use App\Models\Level;
use App\Models\Order;
use App\Models\Product;
use App\Models\StudentExam;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{


    public function orders()
    {

        return view("superadmin::reports.orders-report", [
            'data' =>Order::forDrobDown()->filter()->latest()->paginate(20),
        ]);
    }
    public function statistics()
    {
        $result = $this->statisticsReport();

        return view("superadmin::reports.statisticsReport", [
            'data' => $result['orders_count'],
            'total' => $result['total'],
        ]);
    }


    public function productsReport()
    {

        return view("superadmin::reports.products-report", [
            'data' => Product::forDrobDown()->filter()->latest()->paginate(20),
        ]);
    }

    public function export()
    {
        $filiters = request()->except('_token');
        return Excel::download(new OrderExport($filiters), 'تقرير_الطلبات.xlsx');
    }

    public function trendingProducts() {
        $data = $this->trendingReport(request()->product_id);
        return view("superadmin::reports.trendingProducts", compact("data"));
    }


    public function activityLogs(Request $request) {
        $query = ActivityLog::latest();

        if($request->log_name){
            $query->where('log_name', $request->log_name);
        }
        if($request->page){
            $query->where('subject_type', $request->page);
        }
        if($request->causer_id){
            $query->where('causer_id', $request->causer_id);
        }

        request()->whenFilled('datefilter', function () use ($query) {
            $date = explode(' - ', request()->datefilter);
            $startDate = date('Y-m-d', strtotime($date[0]));
            $endDate = date('Y-m-d', strtotime($date[1]));
            $query->whereBetween('created_at', [
                $startDate,
                $endDate
            ]);
        });

        $data = $query->paginate(100);

        $logNames = DB::table('activity_log')->distinct()->pluck('log_name');
        $pages = DB::table('activity_log')->distinct()->pluck('subject_type');
        $admins = Admin::forDropDown()->pluck('username', 'id');
        return view("superadmin::reports.activityLogs", compact("data" , 'logNames','pages','admins'));
    }


    /**
     * return quantity and sales of products
     *
     */
    private  function statisticsReport()
    {
        $orders = [];
        $statuses = (new Order())->statuses();

        foreach ($statuses as $status) {
            $orders[$status] = $this->getCountOfOrders($status);
        }

        $resutl['orders_count'] = $orders;
        if (auth()->user()->show_all ==0 ) {
            $resutl['total'] = Order::where('country_id',auth()->user()->country_id)->sum('total');
        }else{

            $resutl['total'] = Order::sum('total');
        }

        return $resutl;
    }

    private  function getCountOfOrders($status)
    {
        $data = [];
        if (auth()->user()->show_all ==0 ) {
            $query = Order::where('country_id',auth()->user()->country_id);
        }else{
            $query = Order::query();
        }
        $data['count'] = $query->where('status', $status)->count();
        $data['total'] = $query->where('status', $status)->sum('total');
        $data['status'] = $status;
        return $data;
    }


    private function trendingReport()
    {
        return Product::forDrobDown()->filter()
            ->select(
                "id",
                'sku',
                'country_id',
                DB::raw('(select sum(quantity) from order_details where order_details.product_id = products.id) as sale_quantity'),
                DB::raw('(select sum(quantity * cost) from order_details where order_details.product_id = products.id) as sale_cost')
            )
            ->orderBy(
                DB::raw('(select sum(quantity) from order_details where order_details.product_id = products.id)'),
                'desc'
            )
            ->having("sale_quantity", ">", 0)
            ->paginate(60);
    }
}
