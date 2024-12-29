<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RespostaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $detalhes;

    public function __construct($detalhes)
    {
        $this->detalhes = $detalhes;
    }

    public function build()
    {
        return $this->subject($this->detalhes['title'])
                    ->view('emails.resposta') // Assumindo que você tenha uma view 'resposta.blade.php'
                    ->with(['body' => $this->detalhes['body']]);
    }
}
