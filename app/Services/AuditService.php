<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public static function log($action, $modelType, $modelId, $changes = [])
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'changes' => $changes,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'timestamp' => now('UTC'),
        ]);
    }

    public static function logCreate($modelType, $modelId, $data)
    {
        self::log('create', $modelType, $modelId, $data);
    }

    public static function logUpdate($modelType, $modelId, $oldData, $newData)
    {
        $changes = [];
        foreach ($newData as $key => $value) {
            if (($oldData[$key] ?? null) !== $value) {
                $changes[$key] = ['from' => $oldData[$key] ?? null, 'to' => $value];
            }
        }
        self::log('update', $modelType, $modelId, $changes);
    }

    public static function logDelete($modelType, $modelId, $data)
    {
        self::log('delete', $modelType, $modelId, $data);
    }
}
