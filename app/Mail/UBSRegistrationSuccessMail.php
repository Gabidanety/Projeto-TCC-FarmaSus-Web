<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UBSRegistrationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ubs;

    public function __construct($ubs)
    {
        $this->ubs = $ubs; // Passa os dados da UBS para o template
    }

    public function build()
    {
        return $this->subject('Cadastro de UBS Realizado com Sucesso!')
                    ->view('emails.ubs_registration_success'); // Template do e-mail
    }
}
