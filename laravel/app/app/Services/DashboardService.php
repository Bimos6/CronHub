<?php

namespace App\Services;

use App\Services\Contracts\IDashboardService;

class DashboardService implements IDashboardService
{
    public function executionsStatsValues($executions): array
    {
        $values = [0, 0, 0, 0, 0, 0, 0];
        
        foreach ($executions as $execution) {
            if ($execution->started_at) {
                $dayOfWeek = date('w', strtotime($execution->started_at));
                $index = $dayOfWeek - 1;
                if ($index < 0) $index = 6;
                $values[$index]++;
            }
        }

        return $values;
    }

    public function executionsErrorsStatsValues($executions): array
    {
        $errorValues = [0, 0, 0, 0, 0, 0, 0];
        
        foreach ($executions as $execution) {
            if ($execution->started_at && 
                ($execution->status_code !== 200 || !empty($execution->error_message))) {
                
                $dayOfWeek = date('w', strtotime($execution->started_at));
                $index = $dayOfWeek - 1;
                if ($index < 0) $index = 6;
                $errorValues[$index]++;
            }
        }

        return $errorValues;
    }
}