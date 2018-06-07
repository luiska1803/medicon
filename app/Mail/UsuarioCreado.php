<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsuarioCreado extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $email;
    public $pass;

    public function __construct($nombre,$email,$pass)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->pass = $pass;
    }

    public function build()
    {
        return $this->from('luiska1803@gmail.com')
        ->subject('Se ha registrado en MediCON') 
        ->view('mails.usuario');
    }
}
