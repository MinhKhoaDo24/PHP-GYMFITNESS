<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendTrialReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trial:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to customers whose trial is scheduled for tomorrow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = now()->addDay()->format('Y-m-d');

        $trials = \App\Models\Dangkidichvu::where('trangthai', 1)
            ->whereDate('ngay_mong_muon', $tomorrow)
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->get();

        $count = 0;
        foreach ($trials as $trial) {
            try {
                \Illuminate\Support\Facades\Mail::to($trial->email)->send(new \App\Mail\TrialReminderMail($trial));
                $count++;
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send reminder email to ' . $trial->email . ': ' . $e->getMessage());
            }
        }

        $this->info("Successfully sent {$count} reminder emails for trials on {$tomorrow}.");
    }
}
