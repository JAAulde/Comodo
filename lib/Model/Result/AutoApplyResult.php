<?php
namespace Checkdomain\Comodo\Model\Result;

/**
 * Class AutoApplyResult
 * Offers the orderNumber, excepted delivery-time, total-cost, certificate-id and tells you if certificate has been paid
 */
class AutoApplyResult extends AbstractResult
{
    protected $orderNumber;
    protected $expectedDeliveryTime;
    protected $totalCost;
    protected $paid;
    protected $certificateID;
    protected $uniqueValue;

    /**
     * @param bool $paid
     *
     * @return AutoApplyResult
     */
    public function setPaid($paid)
    {
        $this->paid = (bool) $paid;

        return $this;
    }

    /**
     * @return bool
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * @param mixed $certificateID
     *
     * @return AutoApplyResult
     */
    public function setCertificateID($certificateID)
    {
        $this->certificateID = $certificateID;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCertificateID()
    {
        return $this->certificateID;
    }


    /**
     * @param int $expectedDeliveryTime
     *
     * @return AutoApplyResult
     */
    public function setExpectedDeliveryTime($expectedDeliveryTime)
    {
        $this->expectedDeliveryTime = $expectedDeliveryTime;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpectedDeliveryTime()
    {
        return $this->expectedDeliveryTime;
    }

    /**
     * @param int $orderNumber
     *
     * @return AutoApplyResult
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param float $totalCost
     *
     * @return AutoApplyResult
     */
    public function setTotalCost($totalCost)
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalCost()
    {
        return $this->totalCost;
    }

    /**
     * @return string
     */
    public function getUniqueValue()
    {
        return $this->uniqueValue;
    }

    /**
     * @param string $uniqueValue
     *
     * @return AutoApplyResult
     */
    public function setUniqueValue($uniqueValue)
    {
        $this->uniqueValue = $uniqueValue;

        return $this;
    }
}
