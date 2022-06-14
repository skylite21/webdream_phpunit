<?php

namespace App;

class User {

  public string $first_name = '';
  public string $surname    = '';
  public string $email      = '';

  protected Mailer $mailer;

  /**
   * Get the user's full name from their first name and surname
   *
   * @return string The user's full name
   */
  public function getFullName() : string {
    return trim("$this->first_name $this->surname");
  }

  public function notify($message) {
    return $this->mailer->sendMessage($this->email, $message);
  }

  public function setMailer(Mailer $mailer) {
    $this->mailer = $mailer;
  }
}
