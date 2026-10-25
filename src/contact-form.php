<?php
declare(strict_types=1);

/**
 * Stores an inquiry submitted from the public website into the `messages`
 * table, where it shows up in the admin inbox.
 *
 * @param  array<string,mixed> $input  Typically the raw $_POST array.
 * @return array{ok:bool,message:string}
 */
function care_submit_inquiry(array $input): array
{
    $name    = trim((string) ($input['name'] ?? ''));
    $email   = trim((string) ($input['email'] ?? ''));
    $phone   = trim((string) ($input['phone'] ?? ''));
    $company = trim((string) ($input['company'] ?? ''));
    $service = trim((string) ($input['service'] ?? ''));
    $budget  = trim((string) ($input['budget'] ?? ''));
    $subject = trim((string) ($input['subject'] ?? ''));
    $message = trim((string) ($input['message'] ?? ''));

    if ($name === '' || $email === '' || $message === '') {
        return ['ok' => false, 'message' => 'Please fill in your name, email address and message.'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['ok' => false, 'message' => 'Please enter a valid email address.'];
    }

    $summary = array_filter([
        $subject,
        $service !== '' ? 'Service: ' . $service : '',
        $company !== '' ? 'Company: ' . $company : '',
        $budget !== '' ? 'Budget: ' . $budget : '',
    ]);

    care_db()->prepare(
        'INSERT INTO messages (name, email, phone, subject, message)
         VALUES (:name, :email, :phone, :subject, :message)'
    )->execute([
        'name'    => mb_substr($name, 0, 120),
        'email'   => mb_substr($email, 0, 190),
        'phone'   => $phone === '' ? null : mb_substr($phone, 0, 40),
        'subject' => $summary === [] ? null : mb_substr(implode(' · ', $summary), 0, 190),
        'message' => $message,
    ]);

    return [
        'ok'      => true,
        'message' => 'Thank you, ' . $name . '. Your inquiry has been received and we will get back to you shortly.',
    ];
}
