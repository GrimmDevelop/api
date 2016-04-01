<?php

namespace App\Console\Commands;

use App\Import\DbfProcessor;
use App\Import\Persons\Converter\PersonConverter;
use Illuminate\Console\Command;
use XBase\Record;

class ImportDBaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grimm:import {folder} {--exclude-letters} {--exclude-persons}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import existing DBase files into database';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param DbfProcessor $processor
     * @param PersonConverter $converter
     * @return mixed
     */
    public function handle(DbfProcessor $processor, PersonConverter $converter)
    {
        if (!is_readable($this->argument('folder'))) {
            $this->error('The given folder is not readable!');
            return;
        }

        $importPersons = !$this->option('exclude-persons');
        $importLetters = !$this->option('exclude-letters');

        $letterDbase = rtrim($this->argument('folder'), '/') . '/CORPUS.DBF';
        $personDbase = rtrim($this->argument('folder'), '/') . '/persreg.DBF';

        if (!file_exists($personDbase) && $importPersons) {
            $this->error('Person DBase File (persreg.DBF) does not exist!');
            return;
        }

        if (!file_exists($letterDbase) && $importLetters) {
            $this->error('Letter DBase File (CORPUS.DBF) does not exist!');
            return;
        }

        if ($importPersons) {
            $this->importPersons($personDbase, $processor, $converter);
        }

    }

    /**
     * @param $personDbase
     * @param DbfProcessor $processor
     * @param PersonConverter $converter
     */
    private function importPersons($personDbase, DbfProcessor $processor, PersonConverter $converter)
    {
        $processor->open($personDbase);

        $this->info('Importing person register database with ' . $processor->getRows() . ' entries');

        $this->output->progressStart($processor->getRows());

        $processor->eachRow(function (Record $record, $columns) use ($converter) {
            $converter->convert($record, $columns);
            $this->output->progressAdvance();
        });

        $this->output->progressFinish();
        $this->info('Import of person register done!');
    }
}
