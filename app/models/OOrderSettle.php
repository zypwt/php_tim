<?php


class OOrderSettle extends \Phalcon\Mvc\Model 
{

    /**
     * @var double
     *
     */
    public $ORDER_ID;

    /**
     * @var double
     *
     */
    public $SETTLE_STATUS;

    /**
     * @var double
     *
     */
    public $PRE_SETTLE_TIME;

    /**
     * @var double
     *
     */
    public $SETTLE_DONE_TIME;

    /**
     * @var string
     *
     */
    public $PRE_SETTLE_OPERATOR;

    /**
     * @var string
     *
     */
    public $SETTLE_DONE_OPERATOR;


}
