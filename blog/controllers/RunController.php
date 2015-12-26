<?php
namespace blog\controllers;

use blog\components\UrlService;
use blog\controllers\common\BaseController;
use common\models\health\HealthDay;
use common\models\health\HealthLog;

class RunController extends BaseController
{
    public function actionStep(){
        $type       = $this->get("type", "daily");
        $total_step = 0;

        $data_step = [];
        $x_cat     = [];

        if ($type == "monthly") {
            $avg        = 6000;
            $step       = 3;
            $total_days = 0;
            $date_to    = date("Ymd");
            $date_from  = date("Ymd", strtotime(' -30 day'));

            $step_list = HealthDay::find()
                ->where([">=", "date", $date_from])
                ->andWhere(["<=", "date", $date_to])
                ->orderBy("id asc")
                ->all();
            if ($step_list) {
                foreach ($step_list as $_one_step) {
                    $data_step[] = $_one_step["quantity"];
                    $x_cat[]     = (strtotime($_one_step['date']) + 8 * 3600) * 1000;
                    $total_days++;
                    $total_step += $_one_step["quantity"];
                }
            }
            $title     = '<span class="sub_title">步数<br/><span>日平均值：' . ceil($total_step / $total_days) . '</span></span>';
            $sub_title = '<span class="sub_title">' . number_format($total_step) . ' 步<br/><span>' . "{$date_from} ~ {$date_to}</span></span>";
        } else {
            $avg       = 40;
            $step      = 3;
            $date_to   = "";
            $date_from = "";

            $step_list = HealthLog::find()
                ->where(["date" => date("Ymd")])
                ->orderBy("id asc")
                ->all();
            if ($step_list) {
                $date_from = date("H:i", strtotime($step_list[0]['time_from']));
                foreach ($step_list as $_one_step) {
                    $data_step[] = $_one_step["quantity"];
                    $total_step += $_one_step["quantity"];

                    $x_cat[] = (strtotime($_one_step['time_from']) + 8 * 3600) * 1000;
                    $date_to = date("H:i", strtotime($_one_step['time_from']));
                }
            }
            $title     = '<span class="sub_title">步数<br/><span>小时平均值：' . ceil($total_step / date("H")) . '</span></span>';
            $sub_title = '<span class="sub_title">' . number_format($total_step) . ' 步<br/><span>' . "{$date_from} ~ {$date_to}</span></span>";
        }

        $data = [
            'data'      => $data_step,
            'x_cat'     => $x_cat,
            'avg'       => $avg,
            'step'      => $step,
            'title'     => $title,
            'sub_title' => $sub_title
        ];

        return $this->render("step", [
            'data' => json_encode($data),
            'type' => $type,
            'urls' => [
                "daily"   => UrlService::buildUrl("/run/step", ["type" => "daily"]),
                "monthly" => UrlService::buildUrl("/run/step", ["type" => "monthly"])
            ]
        ]);
    }

} 