<?php


class CArrearageUser extends \Phalcon\Mvc\Model 
{

    /**
     * @var double
     *
     */
    public $ID;

    /**
     * @var string
     *
     */
    public $NAME;

    /**
     * @var string
     *
     */
    public $MOBILE_PHONE;

    /**
     * @var string
     *
     */
    public $CONTACT_PHONE;

    /**
     * @var string
     *
     */
    public $ADDRESS;

    /**
     * @var string
     *
     */
    public $OFFICE;

    /**
     * @var string
     *
     */
    public $DESCRIPTION;

    /**
     * @var double
     *
     */
    public $CREATE_TIME;

    /**
     * @var double
     *
     */
    public $UPDATE_TIME;

    /**
     * @var double
     *
     */
    public $MAX_OWED;

    /**
     * @var double
     *
     */
    public $NOW_OWED;

    /**
     * @var double
     *
     */
    public $DAY_OWED;

    /**
     * @var string
     *
     */
    public $RELATE_CITY_IDS;

    /**
     * @var double
     *
     */
    public $HIDDEN;


}
