<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;

class AdminController extends Controller
{
    protected $productRepo;
    protected $orderRepo;
    protected $userRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        OrderRepositoryInterface $orderRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->productRepo = $productRepo;
        $this->orderRepo = $orderRepo;
        $this->userRepo = $userRepo;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totals = [
            'order_total' => $this->orderRepo->count(),
            'new_order_total' => $this->orderRepo->countNewOrder(),
            'product_total' => $this->productRepo->count(),
            'user_total' => $this->userRepo->count(),
        ];

        return view('admins.dashboard', [
            'totals_overview' => $totals,
        ]);
    }

    public function selectYearRevenue(Request $request)
    {
        if ($request->year1) {
            $chart_data = [];
            //lấy kết quả trả về một mảng
            $get = $this->orderRepo->getRevenueMonth($request->year1);
            $month = "";
            $revenue = "";
            $n = array_key_last($get);
            //kiểm tra tháng nào còn thiếu
            for ($i = 1; $i <= $n; $i++) {
                if (!array_key_exists($i, $get)) {
                    $get[$i] = 0;
                }
            }
            ksort($get);
            //Chuyển từ số sang tháng và nối chuỗi
            foreach ($get as $key => $val) {
                $monthName = date('F', mktime(0, 0, 0, $key, 10));
                $month .= '' . __($monthName) . ',';
                $revenue .= '' . $val . ',';
            }
            //Bỏ đi dấu phẩy ở cuối chuỗi
            $month = substr($month, 0, -1);
            $revenue = substr($revenue, 0, -1);
            $chart_data['month'] = $month;
            $chart_data['revenue'] = $revenue;

            return $chart_data;
        }
    }

    public function selectMonthOrder(Request $request)
    {
        $data = [];
        $totalOrder = "";
        $year = $request->year;
        $numberMonth = $request->month;
        $month = date("F", mktime(0, 0, 0, $numberMonth, 1));
        $nextNumberMonth = $request->month + 1;
        $nextMonth = date("F", mktime(0, 0, 0, $nextNumberMonth, 1));
        //Lấy ra các ngày thứ 2 trong tháng
        $firstDayOfWeek = new \DatePeriod(
            Carbon::parse("first monday of .$month. .$year."),
            CarbonInterval::week(),
            Carbon::parse("first monday of .$nextMonth. .$year.")
        );
        foreach ($firstDayOfWeek as $key => $val) {
            $data[$key] = $val . '';
        }
        for ($i = 0; $i < count($data); $i++) {
            if ($i == count($data) - 1) {
                $date = $data[$i];
                $date = strtotime($date);
                $date = strtotime("+7 day", $date);
                $date = date('Y-m-d 00:00:00', $date);
                $query = $this->orderRepo->getTotalOrdersWeekForMonth($data[$i], $date);
            } else {
                $query = $this->orderRepo->getTotalOrdersWeekForMonth($data[$i], $data[$i + 1]);
            }
            if (count($query) > 0) {
                $totalOrder .= '' . $query[0] . ',';
            } else {
                $totalOrder .= '' . count($query) . ',';
            }
        }
        //Bỏ đi dấu phẩy ở cuối chuỗi
        $totalOrder = substr($totalOrder, 0, -1);

        return $totalOrder;
    }
}
