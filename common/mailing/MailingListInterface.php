<?php

namespace yz\admin\mailer\common\mailing;


/**
 * Interface MailingListInterface
 * @property \Iterator|MailRecipientInterface[] $recipients
 * @property bool $canSendImmediately
 * @property array $providerData Provider data that should be stored into the database
 */
interface MailingListInterface
{
    /**
     * Title for the current mail list
     * @return string
     */
    public static function listTitle();
    /**
     * Mail list data that should be stored into the database
     * @return array
     */
    public function listData();
    /**
     * Path for the view
     * @return string
     */
    public static function formView();
    /**
     * @return \Iterator|MailRecipientInterface[]
     */
    public function getRecipients();
}