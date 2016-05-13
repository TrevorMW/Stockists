<?php

/**
 * Created by PhpStorm.
 * User: Trevor
 * Date: 4/30/16
 * Time: 11:59 PM
 */
class Ajax_Response
{
  public $status;
  public $message;
  public $data;
  public $callback;
  public $action;

  public function __construct( $action = null, $callback = false )
  {
    $this->status   = false;
    $this->message  = null;
    $this->data     = null;
    $this->action   = $action;

    if( !$callback )
      $this->callback = $action;
  }

  public function set_message( $msg )
  {
    $this->message = $msg;
  }

  public function set_data( $data )
  {
    $this->data = $data;
  }

  public function set_status( $status )
  {
    $this->status = $status;
  }

  public function encode_response()
  {
    return json_encode( array( 'status' => $this->status, 'message' => $this->message, 'data' => $this->data, 'action_id' => $this->action, 'callback' => $this->action  ) );
  }
}
