<?php

require __DIR__ . '/../bootstrap.php';

$update = telegram()->commandsHandler(TRUE);

$text = $update->getMessage()?->get('text');
$chat_id = $update->getMessage()?->get('chat')?->get('id');
$message_id = $update->getMessage()?->get('message_id');

$replacements = [
  'Drupal' => 'Дрюпал',
  'Друпал' => 'Дрюпал',
];

if (!empty($text) && !empty($chat_id) && !empty($message_id)) {
  $corrected_text = $text;
  foreach ($replacements as $origin_word => $substitute) {
    if (str_contains(strtolower($text), strtolower($origin_word))) {
      $corrected_text = preg_replace("#$origin_word#i", $substitute, $text);
    }
  }
  if ($corrected_text !== $text) {
    telegram()->editMessageText([
      'chat_id' => $chat_id,
      'message_id' => $message_id,
      'text' => $corrected_text,
    ]);
  }
}








