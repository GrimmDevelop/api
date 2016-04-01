<?php


namespace App\Import;

use Closure;
use XBase\Table;

class DbfProcessor
{
    /**
     * @var Table|null
     */
    protected $table = null;

    protected $rows;

    protected $columns;

    public function open($file)
    {

        $this->table = new Table($file);

        $this->rows = $this->table->recordCount;

        $this->columns = $this->table->columns;
    }

    public function close()
    {
        if ($this->table != null) {
            $this->table->close();
        }
    }

    /**
     * @param callable|Closure $rowHandler
     * @param int $limit
     * @param int $offset
     * @return int
     */
    public function eachRow(Closure $rowHandler, $limit = 0, $offset = 0)
    {
        $start = $offset;
        if ($start > 0) {
            $this->table->moveTo($start - 1);
        }

        $endPoint = ($limit == 0) ? $this->rows : $start + $limit;

        while ($record = $this->table->nextRecord()) {
            if ($start >= $endPoint) {
                break;
            }

            $start++;

            if ($record->isDeleted()) {
                continue;
            }

            $rowHandler($record, $this->columns);

        }

        // There is an internal calculation of deleted rows that are removed before outputting those.
        // To jump to the correct index in the next import step, we have to add this count!
        return $start + $this->table->getDeleteCount();
    }

    /**
     * @return mixed
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }
}