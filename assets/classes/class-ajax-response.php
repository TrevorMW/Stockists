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

  public function __construct( $action = null, $callback = null )
  {
    $this->status   = false;
    $this->message  = null;
    $this->data     = null;
    $this->callback = null;

    if( $action != null )
      $this->action = $action;

    if( $callback != null )
      $this->callback = $callback;
  }

  public function set_action_id( $action )
  {
    $this->action = $action;
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

  public function set_callback_function( $callback )
  {
    $this->callback = $callback;
  }

  public function encode_response()
  {
    return json_encode( array( 'status' => $this->status, 'message' => $this->message, 'data' => $this->data, 'action_id' => $this->action, 'callback' => $this->callback  ) );
  }
}
