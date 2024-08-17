<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RaspberryPiStatsController extends Controller
{
    public function index()
    {
        $stats = [
            'cpu_temp' => $this->getCpuTemperature(),
            'cpu_usage' => $this->getCpuUsage(),
            'memory_usage' => $this->getMemoryUsage(),
            'disk_usage' => $this->getDiskUsage(),
            'uptime' => $this->getUptime(),
        ];

        return view('stats', compact('stats'));
    }

    private function getCpuTemperature()
    {
        $temp = shell_exec('vcgencmd measure_temp');
        return str_replace(['temp=', "'C"], '', $temp);
    }

    private function getCpuUsage()
    {
        $load = sys_getloadavg();
        return $load[0];
    }

    private function getMemoryUsage()
    {
        $free = shell_exec('free');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $memory_usage = $mem[2]/$mem[1]*100;
        return round($memory_usage, 2);
    }

    private function getDiskUsage()
    {
        $disk_used = disk_total_space("/") - disk_free_space("/");
        $disk_total = disk_total_space("/");
        return round($disk_used / $disk_total * 100, 2);
    }

    private function getUptime()
    {
        $uptime = shell_exec("uptime -p");
        return str_replace("up ", "", $uptime);
    }
}
