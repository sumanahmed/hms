<?php
/**
 * Created by PhpStorm.
 * User: ontik
 * Date: 1/18/2018
 * Time: 5:16 PM
 */

namespace App\Modules\Report\Http\Response;

use App\Models\ManualJournal\JournalEntry;
use App\Models\Moneyin\Invoice;
use App\Models\MoneyOut\Bill;
use Carbon\Carbon;
use DateTime;

final class TotalTransaction
{
    protected $data  = [];
    protected $start = null;
    protected $end   = null;

    protected $beginTime = null;
    protected $yesterday = null;

    public function __construct($start, $end)
    {
        $this->start     = $start;
        $this->end       = $end;
        $current_time    = Carbon::now()->toDayDateTimeString();
        $this->beginTime = (new DateTime($current_time))->modify('-999999 day')->format('Y-m-d');
        $this->yesterday = date("Y-m-d", strtotime($start . "-1 day"));
        
    }

    public function get()
    {

        $this->purchase();
        $this->sales();
        $this->bank();
        $this->generalExpense();
        $this->receipt();
        $this->totalDue();
        $this->payments();
        $this->bankDebit();
        $this->bankCredit();
        return $this->data;
    }

    public function openingBalance()
    {
        $purchase = JournalEntry::whereBetween("assign_date", [$this->beginTime, $this->yesterday])
            ->where("jurnal_type", "bill")
            ->where("account_name_id", 11)
            ->where("debit_credit", 0)
            ->with("bill.customer", "bill.billEntries.item")
            ->sum('amount');
        $this->data['openingPurchase'] = $purchase;

        $sales = JournalEntry::whereBetween("assign_date", [$this->beginTime, $this->yesterday])
            ->where("jurnal_type", "invoice")
            ->where("account_name_id", 5)
            ->where("debit_credit", 1)
            ->with("invoice.invoiceEntries.item", "invoice.customer")
            ->sum('amount');

        $adjustments = JournalEntry::join("invoices","invoices.id","journal_entries.invoice_id")
                              ->whereBetween("assign_date", [$this->beginTime, $this->yesterday])
                              ->where('journal_entries.account_name_id',5)
                              ->where("journal_entries.jurnal_type",'invoice')
                              ->with('invoice')
                              ->selectRaw("sum(invoices.vat_adjustment) + sum(invoices.tax_adjustment) + sum(invoices.others_adjustment) as total")
                              ->get();

        $adjustments = (double)($adjustments[0]->total);
        $this->data['openingSales'] = $sales - $adjustments;

        $generalExpense = JournalEntry::whereBetween("assign_date", [$this->beginTime, $this->yesterday])
            ->where("jurnal_type", "expense")
            ->where("debit_credit", 0)
            ->with("expense.account")
            ->sum('amount');

        $salesCommission = JournalEntry::whereBetween("assign_date", [$this->beginTime, $this->yesterday])
            ->where("jurnal_type", "sales_commission")
            ->where("account_name_id", 11)
            ->where("debit_credit", 1)
            ->sum('amount');
        $this->data['openingGeneralExpense'] = $generalExpense + $salesCommission;

        $receipt = JournalEntry::whereBetween("assign_date", [$this->beginTime, $this->yesterday])
            ->where("jurnal_type", "payment_receive2")
            ->where("account_name_id", 10)
            ->where("debit_credit", 0)
            ->with("paymentReceive.paymentContact")
            ->sum('amount');

        $income = JournalEntry::whereBetween("assign_date", [$this->beginTime, $this->yesterday])
            ->where("jurnal_type", "income")
            ->where("debit_credit", 1)
            ->sum('amount');
        
        $bank_payment = JournalEntry::whereBetween("assign_date", [$this->beginTime, $this->yesterday])
            ->join("account", "journal_entries.account_name_id", "=", "account.id")
            ->where("account_type_id", 5)
            ->where("jurnal_type", "bank")
            ->where("debit_credit", 0)
            ->sum('amount');
        $this->data['openingReceipt'] = $receipt + $income + $bank_payment;

        $payments = JournalEntry::whereBetween("assign_date", [$this->beginTime, $this->yesterday])
            ->where("jurnal_type", "payment_made2")
            ->where("account_name_id", 27)
            ->where("debit_credit", 1)
            ->with("paymentMade.customer")
            ->sum('amount');

        $payments_12 = JournalEntry::whereBetween("assign_date", [$this->beginTime, $this->yesterday])
            ->where("jurnal_type", 12)
            ->where("account_name_id", 5)
            ->where("debit_credit", 1)
            ->sum('amount');
        
        $bank_deposit = JournalEntry::whereBetween("assign_date", [$this->beginTime, $this->yesterday])
            ->join("account", "journal_entries.account_name_id", "=", "account.id")
            ->where("account_type_id", 5)
            ->where("jurnal_type", "bank")
            ->where("debit_credit", 1)
            ->sum('amount');
        $this->data['openingPayments'] = $payments + $payments_12 + $bank_deposit;

        return ["openingPurchase" => $purchase,
            "openingSales"            => $sales - $adjustments,
            "openingGeneralExpense"   => $generalExpense + $salesCommission,
            "openingReceipt"          => $receipt + $income + $bank_payment,
            "openingPayments"         => $payments + $payments_12 + $bank_deposit,
        ];

    }

    public function purchase()
    {

        $purchase = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->where("jurnal_type", "bill")
            ->where("account_name_id", 11)
            ->where("debit_credit", 0)
            ->with("bill.customer", "bill.billEntries.item")
            ->get();

        $this->data['purchase'] = $purchase;

        return $purchase;
    }

    public function sales()
    {

        $sales = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->where("jurnal_type", "invoice")
            ->where("account_name_id", 5)
            ->where("debit_credit", 1)
            ->with("invoice.invoiceEntries.item", "invoice.customer")
            ->get();
        $this->data['sales'] = $sales;

        return $sales;
    }

    public function bank()
    {

        $bank = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->join("account", "journal_entries.account_name_id", "=", "account.id")
            ->where("jurnal_type", "bank")
            ->where("account_type_id", 5)
            ->with("bank")
            ->get();
        $this->data['bank'] = $bank;

        return $bank;
    }

    public function generalExpense()
    {
        $generalExpense = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->where("jurnal_type", "expense")
            ->where("debit_credit", 0)
            ->with("expense.account")
            ->get();
        $this->data['generalExpense'] = $generalExpense;

        $sales_commission = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->where("jurnal_type", "sales_commission")
            ->where("account_name_id", 11)
            ->where("debit_credit", 1)
            ->with("SalesCommission.Agents")
            ->get();
        $this->data['sales_commission'] = $sales_commission;
        return ["generalExpense" => $generalExpense, "sales_commission" => $sales_commission];
    }

    public function receipt()
    {
        $receipt = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->where("jurnal_type", "payment_receive2")
            ->where("account_name_id", 10)
            ->where("debit_credit", 0)
            ->with("paymentReceive.paymentContact")
            ->get();
        $this->data['receipt'] = $receipt;

        $income = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->where("jurnal_type", "income")
            ->where("debit_credit", 1)
            ->with("income.account")
            ->get();
        $this->data['income'] = $income;

        return ["receipt" => $receipt, "income" => $income];
    }

    public function totalDue()
    {
        $purchase = JournalEntry::where("jurnal_type", "bill")
            ->where("account_name_id", 11)
            ->where("debit_credit", 0)
            ->with("bill.customer", "bill.billEntries.item")
            ->sum("amount");

        $sales = JournalEntry::where("jurnal_type", "invoice")
            ->where("account_name_id", 5)
            ->where("debit_credit", 1)
            ->with("invoice.invoiceEntries.item", "invoice.customer")
            ->sum("amount");

        $total_due = $purchase - $sales;

        return ["total_due" => $total_due];
    }

    public function totalSales()
    {
        $sales = JournalEntry::where("jurnal_type", "invoice")
            ->where("account_name_id", 5)
            ->where("debit_credit", 1)
            ->with("invoice.invoiceEntries.item", "invoice.customer")
            ->sum("amount");

        $adjustments = JournalEntry::join("invoices","invoices.id","journal_entries.invoice_id")
                              ->where('journal_entries.account_name_id',5)
                              ->where("journal_entries.jurnal_type",'invoice')
                              ->with('invoice')
                              ->selectRaw("sum(invoices.vat_adjustment) + sum(invoices.tax_adjustment) + sum(invoices.others_adjustment) as total")
                              ->get();

        $adjustments = (double)($adjustments[0]->total);

        $sales = $sales - $adjustments;

        return $sales;
    }

    public function totalPurchase()
    {
        $purchase = JournalEntry::where("jurnal_type", "bill")
            ->where("account_name_id", 11)
            ->where("debit_credit", 0)
            ->with("bill.customer", "bill.billEntries.item")
            ->sum("amount");
        return $purchase;
    }

    public function payments()
    {
        $payments = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->where("jurnal_type", "payment_made2")
            ->where("account_name_id", 27)
            ->where("debit_credit", 1)
            ->with("paymentMade.customer")
            ->get();
        $this->data['payments'] = $payments;
        //
        $payments_12 = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->where("jurnal_type", 12)
            ->where("account_name_id", 5)
            ->where("debit_credit", 1)
            ->with("creditNote.customer")
            ->get();
        $this->data['payments_12'] = $payments_12;
        return ["payemnts" => $payments, "payemnts_12" => $payments_12];
    }





    public function bankDebit()
    {
        $bank_deposit = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->join("bank","bank.id","journal_entries.bank_id")
            ->where("jurnal_type", "bank")
            ->where("debit_credit", 1)
            ->where("bank.type", "=", "Deposit")
            ->with("Bank")
            ->get();
        $this->data['debit'] = $bank_deposit;
        return ["bank_deposit" => $bank_deposit];
    }

    public function bankCredit()
    {
        $bank_withdraw = JournalEntry::whereBetween("assign_date", [$this->start, $this->end])
            ->join("bank","bank.id","journal_entries.bank_id")
            ->where("jurnal_type", "bank")
            ->where("debit_credit", 0)
            ->where("bank.type", "=", "Withdrawal")
            ->with("Bank")
            ->get();
        $this->data['credit'] = $bank_withdraw;

        return ["bank_withdraw" => $bank_withdraw];
    }





    public function getUpStairSheet()
    {
        $sheet = [];
        $this->get();
        $sheet["purchase"]             = $this->purchaseParticulars();
        $sheet["totalDue"]             = $this->totalDue();
        $sheet["sales"]                = $this->salesParticulars();
        $sheet["bank"]                 = $this->bankParticulars();
        $sheet["expenseAndCommission"] = $this->expenseParticulars();
        $sheet["expenseAndCommission"] = $this->expenseParticulars();
        $sheet["receiptAndIncome"]     = $this->receiptParticulars();
        $sheet["payment"]              = $this->paymentsParticulars();
        $sheet["invoiceDue"]           = $this->invoiceDue();
        $sheet["billDue"]              = $this->billDue();

        $sheet["bankDebit"]            = $this->bankDebit();
        $sheet["bankCredit"]           = $this->bankCredit();
        $sheet["bankDebitParticular"]  = $this->bankDebitParticular();
        $sheet["bankCreditParticular"] = $this->bankCreditParticular();

        $sheet["totalSales"]     = $this->totalSales();
        $sheet["totalPurchase"]  = $this->totalPurchase();
        $sheet["openingBalance"] = $this->openingBalance();

        //dd($sheet);

        return $sheet;
    }

    public function invoiceDue()
    {
        $due                      = Invoice::sum("due_amount");
        $this->data['invoiceDue'] = $due;
        return $due;
    }

    public function billDue()
    {
        $due = Bill::sum("due_amount");

        $this->data['billDue'] = $due;

        return $due;
    }

    public function purchaseParticulars()
    {
        $data = [];

        foreach ($this->data["purchase"] as $key => $value) {
            $product_name               = [];
            $data[$key]["transaction"]  = "BILL-" . $value->bill["bill_number"];
            $data[$key]["display_name"] = $value->bill["customer"]["display_name"];
            $data[$key]["amount"]       = $value->amount;
            foreach ($value->bill["billEntries"] as $item) {
                $product_name[] = $item["item"]["item_name"] . " || <i>Quantity: " . $item['quantity'] . " x Rate: " . $item["rate"] . " = " . $item['amount'] . "</i>";
            }
            $data[$key]["items"] = implode(",<br/>", array_unique($product_name));
        }
        $this->data['purchaseParticulars'] = $data;
        return $data;
    }

    public function salesParticulars()
    {
        $data = [];
        foreach ($this->data["sales"] as $key => $value) {
            $product_name               = [];
            $data[$key]["transaction"]  = "INV-" . $value["invoice"]["invoice_number"];
            $data[$key]["display_name"] = $value->invoice["customer"]["display_name"];
            foreach ($value->invoice["invoiceEntries"] as $item) {
                $product_name[] = $item["item"]["item_name"] . " || <i>Quantity: " . $item['quantity'] . " x Rate: " . $item["rate"] . " = " . $item['amount'] . "</i>";
            }
            $data[$key]["items"] = implode(",<br/>", array_unique($product_name));

            //Adjustment Calculation
                $vat_adjustment         = ($value["invoice"]["vat_adjustment"]) > 0 ? ($value["invoice"]["vat_adjustment"]) : 0;
                $tax_adjustment         = ($value["invoice"]["tax_adjustment"]) > 0 ? ($value["invoice"]["tax_adjustment"]) : 0;
                $others_adjustment      = ($value["invoice"]["others_adjustment"]) > 0 ? ($value["invoice"]["others_adjustment"]) : 0;

                if($vat_adjustment > 0 || $tax_adjustment > 0 || $others_adjustment > 0){
                    $data[$key]["adjustments"] = "Vat Adjustment (" . $vat_adjustment . ")" . "<br/>" . "Tax Adjustment (" . $tax_adjustment . ")" . "<br/>" . "Others Adjustment (" . $others_adjustment . ")";

                    $data[$key]["amount_string"] = $value->amount . "<br/> -" . $vat_adjustment . "<br/> -" . $tax_adjustment . "<br/> -" . $others_adjustment . "<br/> = ";
                }
            //Adjustment Calculation Ends

            $data[$key]["amount"]       = $value->amount - $vat_adjustment - $tax_adjustment - $others_adjustment;
        }
        $this->data['salesParticulars'] = $data;

        return $data;
    }

    public function bankParticulars()
    {
        $data = [];
        foreach ($this->data["bank"] as $key => $value) {
            $product_name               = [];
            $data[$key]["transaction"]  = "BANK-" . str_pad($value["bank"]["id"], 6, '0', STR_PAD_LEFT);
            $data[$key]["display_name"] = $value->bank["contact"]["display_name"];
            $data[$key]["amount"]       = $value->amount;
            $data[$key]["items"]        = $value->bank["particulars"];
            $data[$key]["debit_credit"] = $value->debit_credit;
        }
        $this->data['bankParticulars'] = $data;

        return $data;
    }

    public function expenseParticulars()
    {
        $data = [];

        foreach ($this->data["generalExpense"] as $key => $value) {
            $product_name               = '';
            $data[$key]["amount"]       = $value->amount;
            $data[$key]["transaction"]  = "EXP-" . str_pad($value["expense"]["expense_number"], 6, '0', STR_PAD_LEFT);
            $data[$key]["display_name"] = $value["expense"]["account"]["account_name"] . " , " . $value["expense"]["reference"];
            $product_name               = $value->expense["customer"]["display_name"];
            $data[$key]["items"]        = $product_name;
        }
        $this->data['expenseParticulars'] = $data;
        $commission                       = $this->salesComissionParticulars();
        return array_merge($data, $commission);
    }

    public function salesComissionParticulars()
    {
        $data = [];
        foreach ($this->data["sales_commission"] as $key => $value) {
            $product_name               = '';
            $data[$key]["amount"]       = $value->amount;
            $data[$key]["transaction"]  = "SC-" . str_pad($value["SalesCommission"]["scNumber"], 6, '0', STR_PAD_LEFT);
            $data[$key]["display_name"] = $value->SalesCommission["Agents"]["display_name"];

            $data[$key]["items"] = $product_name;
        }
        $this->data['salesComissionParticulars'] = $data;

        return $data;
    }

    public function receiptParticulars()
    {
        $data = [];
        foreach ($this->data['receipt'] as $key => $value) {
            $product_name               = '';
            $data[$key]["amount"]       = $value->amount;
            $data[$key]["transaction"]  = "PR-" . str_pad($value["paymentReceive"]["pr_number"], 6, '0', STR_PAD_LEFT);
            $data[$key]["display_name"] = $value->paymentReceive["paymentContact"]["display_name"];
            $data[$key]["items"]        = $product_name;
        }
        $this->data['receiptParticulars'] = $data;
        $income                           = $this->incomeParticulars();
        return array_merge($data, $income);
    }

    public function incomeParticulars()
    {
        $data = [];
        foreach ($this->data['income'] as $key => $value) {
            $product_name               = '';
            $data[$key]["amount"]       = $value->amount;
            $data[$key]["transaction"]  = "INC-" . str_pad($value["income"]["income_number"], 6, '0', STR_PAD_LEFT);
            $data[$key]["display_name"] = $value->income["account"]["account_name"];
            $data[$key]["items"]        = $product_name;
        }
        $this->data['incomeParticulars'] = $data;

        return $data;
    }

    public function paymentsParticulars()
    {
        $data = [];
        foreach ($this->data['payments'] as $key => $value) {
            $product_name               = '';
            $data[$key]["amount"]       = $value->amount;
            $data[$key]["transaction"]  = "PM-" . str_pad($value["paymentMade"]["pm_number"], 6, '0', STR_PAD_LEFT);
            $data[$key]["display_name"] = $value->paymentMade["customer"]["display_name"];
            $data[$key]["items"]        = $product_name;
        }
        $this->data['paymentsParticulars'] = $data;
        $payments_12                       = $this->payments_12Particulars();
        return array_merge($data, $payments_12);
    }

    public function payments_12Particulars()
    {
        $data = [];
        foreach ($this->data['payments_12'] as $key => $value) {
            $product_name               = '';
            $data[$key]["amount"]       = $value->amount;
            $data[$key]["transaction"]  = "CN-" . str_pad($value["creditNote"]["credit_note_number"], 6, '0', STR_PAD_LEFT);
            $data[$key]["display_name"] = $value->creditNote["customer"]["display_name"];

            $data[$key]["items"] = $product_name;
        }
        $this->data['payments_12Particulars'] = $data;

        return $data;
    }

    public function bankDebitParticular()
    {
        $data = [];
        foreach ($this->data['debit'] as $key => $value) {
            $product_name               = '';
            $data[$key]["amount"]       = $value->amount;
            $data[$key]["transaction"]  = "BANK-" . str_pad($value["bank"]["id"], 6, '0', STR_PAD_LEFT);
            $data[$key]["display_name"] = $value->bank["particulars"].($value->bank["cheque_number"]);
            $data[$key]["items"]        = $product_name;
        }
        $this->data['bankParticular'] = $data;
        return $data;
    }
    public function bankCreditParticular()
    {
        $data = [];
        foreach ($this->data['credit'] as $key => $value) {
            $product_name               = '';
            $data[$key]["amount"]       = $value->amount;
            $data[$key]["transaction"]  = "BANK-" . str_pad($value["bank"]["id"], 6, '0', STR_PAD_LEFT);
            $data[$key]["display_name"] = $value->bank["particulars"].($value->bank["cheque_number"]);
            $data[$key]["items"]        = $product_name;
        }
        $this->data['bankCreditParticular'] = $data;
        return $data;
    }
}
