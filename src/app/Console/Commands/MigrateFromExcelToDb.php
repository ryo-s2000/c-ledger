<?php

namespace App\Console\Commands;

use DB;
use Exception;
use Illuminate\Console\Command;

class MigrateFromExcelToDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:from-excel-to-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migrate construction data from excel to database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $targetData = $this->getTargetData();

        DB::beginTransaction();
        try {
            $this->insertToConstructionsTable($targetData);
            DB::commit();
            print_r("sucsess\n");
        } catch (Exception $e) {
            DB::rollback();
            print_r("rollback\n");
            print_r($e->getMessage());
            return 1;
        }

        return 0;
    }

    private function getTargetData($fileName = 'constructions.csv'): array {
        $targetData = [];

        $columns = [];
        $rowIdx = 0;
        if (($handle = fopen($fileName, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if ($rowIdx == 0) {
                    $columns = $row;
                    $rowIdx++;
                    continue;
                }

                $formattedRow = [];
                for ($columnIdx=0; $columnIdx < count($row); $columnIdx++) {
                    if ($columns[$columnIdx] == 'progress') {
                        $formattedRow['progress'] = json_encode([[
                            'value' => $row[$columnIdx],
                            'datetime' => now(),
                        ]]);
                    } else if ($row[$columnIdx] == '') {
                        $formattedRow[$columns[$columnIdx]] = NULL;
                    } else {
                        $formattedRow[$columns[$columnIdx]] = $row[$columnIdx];
                    }
                }

                array_push($targetData, $formattedRow);

                $rowIdx++;
            }
            fclose($handle);
        }

        return $targetData;
    }

    private function insertToConstructionsTable(array $targetData): void {
        DB::table('constructions')->insert($targetData);
    }
}
