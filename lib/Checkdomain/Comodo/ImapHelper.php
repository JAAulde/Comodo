<?php
namespace Checkdomain\Comodo;

use Zend\Mail\Storage\Message;
use Zend\Mail\Storage\Folder;
use Zend\Mail\Storage\Part;

/**
 * Class ImapHelper
 *
 * @package Checkdomain\Administration\CustomerBundle\Controller
 */
class ImapHelper
{
    const PROCESSED_FLAG = 'checkdomain_comodo_processed';

    public static $subjects = array(
        'order_received'       => 'Your order has been received',
        'confirmation'         => 'CONFIRMATION',
        'information_required' => 'Information Required',
        '1_expiry'             => 'Customer certificate expiry warning (1 days)',
        '30_expiry'            => 'Customer certificate expiry warning (30 days)',
        '60_expiry'            => 'Customer certificate expiry warning (60 days)'
    );

    public static $bodies = array(
        'issued' => '/Your [a-zA-Z ]* Certificate for [\*a-zA-Z0-9\_\-öäü\.]* is attached!/'
    );

    /**
     *  Fetches the mail recursively, through the folders.
     *
     * @param ImapWithSearch $imap             imap helper class
     * @param array          $messages         (internal)
     * @param string         $search           imap-searchterm
     * @param Folder         $folders          the subfolders
     * @param bool           $markProcessed    Sets the flag as processed
     * @param bool           $assume           Assumes domainName / order-Number in the mail
     * @param \Closure       $callbackFunction callback
     *
     * @return array
     */
    public function fetchMails(ImapWithSearch $imap, array $messages, $search, Folder $folders = null, $markProcessed = true, $assume = false, \Closure $callbackFunction = null)
    {
        if ($folders === null) {
            $folders = $imap->getFolders();
        }

        foreach ($folders as $folder) {
            $imap->selectFolder($folder);
            $result = $imap->search(array($search));

            foreach ($result as $id) {
                $i = count($messages);

                $message = $imap->getMessage($id);


                $messages[$i]['id']     = $i;
                $messages[$i]['folder'] = $folder;

                // Zend-mail sometimes got problems, with incorrect e-mails
                try {
                    $messages[$i]['subject'] = utf8_decode($message->getHeader('subject', 'string'));
                } catch (\Exception $e) {
                    $messages[$i]['subject'] = '-No subject-';
                }

                try {
                    $messages[$i]['received'] = strtotime($message->getHeader('date', 'string'));
                } catch (\Exception $e) {
                    $messages[$i]['received'] = '-No date-';
                }

                $messages[$i]['plainText']   = $this->getPlainText($message);
                $messages[$i]['attachments'] = $this->getAttachments($message);
                $messages[$i]['type']        = $this->getTypeOfMail($messages[$i]);

                if ($assume) {
                    $messages[$i]['orderNumber'] = $this->assumeOrderNumber($messages[$i]);
                    $messages[$i]['domainName']  = $this->assumeDomainName($messages[$i]);
                }

                $success = true;
                if (is_callable($callbackFunction)) {
                    $success = $callbackFunction($id, $messages[$i]);
                }

                if ($markProcessed && $success) {
                    $this->markProcessed($imap, $message, $id);
                }
            }

            $messages = $this->fetchMails(
                $imap,
                $messages,
                $search,
                $folder,
                $markProcessed,
                $assume,
                $callbackFunction
            );
        }

        return $messages;
    }

    /**
     * Marks the mail with the processed flag
     *
     * @param ImapWithSearch $imap
     * @param Message        $message
     * @param integer        $id
     */
    protected function markProcessed(ImapWithSearch $imap, Message $message, $id)
    {
        $flags   = $message->getFlags();
        $flags[] = self::PROCESSED_FLAG;

        $imap->setFlags($id, $flags);
    }

    /**
     * Tries to find out, what Comodo wanna tell us...
     *
     * @param array $mail
     *
     * @return null|string
     */
    protected function getTypeOfMail(array $mail)
    {
        foreach (self::$subjects as $key => $subject) {
            if (stristr($mail['subject'], $subject) !== false) {
                return $key;
            }
        }

        foreach (self::$bodies as $key => $body) {
            if (preg_match($body, $mail['plainText'])) {
                return $key;
            }
        }

        return null;
    }

    /**
     * @param Part $part
     *
     * @return string|null
     */
    public function getPlainText(Part $part)
    {
        $text = null;

        if ($part->isMultipart()) {
            $partCount = $part->countParts();

            // Parse all parts
            for ($i = 0; $i < $partCount; $i++) {
                $subPart = $part->getPart($i + 1);

                // Check for headers, to avoid exceptions
                if ($subPart->getHeaders() !== null) {
                    if ($subPart->isMultipart()) {
                        // Part is multipart as well
                        $tmp = $this->getPlainText($subPart);
                        $text = ($tmp !== null) ? $tmp : $text;
                    } else {
                        // Try to get plain/text of this content
                        $tmp = $this->getPlainTextOfPart($subPart);
                        $text = ($tmp !== null) ? $tmp : $text;
                    }
                }
            }
        } else {
            // Its not multipart, so try to get its content
            $text = $this->getPlainTextOfPart($part);
        }

        return $text;
    }

    /**
     * @param Part $part
     *
     * @return null|string
     */
    private function getPlainTextOfPart(Part $part)
    {
        try {
            if ($part->getHeaderField('Content-Disposition') == 'attachment') {
                return null;
            }
        } catch (\Exception $e) {
            // Zend throws an Exception, if headerField does not exist
        }

        try {
            // If content-type is text/plain, return its content
            if ($part->getHeaderField('Content-Type') == 'text/plain') {
                return $this->getStringFromPart($part);
            }
        } catch (\Exception $e) {
            // If content-type is not available (exception thrown), return its content
            return $this->getStringFromPart($part);
        }

        return null;
    }

    /**
     * @param $part
     *
     * @return null|string
     */
    public function getStringFromPart($part)
    {
        if ($part === null) {
            return null;
        }

        if ($part instanceof Part) {
            $text = $part->getContent();
        } else {
            $text = $part;
        }

        return quoted_printable_decode(strip_tags($text));
    }


    /**
     * @param Message $message
     *
     * @return array|null
     */
    public function getAttachments(Message $message)
    {
        $attachments = null;

        // Only multi-part will have attachments
        if ($message->isMultipart()) {
            if ($message->countParts() > 1) {

                $partCount = $message->countParts();
                for ($i = 0; $i < $partCount; $i++) {
                    $part = $message->getPart($i + 1);

                    // Check for headers, to avoid exceptions
                    if ($part->getHeaders() !== null) {
                        // Getting disposition
                        $disposition = null;
                        try {
                            $disposition = $part->getHeaderField('Content-Disposition');
                        } catch (\Exception $e) {
                            // Zend throws an Exception, if headerField does not exist
                        }

                        if ($disposition == 'attachment') {
                            $content = quoted_printable_decode($part->getContent());

                            // Encoding?
                            try {
                                $transferEncoding = $part->getHeaderField('Content-Transfer-Encoding');

                                if ($transferEncoding == 'base64') {
                                    $content = base64_decode($content);
                                }
                            } catch (\Exception $e) {
                                // Zend throws an Exception, if headerField does not exist
                            }

                            $attachments[] = array(
                                'mime'     => $part->getHeaderField('Content-Type'),
                                'filename' => $part->getHeaderField('Content-Disposition', 'filename'),
                                'content'  => $content
                            );
                        }
                    }
                }
            }
        }

        return $attachments;
    }

    /**
     * @param string $message
     *
     * @return integer|null
     */
    protected function assumeOrderNumber($message)
    {
        $pattern = '/[order|\#][^0-9]+([0-9]{7,8})/i';

        return $this->searchSubjectAndPlainText($pattern, $message);
    }

    /**
     * @param string $message
     *
     * @return string|null
     */
    protected function assumeDomainName($message)
    {
        $pattern = '/(?:certificate for|domain|domain name){1}[\s\t\n\r\:\-]*((?:[\*a-z0-9äöüß-]+\.)+[a-z0-9äöüß-]+)/i';

        return $this->searchSubjectAndPlainText($pattern, $message);
    }

    /**
     * @param $pattern
     * @param $message
     *
     * @return null
     */
    protected function searchSubjectAndPlainText($pattern, $message)
    {
        $matchesText = array();
        preg_match($pattern, $message['subject'], $matchesText);

        if (!empty($matchesText[1])) {
            return $matchesText[1];
        }

        $matchesSubject = array();
        preg_match($pattern, $message['plainText'], $matchesSubject);

        if (!empty($matchesSubject[1])) {
            return $matchesSubject[1];
        }

        return null;
    }
}
