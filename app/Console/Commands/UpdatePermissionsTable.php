<?php

namespace App\Console\Commands;

use Grimm\Permission;
use Illuminate\Console\Command;

class UpdatePermissionsTable extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grimm:permissions-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates all permission entries in table according to config';

    /**
     * @var array
     */
    protected $permissions;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->permissions = config('permissions');

        $this->removeUnusedPermissions();
        $this->addMissingPermissions();
    }

    protected function removeUnusedPermissions()
    {
        $permissionsInDb = Permission::all();

        /** @var Permission $permission */
        foreach ($permissionsInDb as $permission) {
            if (!in_array($permission->name, $this->permissions)) {
                $this->error('permission ' . $permission->name . ' removed');

                $permission->delete();
            }
        }
    }

    protected function addMissingPermissions()
    {
        foreach ($this->permissions as $permission) {
            if (!Permission::where('name', $permission)->first()) {
                Permission::create([
                    'name' => $permission
                ]);

                $this->info('permission ' . $permission . ' added');
            }
        }
    }
}
