<?php

namespace YLibs;

use Exception;
use Throwable;

/**
 * ルーティング用の例外クラスを定義
 */
class AccessPermissionException extends Exception
{
    /**
     * リクエストURI
     *
     * @var string
     */
    private string $requestUri;
    /**
     * ロール
     *
     * @var mixed
     */
    private mixed $role;

    // 例外を再定義し、メッセージをオプションではなくする
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $this->request_url = $_SERVER["REQUEST_URI"];
        // 全てを正しく確実に代入する
        parent::__construct($message, $code, $previous);
    }

    // オブジェクトの文字列表現を独自に定義する
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * Get リクエストURI
     *
     * @return  string
     */
    public function getRequestUri(): string
    {
        return $this->requestUri;
    }

    /**
     * Get ロール
     *
     * @return  mixed
     */
    public function getRole(): mixed
    {
        return $this->role;
    }

    /**
     * Set ロール
     *
     * @param   mixed  $role  ロール
     *
     * @return  self
     */
    public function setRole($role): self
    {
        $this->role = $role;

        return $this;
    }
}
