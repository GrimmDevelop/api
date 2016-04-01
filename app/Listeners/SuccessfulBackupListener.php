<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Redis\Database;
use Spatie\Backup\Events\BackupWasSuccessful;

class SuccessfulBackupListener
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
     * @param  BackupWasSuccessful $event
     */
    public function handle(BackupWasSuccessful $event)
    {
        $this->redis->set('last_successful_backup', Carbon::now());
        $this->redis->set('last_backup_attempt', Carbon::now());
        $this->redis->set('last_backup_status', 'success');
        $this->redis->set('last_backup_name', $event->backupDestination->getBackupName());
    }
}
