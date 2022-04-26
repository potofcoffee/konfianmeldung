<?php

namespace App\Mail;

use App\Models\Church;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KonfiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $record;
    public $parents;

    /** @var Church  */
    public $church;
    public $filename;
    public $groupName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($record, $parents, Church $church, $groupName, $filename)
    {
        $this->record = $record;
        $this->parents = $parents;
        $this->church = $church;
        $this->groupName = $groupName;
        $this->filename = $filename;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Deine Konfi-Anmeldung ist eingegangen.')
            ->attachFromStorage('pdf/'.$this->filename)
            ->markdown('mail.konfi');
    }
}
