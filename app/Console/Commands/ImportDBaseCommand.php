<?php

namespace App\Console\Commands;

use App\Import\Books\Converter\BookConverter;
use App\Import\DbfProcessor;
use App\Import\Persons\Converter\PersonConverter;
use DB;
use Illuminate\Console\Command;
use XBase\Record;

class ImportDBaseCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grimm:import {folder} {--exclude-letters} {--exclude-persons} {--exclude-books} {--force}';

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
     * @param DbfProcessor    $processor
     * @param PersonConverter $converter
     *
     * @param BookConverter   $bookConverter
     *
     * @return mixed
     */
    public function handle(DbfProcessor $processor, PersonConverter $converter, BookConverter $bookConverter)
    {
        if (!is_readable($this->argument('folder'))) {
            $this->error('The given folder is not readable!');

            return;
        }

        $importPersons = !$this->option('exclude-persons');
        $importLetters = !$this->option('exclude-letters');
        $importBooks = !$this->option('exclude-books');

        $letterDbase = rtrim($this->argument('folder'), '/') . '/CORPUS.DBF';
        $personDbase = rtrim($this->argument('folder'), '/') . '/persreg.DBF';
        $bookDbase = rtrim($this->argument('folder'), '/') . '/DRUCKE.DBF';

        if (!file_exists($personDbase) && $importPersons) {
            $this->error('Person DBase File (persreg.DBF) does not exist!');

            return;
        }

        if (!file_exists($letterDbase) && $importLetters) {
            $this->error('Letter DBase File (CORPUS.DBF) does not exist!');

            return;
        }

        if (!file_exists($bookDbase) && $importBooks) {
            $this->error('Book DBase File (DRUCKE.DBF) does not exist!');

            return;
        }

        if ($importPersons) {
            $this->importPersons($personDbase, $processor, $converter);
        }

        if ($importBooks) {
            $this->importBooks($bookDbase, $processor, $bookConverter);
        }

    }

    /**
     * @param                 $personDbase
     * @param DbfProcessor    $processor
     * @param PersonConverter $converter
     */
    protected function importPersons($personDbase, DbfProcessor $processor, PersonConverter $converter)
    {
        if ($this->option('force')) {
            if ($this->confirm("Do you really want to delete all existing data in the person database?")) {
                $this->clearPersonDatabase();
            }
        }

        $this->info('Import of Person Database.');

        $this->importDatabase($personDbase, $processor, $converter);
    }

    protected function importBooks($bookDbase, DbfProcessor $processor, BookConverter $converter)
    {
        if ($this->option('force')) {
            if ($this->confirm("Do you really want to delete all existing data in the books database?")) {
                $this->clearBooksDatabase();
            }
        }

        $this->info('Import of Book Database.');
        $this->importDatabase($bookDbase, $processor, $converter);
    }

    protected function importDatabase($dbFile, DbfProcessor $processor, $converter)
    {
        $processor->open($dbFile);
        $this->info('Importing ' . $processor->getRows() . ' entries');

        $this->output->progressStart($processor->getRows());

        $converter->preflight();

        $processor->eachRow(function (Record $record, $columns) use ($converter) {
            $converter->convert($record, $columns);
            $this->output->progressAdvance();
        });

        $this->output->progressFinish();

        $this->info('Import done!');
    }

    protected function clearPersonDatabase()
    {
        DB::table('persons')->delete();
        DB::table('person_codes')->delete();
        DB::statement('ALTER TABLE persons AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE person_codes AUTO_INCREMENT = 1');
    }

    protected function clearBooksDatabase()
    {
        DB::table('books')->delete();
        DB::statement('ALTER TABLE books AUTO_INCREMENT = 1');
    }
}
