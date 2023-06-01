<?php

namespace App\Console\Commands;

use App\Models\TaxDetail;
use Illuminate\Console\Command;
use Laravel\LegacyEncrypter\McryptEncrypter;

class SettleTaxDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settle:taxDetails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Settle the encryption of tax details';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $encryptionKey = env('APP_OLD_KEY');
        $legacy = new McryptEncrypter($encryptionKey);

        $records = TaxDetail::all();
        $bar = $this->output->createProgressBar(count($records));
        foreach ($records as $record) {
            $record->tax_id = encrypt(
                $legacy->decrypt($record->tax_id)
            );

            $record->save();
            $bar->advance();
        }

        $bar->finish();
        $this->info('');
        $this->info('Task completed');
    }
}
