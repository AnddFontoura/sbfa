<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlayerInvitedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $playerEmail, string $playerName)
    {
        $this->email = $playerEmail;
        $this->name = $playerName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->email, $this->name)
                ->subject('SBFA - Você foi convidado por um time!')
                ->view('mail.player_invited');
    }
}
