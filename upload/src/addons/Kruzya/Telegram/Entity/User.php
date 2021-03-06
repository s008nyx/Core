<?php
namespace Kruzya\Telegram\Entity;

use XF\Mvc\Entity\Structure;
use XF\Mvc\Entity\Entity;

use Kruzya\Telegram\Utils;

class User extends Entity {
  public static function getStructure(Structure $structure) {
    $structure->table      = 'tg_user';
    $structure->shortName  = 'Kruzya\\Telegram:User';
    $structure->primaryKey = 'id';

    $structure->relations  = [];
    $structure->getters    = [];
    $structure->columns    = [
      'id'            => [
        'type'        => self::UINT,
        'required'    => true,
      ],
      'first_name'    => [
        'type'        => self::STR,
        'default'     => '',
      ],
      'last_name'     => [
        'type'        => self::STR,
        'default'     => '',
      ],
      'username'      => [
        'type'        => self::STR,
        'default'     => '',
      ],
      'photo_url'     => [
        'type'        => self::STR,
        'default'     => '',
      ],
      'updated'       => [
        'type'        => self::UINT,
        'default'     => time(),
        'required'    => true,
      ]
    ];

    return $structure;
  }

  /**
   * Updates information about user if required.
   * NOTE: this method call save(), if information has been updated.
   */
  public function UpdateIfRequired($time = 86400) {
    $CurrentTS = time();

    if ($CurrentTS - 86400 > $this->updated) {
      $chat = $this->api()->getChat();
      if ($chat['ok']) {
        $chat = $chat['result'];

        $first_name = $chat['first_name'];
        $last_name  = null;
        $username   = null;

        if (isset($chat['last_name']))
          $last_name = $chat['last_name'];
        if (isset($chat['username']))
          $username = $chat['username'];

        $this->bulkSet([
          'first_name'  => $first_name,
          'last_name'   => $last_name,
          'username'    => $username,

          'updated'     => $CurrentTS,
        ]);
        $this->save();
      }
    }
  }

  /**
   * Returns a API object for working with API.
   *
   * @return \Kruzya\Telegram\API
   */
  public function api() {
    return Utils::api()->setGlobalVariables([
      'chat_id'   => $this->id,
      'user_id'   => $this->id, //for user specific methods.
    ]);
  }

  /**
   * All methods the following here is DEPRECATED.
   * Do not use this!
   * 
   * Use "magic" api() method.
   * 
   * Approximate date for removing this methods: 09.15.2018.
   */
  public function sendMessage($text, $markup = '', $disable_url_preview = false) {
    if ($markup == 'none')
      $markup = '';

    $response = $this->api()->sendMessage([
      'text'                      => $text,
      'parse_mode'                => $markup,
      'disable_web_page_preview'  => $disable_url_preview
    ]);

    if ($response['ok'])
      return $response['result']['message_id'];
    return -1;
  }

  public function deleteMessage($message_id) {
    $response = Utils::api()->deleteMessage([
      'chat_id'     => $this->id,
      'message_id'  => $message_id
    ]);

    return $response['ok'];
  }

  public function editMessageText($message_id, $text, $markup = 'HTML') {
    $response = Utils::api()->editMessageText([
      'chat_id'     => $this->id,
      'message_id'  => $message_id,
      'text'        => $text,
      'parse_mode'  => $markup,
    ]);

    return $response['ok'];
  }
}
