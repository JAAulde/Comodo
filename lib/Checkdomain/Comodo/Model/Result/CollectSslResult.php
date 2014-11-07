<?php
namespace Checkdomain\Comodo\Model\Result;

/**
 * Class CollectSslResult
 *
 * @package Checkdomain\Comodo\Model\Result
 */
class CollectSslResult extends AbstractResult
{
    /**
     * @var integer
     */
    protected $orderNumber;

    /**
     * @var \DateTime
     */
    protected $notBefore;

    /**
     * @var \DateTime
     */
    protected $notAfter;

    /**
     * @var string
     */
    protected $fqdn;

    /**
     * @var string
     */
    protected $zipFile;

    /**
     * @var string
     */
    protected $netscapeCertificateSequence;

    /**
     * @var string
     */
    protected $pkcs7;

    /**
     * @var string
     */
    protected $caCertificate;

    /**
     * @var string
     */
    protected $certificate;

    /**
     * @var string
     */
    protected $certificateStatus;

    /**
     * @var string
     */
    protected $validationStatus;

    /**
     * @var string
     */
    protected $mdcDomainDetails;

    /**
     * @var string
     */
    protected $mdcDomainDetails2;

    /**
     * @var integer
     */
    protected $csrStatus;

    /**
     * @var integer
     */
    protected $dcvStatus;

    /**
     * @var integer
     */
    protected $ovCallBackStatus;

    /**
     * @var integer
     */
    protected $organizationValidationStatus;

    /**
     * @var integer
     */
    protected $freeDVUPStatus;

    /**
     * @var integer
     */
    protected $evClickThroughStatus;

    /**
     * @return string
     */
    public function getCaCertificate()
    {
        return $this->caCertificate;
    }

    /**
     * @param string $caCertificate
     *
     * @return CollectSslResult
     */
    public function setCaCertificate($caCertificate)
    {
        $this->caCertificate = $caCertificate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCertificate()
    {
        return $this->certificate;
    }

    /**
     * @param string $certificate
     *
     * @return CollectSslResult
     */
    public function setCertificate($certificate)
    {
        $this->certificate = $certificate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCertificateStatus()
    {
        return $this->certificateStatus;
    }

    /**
     * @param string $certificateStatus
     *
     * @return CollectSslResult
     */
    public function setCertificateStatus($certificateStatus)
    {
        $this->certificateStatus = $certificateStatus;

        return $this;
    }

    /**
     * @return int
     */
    public function getCsrStatus()
    {
        return $this->csrStatus;
    }

    /**
     * @param int $csrStatus
     *
     * @return CollectSslResult
     */
    public function setCsrStatus($csrStatus)
    {
        $this->csrStatus = $csrStatus;

        return $this;
    }

    /**
     * @return int
     */
    public function getDcvStatus()
    {
        return $this->dcvStatus;
    }

    /**
     * @param int $dcvStatus
     *
     * @return CollectSslResult
     */
    public function setDcvStatus($dcvStatus)
    {
        $this->dcvStatus = $dcvStatus;

        return $this;
    }

    /**
     * @return int
     */
    public function getEvClickThroughStatus()
    {
        return $this->evClickThroughStatus;
    }

    /**
     * @param int $evClickThroughStatus
     *
     * @return CollectSslResult
     */
    public function setEvClickThroughStatus($evClickThroughStatus)
    {
        $this->evClickThroughStatus = $evClickThroughStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getFqdn()
    {
        return $this->fqdn;
    }

    /**
     * @param string $fqdn
     *
     * @return CollectSslResult
     */
    public function setFqdn($fqdn)
    {
        $this->fqdn = $fqdn;

        return $this;
    }

    /**
     * @return int
     */
    public function getFreeDVUPStatus()
    {
        return $this->freeDVUPStatus;
    }

    /**
     * @param int $freeDVUPStatus
     *
     * @return CollectSslResult
     */
    public function setFreeDVUPStatus($freeDVUPStatus)
    {
        $this->freeDVUPStatus = $freeDVUPStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getMdcDomainDetails()
    {
        return $this->mdcDomainDetails;
    }

    /**
     * @param string $mdcDomainDetails
     *
     * @return CollectSslResult
     */
    public function setMdcDomainDetails($mdcDomainDetails)
    {
        $this->mdcDomainDetails = $mdcDomainDetails;

        return $this;
    }

    /**
     * @return string
     */
    public function getMdcDomainDetails2()
    {
        return $this->mdcDomainDetails2;
    }

    /**
     * @param string $mdcDomainDetails2
     *
     * @return CollectSslResult
     */
    public function setMdcDomainDetails2($mdcDomainDetails2)
    {
        $this->mdcDomainDetails2 = $mdcDomainDetails2;

        return $this;
    }

    /**
     * @return string
     */
    public function getNetscapeCertificateSequence()
    {
        return $this->netscapeCertificateSequence;
    }

    /**
     * @param string $netscapeCertificateSequence
     *
     * @return CollectSslResult
     */
    public function setNetscapeCertificateSequence($netscapeCertificateSequence)
    {
        $this->netscapeCertificateSequence = $netscapeCertificateSequence;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getNotAfter()
    {
        return $this->notAfter;
    }

    /**
     * @param \DateTime $notAfter
     *
     * @return CollectSslResult
     */
    public function setNotAfter($notAfter)
    {
        $this->notAfter = $notAfter;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getNotBefore()
    {
        return $this->notBefore;
    }

    /**
     * @param \DateTime $notBefore
     *
     * @return CollectSslResult
     */
    public function setNotBefore($notBefore)
    {
        $this->notBefore = $notBefore;

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
     * @param int $orderNumber
     *
     * @return CollectSslResult
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrganizationValidationStatus()
    {
        return $this->organizationValidationStatus;
    }

    /**
     * @param int $organizationValidationStatus
     *
     * @return CollectSslResult
     */
    public function setOrganizationValidationStatus($organizationValidationStatus)
    {
        $this->organizationValidationStatus = $organizationValidationStatus;

        return $this;
    }

    /**
     * @return int
     */
    public function getOvCallBackStatus()
    {
        return $this->ovCallBackStatus;
    }

    /**
     * @param int $ovCallBackStatus
     *
     * @return CollectSslResult
     */
    public function setOvCallBackStatus($ovCallBackStatus)
    {
        $this->ovCallBackStatus = $ovCallBackStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getPkcs7()
    {
        return $this->pkcs7;
    }

    /**
     * @param string $pkcs7
     *
     * @return CollectSslResult
     */
    public function setPkcs7($pkcs7)
    {
        $this->pkcs7 = $pkcs7;

        return $this;
    }

    /**
     * @return string
     */
    public function getValidationStatus()
    {
        return $this->validationStatus;
    }

    /**
     * @param string $validationStatus
     *
     * @return CollectSslResult
     */
    public function setValidationStatus($validationStatus)
    {
        $this->validationStatus = $validationStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getZipFile()
    {
        return $this->zipFile;
    }

    /**
     * @param string $zipFile
     *
     * @return CollectSslResult
     */
    public function setZipFile($zipFile)
    {
        $this->zipFile = $zipFile;

        return $this;
    }
}