<?php


class PPaymentType extends \Phalcon\Mvc\Model 
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
    public $PARTNER_TYPE;

    /**
     * @var string
     *
     */
    public $TYPE_NAME;

    /**
     * @var string
     *
     */
    public $TYPE_PARAMS;

    /**
     * @var double
     *
     */
    public $USE_STATUS;

    /**
     * @var double
     *
     */
    public $CREATE_TIME;

    /**
     * @var double
     *
     */
    public $AGENCY_ID;

    /**
     * @var double
     *
     */
    public $COMISSION_RATE;

    /**
     * @var double
     *
     */
    public $DEFAULT_PARTNER_TYPE;


}
