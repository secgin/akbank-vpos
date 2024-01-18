<?php

namespace YG\AkbankVPos\Abstracts;

use YG\AkbankVPos\Abstracts\Authentication\EnrollmentControl;
use YG\AkbankVPos\Abstracts\Authentication\EnrollmentControlResult;
use YG\AkbankVPos\Abstracts\Cancel\Cancel;
use YG\AkbankVPos\Abstracts\Cancel\CancelResult;
use YG\AkbankVPos\Abstracts\InquiryTransactions\Search;
use YG\AkbankVPos\Abstracts\InquiryTransactions\SearchResult;
use YG\AkbankVPos\Abstracts\InquiryTransactions\Settlement;
use YG\AkbankVPos\Abstracts\InquiryTransactions\SettlementDetail;
use YG\AkbankVPos\Abstracts\InquiryTransactions\SettlementDetailResult;
use YG\AkbankVPos\Abstracts\InquiryTransactions\SettlementResult;
use YG\AkbankVPos\Abstracts\InquiryTransactions\SucceededOpenBatchTransactions;
use YG\AkbankVPos\Abstracts\InquiryTransactions\SucceededOpenBatchTransactionsResult;
use YG\AkbankVPos\Abstracts\Refund\Refund;
use YG\AkbankVPos\Abstracts\Refund\RefundResult;
use YG\AkbankVPos\Abstracts\Revers\Revers;
use YG\AkbankVPos\Abstracts\Revers\ReversResult;
use YG\AkbankVPos\Abstracts\Sale\Sale;
use YG\AkbankVPos\Abstracts\Sale\SaleResult;

/**
 * @method Response|EnrollmentControlResult enrollmentControl(EnrollmentControl $request)
 * @method Response|SaleResult sale(Sale $request)
 * @method Response|CancelResult cancel(Cancel $request)
 * @method Response|RefundResult refund(Refund $request)
 * @method Response|ReversResult revers(Revers $request)
 * @method Response|SettlementDetailResult settlementDetail(SettlementDetail $request)
 * @method Response|SettlementResult settlement(Settlement $request)
 * @method Response|SearchResult search(Search $request)
 * @method Response|SucceededOpenBatchTransactionsResult succeededOpenBatchTransactions(SucceededOpenBatchTransactions $request)
 */
interface VPosClient
{
}