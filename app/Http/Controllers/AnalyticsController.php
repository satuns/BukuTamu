<?php

namespace App\Http\Controllers;

use App\Models\CategoryDescription;
use App\Models\Guest;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnalyticsController extends Controller
{

    public function index()
    {
        return view('analytics');
    }

    public function categoryAnalytics(Request $request, $group_by)
    {
        $validator = Validator::make($request->all(), [
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], 400);
        }

        if ($group_by == 'daily') {
            return $this->dailyCategoryAnalysis($request);
        } else if ($group_by == 'weekly') {
            return $this->weeklyCategoryAnalysis($request);
        } else if ($group_by == 'monthly') {
            return $this->monthlyCategoryAnalysis($request);
        }
    }

    public function dailyCategoryAnalysis(Request $request)
    {
        $start_date = $request->start;
        $end_date = $request->end;

        $data = [];
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));

        $days = $this->getDays($start_date, $end_date);

        $categoryDistinct = $this->getDistinctCategory($start_date, $end_date);


        foreach ($categoryDistinct as $category) {
            $categoryData = [];
            foreach ($days as $day) {
                $categoryData[] = Guest::where('description_id', $category->description_id)
                    ->whereDate('created_at', $day)
                    ->count();
            }

            $data[] = [
                'name' => CategoryDescription::find($category->description_id)->name ?? "Undefined Category",
                'data' => $categoryData
            ];
        }

        return response()->json([
            'status' => true,
            'data' => [
                'label' => $days,
                'data' => $data
            ]
        ], 200);
    }

    public function weeklyCategoryAnalysis($request)
    {
        $data = [];

        $start_date = date('Y-m-d', strtotime($request->start));
        $end_date = date('Y-m-d', strtotime($request->end));

        $weeks = $this->getWeeks($start_date, $end_date);
        $categoryDistinct = $this->getDistinctCategory($start_date, $end_date);

        foreach ($categoryDistinct as $category) {
            $categoryData = [];


            for ($i = 0; $i < count($weeks); $i++) {

                $start_week = $weeks[$i];
                $end_week = date('Y-m-d', strtotime("+6 day", strtotime($start_week)));

                $categoryData[$weeks[$i]] = Guest::where('description_id', $category->description_id)
                    ->whereBetween('created_at', [$start_week, $end_week])
                    ->count();
            }

            $data[] = [
                'name' => CategoryDescription::find($category->description_id)->name ?? "Undefined Category",
                'data' => $categoryData
            ];
        }

        return response()->json([
            'status' => true,
            'data' => [
                'label' => $weeks,
                'data' => $data
            ]
        ], 200);
    }

    public function monthlyCategoryAnalysis($request)
    {
        $data = [];

        $start_date = date('Y-m-d', strtotime($request->start));
        $end_date = date('Y-m-d', strtotime($request->end));

        $months = $this->getMonths($start_date, $end_date);
        
        $categoryDistinct = $this->getDistinctCategory($start_date, $end_date);

        foreach ($categoryDistinct as $category) {
            $categoryData = [];

            for ($i = 0; $i < count($months); $i++) {

                $start_month = $months[$i];
                $end_month = date('Y-m-d', strtotime("+1 month", strtotime($start_month)));

                $categoryData[$months[$i]] = Guest::where('description_id', $category->description_id)
                    ->whereBetween('created_at', [$start_month, $end_month])
                    ->count();
            }

            $data[] = [
                'name' => CategoryDescription::find($category->description_id)->name ?? "Undefined Category",
                'data' => $categoryData
            ];
        }


        return response()->json([
            'status' => true,
            'data' => [
                'label' => $months,
                'data' => $data
            ]
        ], 200);
    }

    public function getDistinctCategory($start_date, $end_date)
    {
        $start_date = date('Y-m-d 00:00:00', strtotime($start_date));
        $end_date = date('Y-m-d 23:59:59', strtotime($end_date));

        return Guest::select('description_id')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('description_id')
            ->get();
    }


    public function getMonths($start_date, $end_date)
    {
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($start, $interval, $end);

        $months = [];
        foreach ($period as $dt) {
            $months[] = $dt->format("Y-m-d");
        }

        return $months;
    }

    public function getWeeks($start_date, $end_date)
    {
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $interval = new DateInterval('P1W');
        $period = new DatePeriod($start, $interval, $end);

        $weeks = [];
        foreach ($period as $dt) {
            $weeks[] = $dt->format("Y-m-d");
        }

        return $weeks;
    }

    public function getDays($startDate, $endDate)
    {
        $days = array();
        $current = strtotime($startDate);
        $end = strtotime($endDate);

        while ($current <= $end) {
            $days[] = date('Y-m-d', $current);
            if (date('N', $current) < 5) {
                $current = strtotime('+1 day', $current);
            } else {
                $current = strtotime('+3 day', $current);
            }
        }

        return $days;
    }
}
