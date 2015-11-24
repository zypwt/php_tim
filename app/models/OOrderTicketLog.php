<?php


class OOrderTicketLog extends \Phalcon\Mvc\Model 
{

    /**
     * @var double
     *
     */
    public $ID;

    /**
     * @var double
     *
     */
    public $ORDER_ID;

    /**
     * @var double
     *
     */
    public $TICKET_ID;

    /**
     * @var double
     *
     */
    public $SCREENINGS;

    /**
     * @var string
     *
     */
    public $UUID;

    /**
     * @var string
     *
     */
    public $NAME;

    /**
     * @var double
     *
     */
    public $OLD_STATUS;

    /**
     * @var double
     *
     */
    public $NEW_STATUS;

    /**
     * @var string
     *
     */
    public $DESCRIBE;

    /**
     * @var double
     *
     */
    public $CREATE_TIME;


}
