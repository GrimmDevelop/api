<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Redis\Database;
use Spatie\Backup\Events\BackupHasFailed;

class FailedBackupListener
{
    /**
     * @var Database
     */
    private $redis;

    /**
     * Create the event listener.
     * @param Database $redis
     */
    public function __construct(Database $redis)
    {
        $this->redis = $redis;
    }

    /**
     * Handle the event.
     *
     * @param  BackupHasFailed $event
     */
    public function handle(BackupHasFailed $event)
    {
        $this->redis->set('last_backup_attempt', Carbon::now());
        $this->redis->set('last_backup_status', 'fail');
        $this->redis->set('last_backup_name', $event->backupDestination->getBackupName());
    }
}
